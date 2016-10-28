<?php

namespace App\Http\Controllers;

use App\BeaconRequest;
use App\Extension;
use function App\Http\getBeliefs;
use function App\Http\getCountries;
use App\Intolerance;
use App\Moderation;
use App\Post;
use App\SponsorRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display Admin Portal.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal()
    {
        $user = Auth::user();
        $users = User::where('type', '>' , 2)->latest()->paginate(10);

        return view ('admin.portal')
            ->with(compact('user', 'users'));
    }

    /**
     * Display a listing of Beacon Requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBeaconRequests()
    {
        $user = Auth::user();

        $beaconRequests = BeaconRequest::latest()->paginate(10);

        return view ('admin.beaconRequests')
            ->with(compact('user', 'beaconRequests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewBeaconRequest($id)
    {
        $user = Auth::user();
        $beaconRequest = BeaconRequest::findOrFail($id);
        
        $admins = User::where('type', '>', 1)->get();
        $status = [
            'Requested' => 'Requested',
            'Open' => 'Open',
            'Contacted' => 'Contacted',
            'Meeting' => 'Meeting',
            'Signup' => 'Signup',
        ];

        return view('admin.beaconReview')
            ->with(compact('user', 'beaconRequest', 'admins', 'status'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editBeaconRequest($id)
    {
        $user = Auth::user();

        $beaconRequest = BeaconRequest::findOrFail($id);

        //Get list of Admin users and format for drop-down list
        $users = User::where('type', '>', 1)->get();
        $admins = array('Tre-Uniti' => 'Tre-Uniti');
        foreach ($users as $user)
        {
            $admins = array_add($admins, $user->handle, $user->handle);
        }

        $status = [
            'Requested' => 'Requested',
            'Open' => 'Open',
            'Contacted' => 'Contacted',
            'Meeting' => 'Meeting',
            'Signup' => 'Signup',
            'Refused' => 'Refused',
        ];
        $beliefs = getBeliefs();
        $countries = getCountries();

        return view('admin.editBeaconRequest')
            ->with(compact('user', 'beaconRequest', 'admins', 'status', 'beliefs', 'countries'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBeaconRequest(Request $request, $id)
    {
        //$beaconRequest = BeaconRequest::findOrFail($request['beaconRequestId']);
        $beaconRequest = BeaconRequest::findOrFail($id);
        $beaconRequest->update($request->all());

        flash()->overlay('Beacon Request has been updated');

        return redirect('admin/beacon/review/'. $beaconRequest->id);
    }

    /**
     * Add extra fields for conversion of Request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertBeaconRequest($id)
    {
        $user = Auth::user();
        $beaconRequest = BeaconRequest::findOrFail($id);

        $beliefs = getBeliefs();
        $countries = getCountries();
        
        return view('admin.convertBeacon')
            ->with(compact('user', 'beaconRequest', 'countries'))
            ->with('beliefs', $beliefs);
    }

    /**
     * Display a listing of Beacon Requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSponsorRequests()
    {
        $user = Auth::user();

        $sponsorRequests = SponsorRequest::latest()->paginate(10);

        return view ('admin.sponsorRequests')
            ->with(compact('user', 'sponsorRequests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewSponsorRequest($id)
    {
        $user = Auth::user();

        $sponsorRequest = SponsorRequest::findOrFail($id);

        return view('admin.sponsorReview')
            ->with(compact('user', 'sponsorRequest'));
    }

    /**
     * Add extra fields for conversion of Request.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convertSponsorRequest($id)
    {
        $user = Auth::user();

        $sponsorRequest = SponsorRequest::findOrFail($id);

        $countries = getCountries();

        return view('admin.convertSponsor')
            ->with(compact('user', 'sponsorRequest', 'countries'));
    }

}
