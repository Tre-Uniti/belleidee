<?php

namespace App\Http\Controllers;

use App\Extension;
use function App\Http\getCountries;
use App\Http\Requests\CreateBasicSponsorRequest;
use App\Http\Requests\CreateSponsorRequest;
use App\Mailers\NotificationMailer;
use App\Post;
use App\Sponsor;
use App\SponsorRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Response;

class SponsorRequestController extends Controller
{
    private $sponsorRequest;

    public function __construct(SponsorRequest $sponsorRequest)
    {
        $this->middleware('auth', ['except' => 'agreement']);
        $this->middleware('admin', ['only' => 'convert', 'destroy']);
        $this->middleware('sponsorRequestOwner', ['only' => 'show', 'edit']);
        $this->sponsorRequest = $sponsorRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $sponsorRequests = $this->sponsorRequest->where('user_id', '=', $user->id)->paginate(10);

        return view ('sponsorRequests.index')
            ->with(compact('user', 'sponsorRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        //Get countries for drop down select
        $countries = getCountries();

        return view('sponsorRequests.create')
            ->with(compact('user'))
            ->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBasicSponsorRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBasicSponsorRequest $request)
    {
        $user = Auth::user();

        $sponsorRequest = new SponsorRequest($request->all());
        $sponsorRequest->user()->associate($user->id);
        $sponsorRequest->save();

        flash()->overlay('Your sponsor request has been created');
        return redirect('sponsorRequests/'. $sponsorRequest->id);
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

        $sponsorRequest = $this->sponsorRequest->findOrFail($id);

        return view('sponsorRequests.show')
            ->with(compact('user', 'sponsorRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get BeaconRequest requested for editing
        $sponsorRequest = $this->sponsorRequest->findOrFail($id);

        $user = Auth::user();

        //Get countries for drop down select
        $countries = getCountries();

        return view('sponsorRequests.edit')
            ->with(compact('user', 'sponsorRequest'))
            ->with('countries', $countries);
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
        $sponsorRequest = $this->sponsorRequest->findOrFail($id);
        $sponsorRequest->update($request->all());

        flash()->overlay('Sponsor Request has been updated');

        return redirect('sponsorRequests/'. $sponsorRequest->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, NotificationMailer $mailer)
    {
        $sponsorRequest = SponsorRequest::findOrFail($id);
        $user = User::findOrFail($sponsorRequest->user_id);
        $sponsorName = $sponsorRequest->name;
        $sponsorRequest->delete();

        $mailer->sendSponsorDeletedNotification($user, $sponsorName);

        flash()->overlay('Sponsor Request has been deleted');
        return redirect('admin/sponsor/requests');
    }

    /**
     * Convert request to Sponsor.
     *
     * @param CreateSponsorRequest $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function convert(CreateSponsorRequest $request, NotificationMailer $mailer)
    {
        $sponsorRequest = SponsorRequest::findOrFail($request['sponsorRequestId']);
        $user = User::findOrFail($sponsorRequest->user_id);

        $sponsor = new Sponsor($request->except('sponsorRequestId'));
        $sponsor->status = 'active';
        $sponsor->save();

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

        //Notify requester their request is now a Beacon!
        $mailer->sendSponsorCreatedNotification($user, $sponsor);

        //Delete beacon request as it is now a beacon
        $sponsorRequest->delete();

        flash()->overlay('Sponsor Request has been converted');
        return redirect('sponsors/'. $sponsor->id);
    }

    /*
    * Return the Belle-Idee Sponsor Agreement
    */
    public function agreement()
    {
        $filename = 'SponsorAgreement.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }
}
