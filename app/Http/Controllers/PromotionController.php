<?php

namespace App\Http\Controllers;

use function App\Http\autolink;
use function App\Http\filterContentLocation;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\PromotionRequest;
use App\Promotion;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class PromotionController extends Controller
{
    private $promotion;

    public function __construct(Promotion $promotion)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('promotionOwner', ['only' => 'edit', 'update', 'destroy', 'sponsorIndex']);
        $this->promotion = $promotion;
    }

    /*
     * Index for all promotions
     *
     * @param $id
     */
    public function index()
    {
        $user = Auth::user();

        $promotions = filterContentLocation($user, 1, 'Promotion');
        $location = getLocation();

        return view('promotions.index')
            ->with(compact('user', 'promotions', 'sponsor', 'eligibleUser'))
            ->with('location', $location);

    }

    /*
     * Create new promotion for a sponsor
     *
     * @param $id
     */
    public function create($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        $user = Auth::user();

        $statuses = [
            'Eligible Only' => 'Eligible Only',
            'Open to All' => 'Open to All',
            'Closed' => 'Closed'
        ];

        return view('promotions/create')
            ->with(compact('user', 'sponsor', 'profilePosts', 'profileExtensions'))
            ->with('statuses', $statuses);

    }

    /*
     * Store a newly created promotion in storage
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionRequest $request)
    {

        $promotion = new Promotion($request->except('sponsor_id', 'description'));
        $description = Purifier::clean($request->input('description'));
        $promotion->description = $description;
        $sponsor = Sponsor::findOrFail($request->sponsor_id);
        $promotion->sponsor()->associate($sponsor);
        $promotion->save();

        flash()->overlay('Promotion successfully added');
        return redirect('/promotions/'. $promotion->id);
    }

    /*
     * Display the specific promotion
     */
    public function show($id)
    {
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $user = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $user = User::where('handle', '=', 'Transferred')->first();
            $user->handle = 'Guest';
        }

        $promotion = Promotion::findOrFail($id);

        if($user->type < 3)
        {
            if($promotion->status == 'closed' && $user->id != $promotion->sponsor->user_id)
            {
                flash()->overlay('Must be the manager of this sponsor or be an admin to view');
                return redirect('sponsors/'. $promotion->sponsor->id);
            }
            elseif($promotion->status == 'Eligible Only' && $user->id != $promotion->sponsor->user_id)
            {
                //User must have sponsorship for at least 7 days
                $date = Carbon::today()->subDays(7);
                $eligibleUser = Sponsorship::where('user_id', '=', $user->id)->where('sponsor_id', '=', $promotion->sponsor_id)->where('created_at', '<=', $date )->first();
                if(!count($eligibleUser))
                {
                    flash()->overlay('Not eligible to view this promo (must be sponsored for 7+ days');
                    return redirect('sponsors/' . $promotion->sponsor->id);
                }
            }
        }

        $promotion->description = autolink($promotion->description, array("target"=>"_blank","rel"=>"nofollow"));

        return view('promotions.show')
            ->with(compact('user', 'promotion', 'eligibleUser'));
    }

    /*
     *  Edit an existing promotion for a sponsor
     *
     * @param $id
     */
    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);

        $sponsor = Sponsor::findOrFail($promotion->sponsor_id);

        $user = Auth::user();

        $statuses = [
            'Eligible Only' => 'Eligible Only',
            'Open to All' => 'Open to All',
            'Closed' => 'Closed'
        ];


        return view('promotions/edit')
            ->with(compact('user', 'promotion', 'sponsor'))
            ->with('statuses', $statuses);
    }

    /*
     *  Update an existing promotion for a sponsor
     */
    public function update(PromotionRequest $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $description = Purifier::clean($request->input('description'));
        $promotion->description = $description;
        $promotion->update($request->except('description'));

        flash()->overlay('Promotion has been updated');

        return redirect('promotions/'. $promotion->id);
    }

    /*
     * List all promotions for a given sponsor
     *
     * @param $id
     */
    public function sponsorIndex($id)
    {
        $user = Auth::user();

        $sponsor = Sponsor::findOrFail($id);

        $promotions = Promotion::where('sponsor_id', '=', $sponsor->id)->where('status', '!=', 'Closed')->paginate(10);
        //User must have sponsorship for at least 7 days
        $date = Carbon::today()->subDays(7);
        try
        {
            $eligibleUser = Sponsorship::where('user_id', '=', $user->id)->where('sponsor_id', '=', $sponsor->id)->first();

        }
        catch(ModelNotFoundException $e)
        {
            $eligibleUser = NULL;
            flash()->overlay('Must be sponsored for 7 days to view');
            return redirect('sponsors/'. $sponsor->sponsor_tag);
        }

        if($eligibleUser != NULL && $eligibleUser->created_at <= $date)
        {
            $eligibleUser = 'yes';
        }
        elseif($eligibleUser != NULL && $eligibleUser->created_at > $date)
        {
            flash()->overlay('Must be sponsored for 7 days to view');
            return redirect('sponsors/'. $sponsor->sponsor_tag);
        }


        return view('promotions/sponsorIndex')
            ->with(compact('user', 'promotions', 'sponsor', 'eligibleUser'));
    }

}
