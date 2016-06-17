<?php

namespace App\Http\Controllers;

use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\PromotionRequest;
use App\Promotion;
use App\Sponsor;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    private $promotion;

    public function __construct(Promotion $promotion)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('promotionOwner', ['only' => 'edit', 'update', 'destroy']);
        $this->promotion = $promotion;
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view('promotions/create')
            ->with(compact('user', 'sponsor', 'profilePosts', 'profileExtensions'));

    }

    /*
     * Store a newly created promotion in storage
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionRequest $request)
    {
        $promotion = new Promotion($request->except('sponsor_id'));
        $sponsor = Sponsor::findOrFail($request->sponsor_id);
        $promotion->sponsor()->associate($sponsor);
        $promotion->save();

        flash()->overlay('Promotion successfully added');
        return redirect('/promotion/'. $promotion->id);
    }

    /*
     * Display the specificed promotion
     */
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view('promotions.show')
            ->with(compact('user', 'promotion', 'profilePosts', 'profileExtensions'));
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view('promotions/edit')
            ->with(compact('user', 'promotion', 'sponsor', 'profilePosts', 'profileExtensions'));
    }

    /*
     *  Update an existing promotion for a sponsor
     */
    public function update(PromotionRequest $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update($request->all());

        flash()->overlay('Promotion has been updated');

        return redirect('promotions/'. $promotion->id);
    }

}
