<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Extension;
use App\Http\Requests\CreateBasicBeaconRequest;
use App\Http\Requests\CreateBeaconRequest;
use App\Mailers\NotificationMailer;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\BeaconRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Response;

class BeaconRequestController extends Controller
{
    private $beaconRequest;

    public function __construct(BeaconRequest $beaconRequest)
    {
        $this->middleware('auth', ['except' => 'agreement']);
        $this->middleware('admin', ['only' => 'convert', 'destroy']);
        $this->middleware('beaconRequestOwner', ['only' => 'show', 'edit']);
        $this->beaconRequest = $beaconRequest;
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
        $beaconRequests = $this->beaconRequest->where('user_id', '=', $user->id)->paginate(10);

        return view ('beaconRequests.index')
            ->with(compact('user', 'beaconRequests', 'profilePosts','profileExtensions'));
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

        return view('beaconRequests.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('beliefs', $beliefs)
            ->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBasicBeaconRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBasicBeaconRequest $request)
    {
        $user = Auth::user();

        $beaconRequest = new BeaconRequest($request->all());
        $beaconRequest->user()->associate($user->id);
        $beaconRequest->save();

        flash()->overlay('Your beacon request has been created');
        return redirect('beaconRequests/'. $beaconRequest->id);
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
        $beaconRequest = $this->beaconRequest->findOrFail($id);

        return view('beaconRequests.show')
                ->with(compact('user', 'beaconRequest', 'profilePosts', 'profileExtensions'));
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
        $beaconRequest = $this->beaconRequest->findOrFail($id);

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


        return view('beaconRequests.edit')
            ->with(compact('user', 'beaconRequest', 'profilePosts', 'profileExtensions'))
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
        $beaconRequest = $this->beaconRequest->findOrFail($id);
        $beaconRequest->update($request->all());

        flash()->overlay('Beacon Request has been updated');

        return redirect('beaconRequests/'. $beaconRequest->id);
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
        $beaconRequest = BeaconRequest::findOrFail($id);
        $user = User::findOrFail($beaconRequest->user_id);
        $beaconName = $beaconRequest->name;
        $beaconRequest->delete();

        $mailer->sendBeaconDeletedNotification($user, $beaconName);

        flash()->overlay('Beacon Request has been deleted');
        return redirect('admin/beacon/requests');
    }

    /**
     * Convert request to Beacon.
     *
     * @param CreateBeaconRequest $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function convert(CreateBeaconRequest $request, NotificationMailer $mailer)
    {
        $beaconRequest = BeaconRequest::findOrFail($request['beaconRequestId']);
        $user = User::findOrFail($beaconRequest->user_id);

        $beacon = new Beacon($request->except('beaconRequestId'));
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
            $imageFileName = $beaconName . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            Storage::put($path, file_get_contents($image));
            $beacon->where('id', $beacon->id)
                ->update(['photo_path' => $path]);
        }

        //Notify requester their request is now a Beacon!
        $mailer->sendBeaconCreatedNotification($user, $beacon);

        //Delete beacon request as it is now a beacon
        $beaconRequest->delete();

        flash()->overlay('Beacon Request has been converted');
        return redirect('beacons/signup/'. $beacon->id);
    }

    /*
    * Return the Belle-Idee Beacon Agreement
    */
    public function agreement()
    {
        $filename = 'BeaconAgreement.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }
}
