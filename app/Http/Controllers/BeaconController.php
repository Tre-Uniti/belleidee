<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Http\Requests\CreateBeaconRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Extension;
use App\Beacon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BeaconController extends Controller
{
    private $beacon;

    public function __construct(Beacon $beacon)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'create', 'update', 'edit']);
        $this->beacon = $beacon;
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
        $beacons = $this->beacon->latest()->paginate(10);

        return view ('beacons.index')
                    ->with(compact('user', 'beacons', 'profilePosts','profileExtensions'));
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
        $beliefs =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Indigenous' => 'Indigenous',
                'Judaism' => 'Judaism',
                'Shinto' => 'Shinto',
                'Sikhism' => 'Sikhism',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia',
                'Zoroastrianism' => 'Zoroastrianism',
                'Other' => 'Other'
            ];
        $countries =
            [
                'Select a Country' => 'Select a Country',
                'Ascension Island' => 'Ascension Island',
                'Andorra' => 'Andorra',
                'United Arab Emirates' => 'United Arab Emirates',
                'Afghanistan' => 'Afghanistan',
                'Antigua And Barbuda' => 'Antigua And Barbuda',
                'Anguilla' => 'Anguilla',
                'Albania' => 'Albania',
                'Armenia' => 'Armenia',
                'Netherlands Antilles' => 'Netherlands Antilles',
                'Angola' => 'Angola',
                'Antarctica' => 'Antarctica',
                'Argentina' => 'Argentina',
                'American Samoa' => 'American Samoa',
                'Austria' => 'Austria',
                'Australia' => 'Australia',
                'Aruba' => 'Aruba',
                'Azerbaijan' => 'Azerbaijan',
                'Bosnia And Herzegovina' => 'Bosnia / Herzegovina',
                'Barbados' => 'Barbados',
                'Belgium' => 'Belgium',
                'Bangladesh' => 'Bangladesh',
                'Burkina Faso' => 'Burkina Faso',
                'Bulgaria' => 'Bulgaria',
                'Bahrain' => 'Bahrain',
                'Burundi' => 'Burundi',
                'Benin' => 'Benin',
                'Bermuda' => 'Bermuda',
                'Brunei Darussalam' => 'Brunei Darussalam',
                'Bolivia' => 'Bolivia',
                'Brazil' => 'Brazil',
                'Bahamas' => 'Bahamas',
                'Bhutan' => 'Bhutan',
                'Bouvet Island' => 'Bouvet Island',
                'Botswana' => 'Botswana',
                'Belarus' => 'Belarus',
                'Belize' => 'Belize',
                'Canada' => 'Canada',
                'Cocos (Keeling) Islands' => 'Cocos (Keeling) Islands',
                'Congo (Democratic Republic)' => 'Congo (Democratic Republic)',
                'Central African Republic' => 'Central African Republic',
                'Congo (Republic)' => 'Congo (Republic)',
                'Switzerland' => 'Switzerland',
                'Cote DÃ¢â‚¬â„¢Ivoire' => 'Cote DÃ¢â‚¬â„¢Ivoire',
                'Cook Islands' => 'Cook Islands',
                'Chile' => 'Chile',
                'Cameroon' => 'Cameroon',
                'Peoples Republic of China' => 'Peoples Republic of China',
                'Colombia' => 'Colombia',
                'Costa Rica' => 'Costa Rica',
                'Cuba' => 'Cuba',
                'Cape Verde' => 'Cape Verde',
                'Christmas Island' => 'Christmas Island',
                'Cyprus' => 'Cyprus',
                'Czech Republic' => 'Czech Republic',
                'Germany' => 'Germany',
                'Djibouti' => 'Djibouti',
                'Denmark' => 'Denmark',
                'Dominica' => 'Dominica',
                'Dominican Republic' => 'Dominican Republic',
                'Algeria' => 'Algeria',
                'Ecuador' => 'Ecuador',
                'Estonia' => 'Estonia',
                'Egypt' => 'Egypt',
                'Eritrea' => 'Eritrea',
                'Spain' => 'Spain',
                'Ethiopia' => 'Ethiopia',
                'European Union' => 'European Union',
                'Finland' => 'Finland',
                'Fiji' => 'Fiji',
                'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)',
                'Micronesia, Federated States Of' => 'Micronesia, Federated States Of',
                'Faroe Islands' => 'Faroe Islands',
                'France' => 'France',
                'Gabon' => 'Gabon',
                'United Kingdom' => 'United Kingdom',
                'Grenada' => 'Grenada',
                'Georgia' => 'Georgia',
                'French Guiana' => 'French Guiana',
                'Guernsey' => 'Guernsey',
                'Ghana' => 'Ghana',
                'Gibraltar' => 'Gibraltar',
                'Greenland' => 'Greenland',
                'Gambia' => 'Gambia',
                'Guinea' => 'Guinea',
                'Guadeloupe' => 'Guadeloupe',
                'Equatorial Guinea' => 'Equatorial Guinea',
                'Greece' => 'Greece',
                'South Georgia And The South Sandwich Islands' => 'South Georgia And The South Sandwich Islands',
                'Guatemala' => 'Guatemala',
                'Guam' => 'Guam',
                'Guinea-Bissau' => 'Guinea-Bissau',
                'Guyana' => 'Guyana',
                'Hong Kong' => 'Hong Kong',
                'Heard And Mc Donald Islands' => 'Heard And Mc Donald Islands',
                'Honduras' => 'Honduras',
                'Croatia (local name: Hrvatska)' => 'Croatia (local name: Hrvatska)',
                'Haiti' => 'Haiti',
                'Hungary' => 'Hungary',
                'Indonesia' => 'Indonesia',
                'Ireland' => 'Ireland',
                'Israel' => 'Israel',
                'Isle of Man' => 'Isle of Man',
                'India' => 'India',
                'British Indian Ocean Territory' => 'British Indian Ocean Territory',
                'Iraq' => 'Iraq',
                'Iran (Islamic Republic Of)' => 'Iran (Islamic Republic Of)',
                'Iceland' => 'Iceland',
                'Italy' => 'Italy',
                'Jersey' => 'Jersey',
                'Jamaica' => 'Jamaica',
                'Jordan' => 'Jordan',
                'Japan' => 'Japan',
                'Kenya' => 'Kenya',
                'Kyrgyzstan' => 'Kyrgyzstan',
                'Cambodia' => 'Cambodia',
                'Kiribati' => 'Kiribati',
                'Comoros' => 'Comoros',
                'Saint Kitts And Nevis' => 'Saint Kitts And Nevis',
                'Korea, Republic Of' => 'Korea, Republic Of',
                'Kuwait' => 'Kuwait',
                'Cayman Islands' => 'Cayman Islands',
                'Kazakhstan' => 'Kazakhstan',
                'Lao Peoples Democratic Republic' => 'Lao Peoples Democratic Republic',
                'Lebanon' => 'Lebanon',
                'Saint Lucia' => 'Saint Lucia',
                'Liechtenstein' => 'Liechtenstein',
                'Sri Lanka' => 'Sri Lanka',
                'Liberia' => 'Liberia',
                'Lesotho' => 'Lesotho',
                'Lithuania' => 'Lithuania',
                'Luxembourg' => 'Luxembourg',
                'Latvia' => 'Latvia',
                'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya',
                'Morocco' => 'Morocco',
                'Monaco' => 'Monaco',
                'Moldova, Republic Of' => 'Moldova, Republic Of',
                'Montenegro' => 'Montenegro',
                'Madagascar' => 'Madagascar',
                'Marshall Islands' => 'Marshall Islands',
                'Macedonia, The Former Yugoslav Republic Of' => 'Macedonia, The Former Yugoslav Republic Of',
                'Mali' => 'Mali',
                'Myanmar' => 'Myanmar',
                'Mongolia' => 'Mongolia',
                'Macau' => 'Macau',
                'Northern Mariana Islands' => 'Northern Mariana Islands',
                'Martinique' => 'Martinique',
                'Mauritania' => 'Mauritania',
                'Montserrat' => 'Montserrat',
                'Malta' => 'Malta',
                'Mauritius' => 'Mauritius',
                'Maldives' => 'Maldives',
                'Malawi' => 'Malawi',
                'Mexico' => 'Mexico',
                'Malaysia' => 'Malaysia',
                'Mozambique' => 'Mozambique',
                'Namibia' => 'Namibia',
                'New Caledonia' => 'New Caledonia',
                'Niger' => 'Niger',
                'Norfolk Island' => 'Norfolk Island',
                'Nigeria' => 'Nigeria',
                'Nicaragua' => 'Nicaragua',
                'Netherlands' => 'Netherlands',
                'Norway' => 'Norway',
                'Nepal' => 'Nepal',
                'Nauru' => 'Nauru',
                'Niue' => 'Niue',
                'New Zealand' => 'New Zealand',
                'Oman' => 'Oman',
                'Panama' => 'Panama',
                'Peru' => 'Peru',
                'French Polynesia' => 'French Polynesia',
                'Papua New Guinea' => 'Papua New Guinea',
                'Philippines, Republic of the' => 'Philippines, Republic of the',
                'Pakistan' => 'Pakistan',
                'Poland' => 'Poland',
                'St. Pierre And Miquelon' => 'St. Pierre And Miquelon',
                'Pitcairn' => 'Pitcairn',
                'Puerto Rico' => 'Puerto Rico',
                'Palestine' => 'Palestine',
                'Portugal' => 'Portugal',
                'Palau' => 'Palau',
                'Paraguay' => 'Paraguay',
                'Qatar' => 'Qatar',
                'Reunion' => 'Reunion',
                'Romania' => 'Romania',
                'Serbia' => 'Serbia',
                'Russian Federation' => 'Russian Federation',
                'Rwanda' => 'Rwanda',
                'Saudi Arabia' => 'Saudi Arabia',
                'United Kingdom' => 'United Kingdom',
                'Solomon Islands' => 'Solomon Islands',
                'Seychelles' => 'Seychelles',
                'Sudan' => 'Sudan',
                'Sweden' => 'Sweden',
                'Singapore' => 'Singapore',
                'St. Helena' => 'St. Helena',
                'Slovenia' => 'Slovenia',
                'Svalbard And Jan Mayen Islands' => 'Svalbard And Jan Mayen Islands',
                'Slovakia (Slovak Republic)' => 'Slovakia (Slovak Republic)',
                'Sierra Leone' => 'Sierra Leone',
                'San Marino' => 'San Marino',
                'Senegal' => 'Senegal',
                'Somalia' => 'Somalia',
                'Suriname' => 'Suriname',
                'Sao Tome And Principe' => 'Sao Tome And Principe',
                'Soviet Union' => 'Soviet Union',
                'El Salvador' => 'El Salvador',
                'Syrian Arab Republic' => 'Syrian Arab Republic',
                'Swaziland' => 'Swaziland',
                'Turks And Caicos Islands' => 'Turks And Caicos Islands',
                'Chad' => 'Chad',
                'French Southern Territories' => 'French Southern Territories',
                'Togo' => 'Togo',
                'Thailand' => 'Thailand',
                'Tajikistan' => 'Tajikistan',
                'Tokelau' => 'Tokelau',
                'East Timor (new code)' => 'East Timor (new code)',
                'Turkmenistan' => 'Turkmenistan',
                'Tunisia' => 'Tunisia',
                'Tonga' => 'Tonga',
                'East Timor (old code)' => 'East Timor (old code)',
                'Turkey' => 'Turkey',
                'Trinidad And Tobago' => 'Trinidad And Tobago',
                'Tuvalu' => 'Tuvalu',
                'Taiwan' => 'Taiwan',
                'Tanzania, United Republic Of' => 'Tanzania, United Republic Of',
                'Ukraine' => 'Ukraine',
                'Uganda' => 'Uganda',
                'United States Minor Outlying Islands' => 'United States Minor Outlying Islands',
                'United States' => 'United States',
                'Uruguay' => 'Uruguay',
                'Uzbekistan' => 'Uzbekistan',
                'Vatican City State (Holy See)' => 'Vatican City State (Holy See)',
                'Saint Vincent And The Grenadines' => 'Saint Vincent And The Grenadines',
                'Venezuela' => 'Venezuela',
                'Virgin Islands (British)' => 'Virgin Islands (British)',
                'Virgin Islands (U.S.)' => 'Virgin Islands (U.S.)',
                'Viet Nam' => 'Viet Nam',
                'Vanuatu' => 'Vanuatu',
                'Wallis And Futuna Islands' => 'Wallis And Futuna Islands',
                'Samoa' => 'Samoa',
                'Yemen' => 'Yemen',
                'Mayotte' => 'Mayotte',
                'South Africa' => 'South Africa',
                'Zambia' => 'Zambia',
                'Zimbabwe' => 'Zimbabwe'
            ];

        return view('beacons.create')
                    ->with(compact('user', 'profilePosts', 'profileExtensions'))
                    ->with('beliefs', $beliefs)
                    ->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBeaconRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBeaconRequest $request)
    {

        $beacon = new Beacon($request->all());
        $beacon->status = 'active';
        $beacon->save();

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

            $beaconName = str_replace(' ', '_', $beacon->name);
            $imageFileName = $beaconName . '-' . Carbon::today()->format('M-d-Y') . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //If beacon has existing profile photo, then delete from Storage
            if($beacon->photo_path != NULL)
            {
                Storage::delete($beacon->photo_path);
            }

            Storage::put($path, $imageResized->__toString());
            $beacon->where('id', $beacon->id)
                    ->update(['photo_path' => $path]);
        }


        flash()->overlay('Your beacon has been created');
        return redirect('beacons/signup/'. $beacon->id);
    }

    /**
     * Gather card details for beacon subscription
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function signup($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        return view ('beacons.signup')
            ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'));
    }

    /**
     * Start subscription for beacon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        $id = $request['beacon'];
        $beacon = Beacon::findOrFail($id);

        $beacon->subscription($request['subscription'])->create($request['stripeToken'],
                ['email' => $beacon->email, 'description' => $beacon->name]);

        flash()->overlay('Level '. $request['subscription'] . ' subscription started for '. $beacon->name);
        return redirect('beacons/'. $beacon->id);

    }

    /**
     * Swap subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function swap(Request $request)
    {
        $id = $request['beacon'];
        $beacon = Beacon::findOrFail($id);

        $beacon->subscription($request['subscription'])->swap();

        flash()->overlay('Level '. $request['subscription'] . ' subscription updated for '. $beacon->name);
        return redirect('beacons/'. $beacon->id);

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
        $beacon = $this->beacon->findOrFail($id);
        $beaconPath = $beacon->photo_path;
        $usage = Post::where('beacon_tag', '=', $beacon->beacon_tag)->count();
        $location = 'http://www.google.com/maps/place/'. $beacon->lat . ','. $beacon->long;

        return view ('beacons.show')
                    ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'))
                    ->with('beaconPath', $beaconPath)
                    ->with('usage', $usage)
                    ->with('location' , $location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Beacon requested for editing
        $beacon = $this->beacon->findOrFail($id);

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $beliefs =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Indigenous' => 'Indigenous',
                'Judaism' => 'Judaism',
                'Shinto' => 'Shinto',
                'Sikhism' => 'Sikhism',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia',
                'Zoroastrianism' => 'Zoroastrianism',
                'Other' => 'Other'
            ];
        $countries =
            [
                'Select a Country' => 'Select a Country',
                'Ascension Island' => 'Ascension Island',
                'Andorra' => 'Andorra',
                'United Arab Emirates' => 'United Arab Emirates',
                'Afghanistan' => 'Afghanistan',
                'Antigua And Barbuda' => 'Antigua And Barbuda',
                'Anguilla' => 'Anguilla',
                'Albania' => 'Albania',
                'Armenia' => 'Armenia',
                'Netherlands Antilles' => 'Netherlands Antilles',
                'Angola' => 'Angola',
                'Antarctica' => 'Antarctica',
                'Argentina' => 'Argentina',
                'American Samoa' => 'American Samoa',
                'Austria' => 'Austria',
                'Australia' => 'Australia',
                'Aruba' => 'Aruba',
                'Azerbaijan' => 'Azerbaijan',
                'Bosnia And Herzegovina' => 'Bosnia / Herzegovina',
                'Barbados' => 'Barbados',
                'Belgium' => 'Belgium',
                'Bangladesh' => 'Bangladesh',
                'Burkina Faso' => 'Burkina Faso',
                'Bulgaria' => 'Bulgaria',
                'Bahrain' => 'Bahrain',
                'Burundi' => 'Burundi',
                'Benin' => 'Benin',
                'Bermuda' => 'Bermuda',
                'Brunei Darussalam' => 'Brunei Darussalam',
                'Bolivia' => 'Bolivia',
                'Brazil' => 'Brazil',
                'Bahamas' => 'Bahamas',
                'Bhutan' => 'Bhutan',
                'Bouvet Island' => 'Bouvet Island',
                'Botswana' => 'Botswana',
                'Belarus' => 'Belarus',
                'Belize' => 'Belize',
                'Canada' => 'Canada',
                'Cocos (Keeling) Islands' => 'Cocos (Keeling) Islands',
                'Congo (Democratic Republic)' => 'Congo (Democratic Republic)',
                'Central African Republic' => 'Central African Republic',
                'Congo (Republic)' => 'Congo (Republic)',
                'Switzerland' => 'Switzerland',
                'Cote DÃ¢â‚¬â„¢Ivoire' => 'Cote DÃ¢â‚¬â„¢Ivoire',
                'Cook Islands' => 'Cook Islands',
                'Chile' => 'Chile',
                'Cameroon' => 'Cameroon',
                'Peoples Republic of China' => 'Peoples Republic of China',
                'Colombia' => 'Colombia',
                'Costa Rica' => 'Costa Rica',
                'Cuba' => 'Cuba',
                'Cape Verde' => 'Cape Verde',
                'Christmas Island' => 'Christmas Island',
                'Cyprus' => 'Cyprus',
                'Czech Republic' => 'Czech Republic',
                'Germany' => 'Germany',
                'Djibouti' => 'Djibouti',
                'Denmark' => 'Denmark',
                'Dominica' => 'Dominica',
                'Dominican Republic' => 'Dominican Republic',
                'Algeria' => 'Algeria',
                'Ecuador' => 'Ecuador',
                'Estonia' => 'Estonia',
                'Egypt' => 'Egypt',
                'Eritrea' => 'Eritrea',
                'Spain' => 'Spain',
                'Ethiopia' => 'Ethiopia',
                'European Union' => 'European Union',
                'Finland' => 'Finland',
                'Fiji' => 'Fiji',
                'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)',
                'Micronesia, Federated States Of' => 'Micronesia, Federated States Of',
                'Faroe Islands' => 'Faroe Islands',
                'France' => 'France',
                'Gabon' => 'Gabon',
                'United Kingdom' => 'United Kingdom',
                'Grenada' => 'Grenada',
                'Georgia' => 'Georgia',
                'French Guiana' => 'French Guiana',
                'Guernsey' => 'Guernsey',
                'Ghana' => 'Ghana',
                'Gibraltar' => 'Gibraltar',
                'Greenland' => 'Greenland',
                'Gambia' => 'Gambia',
                'Guinea' => 'Guinea',
                'Guadeloupe' => 'Guadeloupe',
                'Equatorial Guinea' => 'Equatorial Guinea',
                'Greece' => 'Greece',
                'South Georgia And The South Sandwich Islands' => 'South Georgia And The South Sandwich Islands',
                'Guatemala' => 'Guatemala',
                'Guam' => 'Guam',
                'Guinea-Bissau' => 'Guinea-Bissau',
                'Guyana' => 'Guyana',
                'Hong Kong' => 'Hong Kong',
                'Heard And Mc Donald Islands' => 'Heard And Mc Donald Islands',
                'Honduras' => 'Honduras',
                'Croatia (local name: Hrvatska)' => 'Croatia (local name: Hrvatska)',
                'Haiti' => 'Haiti',
                'Hungary' => 'Hungary',
                'Indonesia' => 'Indonesia',
                'Ireland' => 'Ireland',
                'Israel' => 'Israel',
                'Isle of Man' => 'Isle of Man',
                'India' => 'India',
                'British Indian Ocean Territory' => 'British Indian Ocean Territory',
                'Iraq' => 'Iraq',
                'Iran (Islamic Republic Of)' => 'Iran (Islamic Republic Of)',
                'Iceland' => 'Iceland',
                'Italy' => 'Italy',
                'Jersey' => 'Jersey',
                'Jamaica' => 'Jamaica',
                'Jordan' => 'Jordan',
                'Japan' => 'Japan',
                'Kenya' => 'Kenya',
                'Kyrgyzstan' => 'Kyrgyzstan',
                'Cambodia' => 'Cambodia',
                'Kiribati' => 'Kiribati',
                'Comoros' => 'Comoros',
                'Saint Kitts And Nevis' => 'Saint Kitts And Nevis',
                'Korea, Republic Of' => 'Korea, Republic Of',
                'Kuwait' => 'Kuwait',
                'Cayman Islands' => 'Cayman Islands',
                'Kazakhstan' => 'Kazakhstan',
                'Lao Peoples Democratic Republic' => 'Lao Peoples Democratic Republic',
                'Lebanon' => 'Lebanon',
                'Saint Lucia' => 'Saint Lucia',
                'Liechtenstein' => 'Liechtenstein',
                'Sri Lanka' => 'Sri Lanka',
                'Liberia' => 'Liberia',
                'Lesotho' => 'Lesotho',
                'Lithuania' => 'Lithuania',
                'Luxembourg' => 'Luxembourg',
                'Latvia' => 'Latvia',
                'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya',
                'Morocco' => 'Morocco',
                'Monaco' => 'Monaco',
                'Moldova, Republic Of' => 'Moldova, Republic Of',
                'Montenegro' => 'Montenegro',
                'Madagascar' => 'Madagascar',
                'Marshall Islands' => 'Marshall Islands',
                'Macedonia, The Former Yugoslav Republic Of' => 'Macedonia, The Former Yugoslav Republic Of',
                'Mali' => 'Mali',
                'Myanmar' => 'Myanmar',
                'Mongolia' => 'Mongolia',
                'Macau' => 'Macau',
                'Northern Mariana Islands' => 'Northern Mariana Islands',
                'Martinique' => 'Martinique',
                'Mauritania' => 'Mauritania',
                'Montserrat' => 'Montserrat',
                'Malta' => 'Malta',
                'Mauritius' => 'Mauritius',
                'Maldives' => 'Maldives',
                'Malawi' => 'Malawi',
                'Mexico' => 'Mexico',
                'Malaysia' => 'Malaysia',
                'Mozambique' => 'Mozambique',
                'Namibia' => 'Namibia',
                'New Caledonia' => 'New Caledonia',
                'Niger' => 'Niger',
                'Norfolk Island' => 'Norfolk Island',
                'Nigeria' => 'Nigeria',
                'Nicaragua' => 'Nicaragua',
                'Netherlands' => 'Netherlands',
                'Norway' => 'Norway',
                'Nepal' => 'Nepal',
                'Nauru' => 'Nauru',
                'Niue' => 'Niue',
                'New Zealand' => 'New Zealand',
                'Oman' => 'Oman',
                'Panama' => 'Panama',
                'Peru' => 'Peru',
                'French Polynesia' => 'French Polynesia',
                'Papua New Guinea' => 'Papua New Guinea',
                'Philippines, Republic of the' => 'Philippines, Republic of the',
                'Pakistan' => 'Pakistan',
                'Poland' => 'Poland',
                'St. Pierre And Miquelon' => 'St. Pierre And Miquelon',
                'Pitcairn' => 'Pitcairn',
                'Puerto Rico' => 'Puerto Rico',
                'Palestine' => 'Palestine',
                'Portugal' => 'Portugal',
                'Palau' => 'Palau',
                'Paraguay' => 'Paraguay',
                'Qatar' => 'Qatar',
                'Reunion' => 'Reunion',
                'Romania' => 'Romania',
                'Serbia' => 'Serbia',
                'Russian Federation' => 'Russian Federation',
                'Rwanda' => 'Rwanda',
                'Saudi Arabia' => 'Saudi Arabia',
                'United Kingdom' => 'United Kingdom',
                'Solomon Islands' => 'Solomon Islands',
                'Seychelles' => 'Seychelles',
                'Sudan' => 'Sudan',
                'Sweden' => 'Sweden',
                'Singapore' => 'Singapore',
                'St. Helena' => 'St. Helena',
                'Slovenia' => 'Slovenia',
                'Svalbard And Jan Mayen Islands' => 'Svalbard And Jan Mayen Islands',
                'Slovakia (Slovak Republic)' => 'Slovakia (Slovak Republic)',
                'Sierra Leone' => 'Sierra Leone',
                'San Marino' => 'San Marino',
                'Senegal' => 'Senegal',
                'Somalia' => 'Somalia',
                'Suriname' => 'Suriname',
                'Sao Tome And Principe' => 'Sao Tome And Principe',
                'Soviet Union' => 'Soviet Union',
                'El Salvador' => 'El Salvador',
                'Syrian Arab Republic' => 'Syrian Arab Republic',
                'Swaziland' => 'Swaziland',
                'Turks And Caicos Islands' => 'Turks And Caicos Islands',
                'Chad' => 'Chad',
                'French Southern Territories' => 'French Southern Territories',
                'Togo' => 'Togo',
                'Thailand' => 'Thailand',
                'Tajikistan' => 'Tajikistan',
                'Tokelau' => 'Tokelau',
                'East Timor (new code)' => 'East Timor (new code)',
                'Turkmenistan' => 'Turkmenistan',
                'Tunisia' => 'Tunisia',
                'Tonga' => 'Tonga',
                'East Timor (old code)' => 'East Timor (old code)',
                'Turkey' => 'Turkey',
                'Trinidad And Tobago' => 'Trinidad And Tobago',
                'Tuvalu' => 'Tuvalu',
                'Taiwan' => 'Taiwan',
                'Tanzania, United Republic Of' => 'Tanzania, United Republic Of',
                'Ukraine' => 'Ukraine',
                'Uganda' => 'Uganda',
                'United States Minor Outlying Islands' => 'United States Minor Outlying Islands',
                'United States' => 'United States',
                'Uruguay' => 'Uruguay',
                'Uzbekistan' => 'Uzbekistan',
                'Vatican City State (Holy See)' => 'Vatican City State (Holy See)',
                'Saint Vincent And The Grenadines' => 'Saint Vincent And The Grenadines',
                'Venezuela' => 'Venezuela',
                'Virgin Islands (British)' => 'Virgin Islands (British)',
                'Virgin Islands (U.S.)' => 'Virgin Islands (U.S.)',
                'Viet Nam' => 'Viet Nam',
                'Vanuatu' => 'Vanuatu',
                'Wallis And Futuna Islands' => 'Wallis And Futuna Islands',
                'Samoa' => 'Samoa',
                'Yemen' => 'Yemen',
                'Mayotte' => 'Mayotte',
                'South Africa' => 'South Africa',
                'Zambia' => 'Zambia',
                'Zimbabwe' => 'Zimbabwe'
            ];

        return view('beacons.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'beacon'))
            ->with('beliefs', $beliefs)
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
        $beacon = $this->beacon->findOrFail($id);

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

            $beaconName = str_replace(' ', '_', $beacon->name);
            $imageFileName = $beaconName . '-' . Carbon::today()->format('M-d-Y') . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //If beacon has existing profile photo, then delete from Storage
            if($beacon->photo_path != NULL)
            {
                Storage::delete($beacon->photo_path);
            }

            Storage::put($path, $imageResized->__toString());

            //Set new path for database
            $beacon->photo_path = $path;
        }

        $beacon->update($request->all());

        flash()->overlay('Beacon has been updated');

        return redirect('beacons/'. $beacon->id);
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
     * List posts and extensions with the specific beacon_tag
     *
     * @param  string  $beacon_tag
     * @return \Illuminate\Http\Response
     */
    public function listTagged($beacon_tag)
    {
        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=',  $beacon_tag)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this tag: '.$beacon_tag);
            $error = "No active Idee Beacon with this tag: $beacon_tag";
            return redirect()
                ->back();
        }

        $posts = Post::where('beacon_tag', $beacon_tag)->latest()->paginate(10);;

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $beaconPath = $beacon->photo_path;

        return view ('beacons.listTagged')
                    ->with(compact('user', 'posts', 'beacon', 'profilePosts','profileExtensions'))
                    ->with('beaconPath', $beaconPath);

    }

    /**
     * Display the search page for Beacons.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $types = [
            'Name' => 'Name',
            'Tag' => 'Beacon Tag'
        ];

        return view ('beacons.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('types', $types);
    }

    /**
     * Display the results page for a search on beacons.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get type
        $type = $request->input('type');
        $identifier = $request->input('identifier');

        if($type == 'Name')
        {
            $results = Beacon::where('name', 'LIKE', '%'.$identifier.'%')->paginate(10);
        }
        elseif($type == 'Tag')
        {
            $results = Beacon::where('beacon_tag', 'LIKE', '%'.$identifier.'%')->paginate(10);
        }
        else
        {
            $results = null;
        }

        if($results == null)
        {
            flash()->overlay('No beacons with this name');
        }

        return view ('beacons.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('type', $type)
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $beacons = $this->beacon->orderBy('tag_usage', 'desc')->paginate(10);

        return view ('beacons.top')
            ->with(compact('user', 'beacons', 'profilePosts','profileExtensions'));
    }
}
