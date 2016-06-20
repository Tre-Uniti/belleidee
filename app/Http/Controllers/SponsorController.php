<?php

namespace App\Http\Controllers;

use App\Events\SponsorViewed;
use App\Extension;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationSearch;
use function App\Http\getCountries;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\CreateSponsorRequest;
use App\Http\Requests\SponsorRequest;
use App\Http\Requests\PhotoUploadRequest;
use App\Post;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Stripe;
use Event;

class SponsorController extends Controller
{
    private $sponsor;

    public function __construct(Sponsor $sponsor)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['create', 'store', 'edit', 'update', 'destroy', 'pay', 'payment']]);
        $this->middleware('sponsorAdmin', ['only' => ['eligible', 'eligibleSearch']]);
        $this->sponsor = $sponsor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsors = filterContentLocation($user, 1, 'Sponsor');
        $location = getLocation();

        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $userSponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            Event::fire(new SponsorViewed($userSponsor));
        }

        return view ('sponsors.index')
            ->with(compact('user', 'sponsors', 'profilePosts','profileExtensions', 'userSponsor'))
            ->with('location', $location);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $countries = getCountries();

        return view('sponsors.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateSponsorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSponsorRequest $request)
    {
        $sponsor = new Sponsor;
        $sponsor->name = $request['name'];
        $sponsor->address = $request['address'];
        $sponsor->website = $request['website'];
        $sponsor->phone = $request['phone'];
        $sponsor->email = $request['email'];
        $sponsor->budget = $request['budget'];
        $sponsor->country = $request['country'];
        $sponsor->city = $request['city'];
        $sponsor->status = 'Live';
        $sponsor->views = 0;
        $sponsor->save();

        //Save Sponsor image and update path in DB
        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            $image = $request->file('image');

            $sponsorName = str_replace(' ', '_', $sponsor->name);
            $imageFileName = $sponsorName . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/sponsor_photos/'. $sponsor->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            Storage::put($path, $imageResized->__toString());
            $sponsor->where('id', $sponsor->id)
                ->update(['photo_path' => $path]);
        }

        flash()->overlay('Sponsor has been created');
        return redirect('sponsors/photo/'. $sponsor->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = $this->sponsor->findOrFail($id);
        Event::fire(new SponsorViewed($sponsor));

        $location = 'http://www.google.com/maps/place/'. $sponsor->lat . ','. $sponsor->long;

        return view ('sponsors.show')
            ->with(compact('user', 'sponsor', 'profilePosts','profileExtensions'))
            ->with('location', $location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Sponsor requested for editing
        $sponsor = $this->sponsor->findOrFail($id);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $countries = getCountries();

        return view('sponsors.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sponsor = $this->sponsor->findOrFail($id);
        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            $image = $request->file('image');

            $sponsorName = str_replace(' ', '_', $sponsor->name);
            $imageFileName = $sponsorName . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/sponsor_photos/'. $sponsor->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //Add new photo
            Storage::put($path, $imageResized->__toString());

            //Remove old photo from storage (S3)
            Storage::delete($sponsor->photo_path);

            //Set new path for database
            $sponsor->photo_path = $path;
        }
        $sponsor->update($request->all());
        flash()->overlay('Sponsor has been updated');

        return redirect('sponsors/'. $sponsor->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        //Delete Sponsorships
        //Send notification to users for new sponsor
    }

    /**
     * Start a new Sponsorship.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sponsorship($id)
    {
        $sponsor = $this->sponsor->findOrFail($id);
        $user = Auth::user();

        //Check if user already has a sponsor
        $exists = Sponsorship::where('user_id', $user->id)->first();
        if(!$exists)
        {
            //Create new Sponsorship
            $sponsorship = new Sponsorship;
            $sponsorship->sponsor_id = $sponsor->id;
            $sponsorship->user_id = $user->id;
            $sponsorship->save();

            //Update sponsor with new sponsorship
            $sponsor->sponsorships = $sponsor->sponsorships + 1;
            $sponsor->update();

            flash()->overlay('Your first sponsorship has started!');
        }
        else
        {
            //Subtract 1 from past sponsor
            $oldSponsor = Sponsor::where('id', '=', $exists->sponsor_id)->first();
            if ($oldSponsor->id != $sponsor->id)
            {
                $oldSponsor->sponsorships = $oldSponsor->sponsorships - 1;
                $oldSponsor->update();
                //Update new sponsor with sponsorship
                $sponsor->sponsorships = $sponsor->sponsorships + 1;
                $sponsor->update();

            }

            //Delete old Sponsorship
            Sponsorship::where('user_id', '=', $user->id)->delete();

            //Create new Sponsorship
            $sponsorship = new Sponsorship;
            $sponsorship->sponsor_id = $sponsor->id;
            $sponsorship->user_id = $user->id;
            $sponsorship->save();

            flash()->overlay('Your sponsorship has started!');
        }
        return redirect('sponsors/'. $sponsor->id);
    }

    /*
     * Show sponsorships for a given sponsor
     */
    public function sponsorships($id)
    {
        $sponsor = Sponsor::findOrfail($id);
        $sponsorships = Sponsorship::where('sponsor_id', '=', $sponsor->id)->paginate(10);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $location = 'http://www.google.com/maps/place/'. $sponsor->lat . ','. $sponsor->long;

        return view('sponsors/sponsorships')
            ->with(compact('user', 'sponsorships', 'sponsor', 'profilePosts', 'profileExtensions'))
            ->with('location', $location);
    }

    //Page to supply sponsor payments
    public function pay($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        //Customer exists charge card on file
        $amount = $sponsor->views * .5 + $sponsor->clicks * 5;
        $amount = floor($amount * 1);
        if ($sponsor->customer_id != NULL) {
            $stripe = [
                'secret_key' => env('STRIPE_SECRET'),
                'publishable_key' => env('STRIPE_KEY')
            ];
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            $charge = \Stripe\Charge::create(array(
                'customer' => $sponsor->customer_id,
                'amount' => $amount,
                'currency' => 'usd',
                'description' => $sponsor->name
            ));

            //Update sponsor with new views, missed and status to live
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => 0, 'clicks' => 0, 'missed' => 0,  'status' => 'Live']);

            flash()->overlay('Payment successful: views, clicks, missed reset');

            return redirect('sponsors/' . $sponsor->id);
        }

        return view('sponsors.pay')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'));

    }

    /**
     * Charge monthly use for Sponsor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $token = $request['stripeToken'];
        $sponsorId = $request['sponsor'];

        $sponsor = Sponsor::findOrFail($sponsorId);

        $stripe = [
            'secret_key'      => env('STRIPE_SECRET'),
            'publishable_key' => env('STRIPE_KEY')
        ];

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        //Calculate amount per view (.5 cents) + per click (5 cents)
        $amount = $sponsor->views * .5 + $sponsor->clicks * 5;
        $amount = floor($amount * 1);
        //Add 8.25% sales tax for Washington State
        //$taxes = $amount * .0825;

        if ($sponsor->customer_id == NULL)
        {
            $customer = \Stripe\Customer::create(array(
                'email' => $sponsor->email,
                'card'  => $token

            ));
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $amount,
                'currency' => 'usd',
                'description' => $sponsor->name
            ));

            //Update sponsor with new views, missed, status to live and stripe customer id
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => 0, 'clicks' => 0, 'missed' => 0, 'status' => 'Live', 'customer_id' => $customer->id]);
        }
        else
        {

            $charge = \Stripe\Charge::create(array(
                'customer' => $sponsor->customer_id,
                'amount'   => $amount,
                'currency' => 'usd',
                'description' => $sponsor->name
            ));

            //Update sponsor with new views, missed and status to live
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => 0, 'clicks' => 0, 'missed' => 0, 'status' => 'Live']);
        }

        flash()->overlay('Payment successful: views, clicks, missed reset to 0');

        return redirect('sponsors/'. $sponsor->id);
    }

    /**
     * Display the search page for Sponsors.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $types = [
            'Name' => 'Name',
        ];
        $location = getLocation();

        return view ('sponsors.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('types', $types)
            ->with('location', $location);
    }

    /**
     * Display the results page for a search on Sponsors.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        
        $identifier = $request->input('identifier');

        $results = filterContentLocationSearch($user, 0, 'Sponsor', $identifier);

        if(!count($results))
        {
            flash()->overlay('No Sponsors with this name or location');
            return redirect()->back();
        }

        return view ('sponsors.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('identifier', $identifier);
    }

    /**
     * Display a top beacons by usage.
     *
     * @return \Illuminate\Http\Response
     */
    public function topUsage()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsors = filterContentLocationAllTime($user, 0, 'Sponsor', 'sponsorships');
        $location = getLocation();

        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $userSponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            Event::fire(new SponsorViewed($userSponsor));
        }

        return view ('sponsors.top')
            ->with(compact('user', 'sponsors', 'profilePosts','profileExtensions', 'userSponsor'))
            ->with('location', $location);
    }

    /*
     * Charge Sponsor for a click and redirect to their page
     *
     * @param $id
     */
    public function click($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $sponsor->where('id', $sponsor->id)
            ->update(['clicks' => $sponsor->clicks + 1]);

        return redirect('sponsors/'. $sponsor->id);
    }

   /*
    * List users who are eligible for a promotion
    *
    * @param $id
    */
    public function eligible($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        //User must have sponsorship for at least 7 days
        $date = Carbon::today()->subDays(7);

        $sponsorships = Sponsorship::where('sponsor_id', '=', $sponsor->id)->where('created_at', '<=', $date )->paginate();
        $eligibleCount = count($sponsorships);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $location = 'http://www.google.com/maps/place/'. $sponsor->lat . ','. $sponsor->long;

        return view('sponsors/eligible')
                ->with(compact('user', 'sponsor', 'sponsorships', 'profilePosts', 'profileExtensions'))
                ->with('location', $location)
                ->with('eligibleCount', $eligibleCount);
    }

    /*
    * Search eligible sponsorships for specific user
    *
    * @param $id
    */
    public function eligibleSearch($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        //User must have sponsorship for at least 7 days
        $date = Carbon::today()->subDays(7);

        $sponsorships = Sponsorship::where('sponsor_id', '=', $sponsor->id)->where('created_at', '<=', $date )->paginate();
        $eligibleCount = count($sponsorships);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $location = 'http://www.google.com/maps/place/'. $sponsor->lat . ','. $sponsor->long;

        return view('sponsors/eligibleSearch')
            ->with(compact('user', 'sponsor', 'sponsorships', 'profilePosts', 'profileExtensions'))
            ->with('location', $location)
            ->with('eligibleCount', $eligibleCount);
    }

    /**
     * Display the results page for a search on eligible Sponsorships.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function eligibleResults(Request $request)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $sponsorId = $request->input('sponsorId');
        $sponsor = Sponsor::findOrFail($sponsorId);

        //Verify user is admin or admin for sponsor
        if($user->type <= 1 && $user->id != $sponsor->user_id)
        {
            flash()->overlay('You must be an admin or the owner of this sponsor to view');
            return redirect('sponsors/'. $sponsor->id); // Not the Owner! Redirect back.
        }

        $location = 'http://www.google.com/maps/place/'. $sponsor->lat . ','. $sponsor->long;

        $handle = $request->input('handle');
        try
        {
            $searchUser = User::where('handle', 'LIKE', '%' .$handle . '%')->first();
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No User with this handle');
            return redirect()->back();
        }

        //User must have sponsorship for at least 7 days
        $date = Carbon::today()->subDays(7);

        $results = Sponsorship::where('user_id', '=', $searchUser->id)->where('sponsor_id', '=', $sponsorId)->where('created_at', '<=', $date )->paginate();

        if(!count($results))
        {
            flash()->overlay('No Eligible user with this handle');
            return redirect()->back();
        }
        else
        {
            $eligibleCount = count($results);
        }

        return view ('sponsors.eligibleResults')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results', 'sponsor'))
            ->with('handle', $handle)
            ->with('location', $location)
            ->with('eligibleCount', $eligibleCount);
    }

}
