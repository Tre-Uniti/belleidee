<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Http\Requests\SponsorRequest;
use App\Http\Requests\PhotoUploadRequest;
use App\Post;
use App\Sponsor;
use App\Sponsorship;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    private $sponsor;

    public function __construct(Sponsor $sponsor)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['index', 'show', 'sponsorship']]);
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $sponsors = $this->sponsor->latest()->paginate(10);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('sponsors.index')
            ->with(compact('user', 'sponsors', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('sponsors.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SponsorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request)
    {
        $sponsor = new Sponsor;
        $sponsor->name = $request['name'];
        $sponsor->website = $request['website'];
        $sponsor->phone = $request['phone'];
        $sponsor->email = $request['email'];
        $sponsor->budget = $request['budget'];
        $sponsor->country = $request['country'];
        $sponsor->city = $request['city'];
        $sponsor->status = 'Active';
        $sponsor->views = 0;
        $sponsor->triggers = 0;
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
            $imageFileName = $sponsorName . '.' . $image->getClientOriginalExtension();
            $path = '/sponsor_photos/'. $sponsor->id . '/' .$imageFileName;

            Storage::put($path, file_get_contents($image));
            $sponsor->where('id', $sponsor->id)
                ->update(['photo_path' => $path]);
        }

        flash()->overlay('Sponsor has been created.');
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $sponsor = $this->sponsor->findOrFail($id);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('sponsors.show')
            ->with(compact('user', 'sponsor', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('sponsors.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'))
            ->with('photoPath', $photoPath);
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
            $imageFileName = $sponsorName . '.' . $image->getClientOriginalExtension();
            $path = '/sponsor_photos/'. $sponsor->id . '/' .$imageFileName;

            Storage::put($path, file_get_contents($image));
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
        //
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

            flash()->overlay('Your first sponsorship has started!');
        }
        else
        {
            //Delete old Sponsorship
            Sponsorship::where('user_id', '=', $user->id)->delete();
            //Create new Sponsorship
            $sponsorship = new Sponsorship;
            $sponsorship->sponsor_id = $sponsor->id;
            $sponsorship->user_id = $user->id;
            $sponsorship->save();

            flash()->overlay('Your sponsorship has started!');
        }
        return redirect('users/'. $user->id);
    }

    //Page to supply sponsor payments
    public function pay($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        return view('sponsors.pay')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'));

    }

    //Handle payment of sponsor
    public function payment(Request $request)
    {
        $messageTitle = '';
        $message = '';

        if (Input::has('stripeToken')) {
            $token = Input::get('stripeToken');
            if (Input::has('email')) {
                $email = Input::get('email');
                if (Input::has('amount')) {
                    $amount = Input::get('amount');
                    if (Input::has('description')) {
                        $description = Input::get('description');
                        try {
                            $customerList = Stripe_Customer::all();
                            $customers = $customerList->data;
                            $customer = null;

                            if (!empty($customers)) {
                                foreach ($customers as $person) {
                                    if ($person->email == $email) {
                                        $customer = $person;
                                    }
                                }
                                if (empty($customer)) {
                                    $customer = Stripe_Customer::create(array(
                                        'email' => $email,
                                        'card' => $token
                                    ));
                                }
                            } else {
                                $customer = Stripe_Customer::create(array(
                                    'email' => $email,
                                    'card' => $token
                                ));
                            }
                            $charge = Stripe_Charge::create(array(
                                'customer' => $customer->id,
                                'amount' => ($amount * 100),
                                'currency' => 'usd',
                                'description' => $description
                            ));
                        } catch (Stripe_CardError $e) {
                            $messageTitle = 'Card Declined';
                            // Since it's a decline, Stripe_CardError will be caught
                            $body = $e->getJsonBody();
                            $err = $body['error'];
                            $message = $err['message'];
                        } catch (Stripe_InvalidRequestError $e) {
                            // Invalid parameters were supplied to Stripe's API
                            $messageTitle = 'Oops...';
                            $message = 'It looks like my payment processor encountered an error with the payment information. Please contact me before re-trying.';
                        } catch (Stripe_AuthenticationError $e) {
                            // Authentication with Stripe's API failed
                            // (maybe you changed API keys recently)
                            $messageTitle = 'Oops...';
                            $message = 'It looks like my payment processor API encountered an error. Please contact me before re-trying.';
                        } catch (Stripe_ApiConnectionError $e) {
                            // Network communication with Stripe failed
                            $messageTitle = 'Oops...';
                            $message = 'It looks like my payment processor encountered a network error. Please contact me before re-trying.';
                        } catch (Stripe_Error $e) {
                            // Display a very generic error to the user, and maybe send
                            // yourself an email
                            $messageTitle = 'Oops...';
                            $message = 'It looks like my payment processor encountered an error. Please contact me before re-trying.';
                        } catch (Exception $e) {
                            // Something else happened, completely unrelated to Stripe
                            $messageTitle = 'Oops...';
                            $message = 'It appears that something went wrong with your payment. Please contact me before re-trying.';
                        }
                    } else {
                        $messageTitle = 'You must enter a payment description.';
                    }
                } else {
                    $messageTitle = 'You must enter a valid amount.';
                }
            } else {
                $messageTitle = 'You must enter a valid email address.';
            }
        }
    }
}
