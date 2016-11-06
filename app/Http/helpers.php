<?php

namespace App\Http;

use App\Announcement;
use App\Beacon;
use App\Elevation;
use App\Events\BeaconViewed;
use App\Events\SetLocation;
use App\Events\SponsorViewed;
use App\Extension;
use App\LegacyPost;
use App\Post;
use App\Promotion;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Event;
use Illuminate\Support\Facades\Auth;

/*
 * Get the sponsor of a given user
 *
 * @param user
 */
function getSponsor($user)
{
    if(Sponsorship::where('user_id', '=', $user->id)->exists())
    {
        $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
        $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
        Event::fire(new SponsorViewed($sponsor));
        if($sponsor->views >= $sponsor->view_budget || $sponsor->clicks >= $sponsor->click_budget)
        {
            $sponsor = Sponsor::where('id', '=', 1)->first();
        }
    }
    else
    {
        $sponsor = null;
    }

    return $sponsor;
}

/*
 * Get the beacon of a given content and return if beacon pays subscription
 *
 * @param content
 */
function getBeacon($content)
{
    if(isset($content->last_tag))
    {
        $beacon = Beacon::where('beacon_tag', '=', $content->last_tag)->first();
    }
    else
    {
        $beacon = Beacon::where('beacon_tag', '=', $content->beacon_tag)->first();
    }

    if($beacon != null)
    {
        Event::fire(new BeaconViewed($beacon));
    }

    return $beacon;
}

/*
 * Get the profile posts for a user
 */
function getProfilePosts($user)
{
    $posts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
    return $posts;
}

/*
 * Get the profile extensions for a user
 */
function getProfileExtensions($user)
{
    $extensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
    return $extensions;
}

/*
 * Get list of beliefs
 */
function getBeliefs()
{
    $beliefs =
        [
            'Adaptia' => 'Adaptia',
            'Atheism' => 'Atheism',
            'Bahá’í' => 'Bahá’í',
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
    
    return $beliefs;
}

/*
 * Get list of countries to use with select drop downs
 */

function getCountries()
{
    $countries =
        [
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'BQ' => 'British Antarctic Territory',
            'IO' => 'British Indian Ocean Territory',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CT' => 'Canton and Enderbury Islands',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos [Keeling] Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo - Brazzaville',
            'CD' => 'Congo - Kinshasa',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CI' => 'Côte d’Ivoire',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'NQ' => 'Dronning Maud Land',
            'DD' => 'East Germany',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'FQ' => 'French Southern and Antarctic Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong SAR China',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JT' => 'Johnston Island',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Laos',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macau SAR China',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'FX' => 'Metropolitan France',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MI' => 'Midway Islands',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar [Burma]',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NT' => 'Neutral Zone',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'KP' => 'North Korea',
            'VD' => 'North Vietnam',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PC' => 'Pacific Islands Trust Territory',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territories',
            'PA' => 'Panama',
            'PZ' => 'Panama Canal Zone',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'YD' => 'People\'s Democratic Republic of Yemen',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RO' => 'Romania',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'RE' => 'Réunion',
            'BL' => 'Saint Barthélemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'CS' => 'Serbia and Montenegro',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'KR' => 'South Korea',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syria',
            'ST' => 'São Tomé and Príncipe',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UM' => 'U.S. Minor Outlying Islands',
            'PU' => 'U.S. Miscellaneous Pacific Islands',
            'VI' => 'U.S. Virgin Islands',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'SU' => 'Union of Soviet Socialist Republics',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'ZZ' => 'Unknown or Invalid Region',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vatican City',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WK' => 'Wake Island',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
            'AX' => 'Åland Islands',
        ];

    return ($countries);
}

//Run user through Getting started guide if needed
function startupGuide($user)
{
    if($user->startup < 5 || $user->startup == null)
    {
        $startup = 0;
        if(session('startupList'))
        {
            $startupList = session('startupList');
        }
        else
        {
            $startupList = [
                'beacon' => null,
                'sponsor' => null,
                'following' => null,
                'post' => null,
                'extension' => null,
                'skip' => 'No'
            ];
        }

        //Check if user has selected a beacon
        if($user->last_tag == null)
        {
            $startupList['beacon'] = '0';
        }
        else
        {
            $startupList['beacon'] = '1';
            $startup = $startup + 1;
        }

        //Check if user has selected a sponsor
        if(!Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $startupList['sponsor'] = '0';
        }
        else
        {
            $startupList['sponsor'] = '1';
            $startup = $startup + 1;
        }

        //Check if user has followed any users
        if(!$bookmarks = $user->bookmarks()->where('type', '=', 'User')->exists())
        {
            $startupList['following'] = '0';
        }
        else
        {
            $startupList['following'] = '1';
            $startup = $startup + 1;
        }

        //Check if user has created their first post
        if(!Post::where('user_id', '=', $user->id)->exists())
        {
            $startupList['post'] = '0';
        }
        else
        {
            $startupList['post'] = '1';
            $startup = $startup + 1;
        }

        //Check if user has created their first extensions
        if(!Extension::where('user_id', '=', $user->id)->exists())
        {
            $startupList['extension'] = '0';
        }
        else
        {
            $startupList['extension'] = '1';
            $startup = $startup + 1;
        }

        //Update User
        $user->startup = $startup;
        $user->update();

        //Add startupList to session
        session()->put('startupList', $startupList);
    }
    else
    {
        $startupList = [
            'beacon' => 1,
            'sponsor' => 1,
            'following' => 1,
            'post' => 1,
            'extension' => 1,
            'skip' => 'Yes'
        ];
        session()->put('startupList', $startupList);
    }
}

//Get beacon tag and set coordinates
function setCoordinates($user, $last_tag)
{
    $beacon = Beacon::where('beacon_tag', '=', $last_tag)->first();
    if($last_tag != 'No-Beacon' && !is_null($beacon))
    {
        $country = $beacon->country;

        //Separate out city code and name
        $cityCode = substr($beacon->beacon_tag, 3);
        $cityCode = substr($cityCode, 0, strpos($cityCode, "-"));
        $cityName = $beacon->city;

        //Add country to city name
        $city = $beacon->country . '-' . $cityName;

        //Add country to city code
        $shortTag = $beacon->country . '-' . $cityCode;

        $coordinates = [
            'lat' => $beacon->lat,
            'long' => $beacon->long,
            'country' => $country,
            'city' => $city,
            'shortTag' => $shortTag,
            'cityCode' => $cityCode,
            'cityName' => $cityName,
            'location' => $user->location,
        ];
        session()->put('coordinates', $coordinates);
        //$this->flashLocation($user, $coordinates);
    }
    else
    {
        $coordinates = [
            'lat' => NULL,
            'long' => NULL,
            'country' => NULL,
            'city' => NULL,
            'cityCode' => NULL,
            'cityName' => NULL,
            'shortTag' => NULL,
            'location' => 2,
        ];

        //Set user location to Global in database
        $user->location = 2;
        $user->update();
        //$this->flashLocation($user, $coordinates);
        session()->put('coordinates', $coordinates);
    }
}

/*
 * Get the coordinates of a logged in user and return location
 */
function getLocation()
{
    $user = Auth::user();
    if($user->location == 0)
    {
        $coordinates = session('coordinates');
        $location = $coordinates['city'];
    }
    elseif($user->location == 1)
    {
        $coordinates = session('coordinates');
        $location = $coordinates['country'];
    }
    elseif($user->location == 2)
    {
        $location = 'Global';
    }
    else
    {
        $location = 'Undefined';
    }

    return $location;
}

/*
 * Retrieve content for a given user's location
 *
 * @param $user
 * @param $number (0 = only 10 records, 1 = paginate, 2 = elevation filter, 3 = extension filter, 4 = source specific (for posts))
 * @param type Defines if what type of location filter is needed
 */
function filterContentLocation($user, $number, $type)
{
    $location = session('coordinates');

    if($location == null)
    {
        Event::fire(New SetLocation($user));
        $location = session('coordinates');
    }
    //dd($location);

    //Simple Index (i.e Post and Extension main indexes)
    if($number == 0)
    {
        //Filter by local
        if($user->location == 0)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Elevation')
            {
                $filteredContent = Elevation::where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {

                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }


        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Elevation')
            {
                $filteredContent = Elevation::where('beacon_tag', 'LIKE', $location['country'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {
                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'].'%')->latest('created_at')->paginate(10);
            }

        }
        //Filter by Global

        else
        {

            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Elevation')
            {
                $filteredContent = Elevation::latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {
                $filteredContent = User::where('verified', '=', 1)->latest('created_at')->paginate(10);
            }

        }

    }
    //Paginated indexes (i.e All time posts/extensions)
    elseif($number == 1)
    {
        //Filter by local
        if($user->location == 0)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {
                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'].'%')->where('verified', '=', 1)->latest('created_at')->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::where('beacon_tag', 'LIKE', $location['shortTag'].'%')->where('status', '!=', 'deactivated')->latest('updated_at')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::where('sponsor_tag', 'LIKE', $location['shortTag'].'%')->where('status', '!=', 'deactivated')->latest('updated_at')->paginate(10);
            }
            elseif($type == 'Announcement')
            {
                $filteredContent = Announcement::whereHas('beacon', function ($query) {
                    $location = session('coordinates');
                    $query->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->where('status', '!=', 'deactivated');
                })->paginate(10);
            }
            elseif($type == 'Promotion')
            {
                $filteredContent = Promotion::where('status', '=', 'Open to All')->whereHas('sponsor', function ($query) {
                    $location = session('coordinates');
                    $query->where('sponsor_tag', 'LIKE', $location['shortTag'].'%')->where('status', '!=', 'deactivated');
                })->paginate(10);
            }
        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {
                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'].'%')->where('verified', '=', 1)->latest('created_at')->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('status', '!=', 'deactivated')->latest('updated_at')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::where('sponsor_tag', 'LIKE', $location['country']. '-'. '%')->where('status', '!=', 'deactivated')->latest('updated_at')->paginate(10);
            }
            elseif($type == 'Announcement')
            {
                $filteredContent = Announcement::whereHas('beacon', function ($query) {
                    $location = session('coordinates');
                    $query->where('beacon_tag', 'LIKE', $location['country'].'%')->where('status', '!=', 'deactivated');
                })->paginate(10);
            }
            elseif($type == 'Promotion')
            {
                $filteredContent = Promotion::where('status', '=', 'Open to All')->whereHas('sponsor', function ($query) {
                    $location = session('coordinates');
                    $query->where('sponsor_tag', 'LIKE', $location['country'].'%')->where('status', '!=', 'deactivated');
                })->paginate(10);
            }
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->latest('created_at')->paginate(10);
            }
            elseif($type == 'User')
            {
                $filteredContent = User::where('verified', '=', 1)->latest('created_at')->where('verified', '=', 1)->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::latest('updated_at')->where('status', '!=', 'deactivated')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::latest('updated_at')->where('status', '!=', 'deactivated')->paginate(10);
            }
            elseif($type == 'Announcement')
            {
                $filteredContent = Announcement::latest()->paginate(10);
            }
            elseif($type == 'Promotion')
            {
                $filteredContent = Promotion::latest()->where('status', '=', 'Open to All')->paginate(10);
            }
        }
    }
    //Elevation filter for latest content
    elseif($number == 2)
    {
        //Filter by local
        if($user->location == 0)
        {
            if($type == 'Post')
            {
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('post_id')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->paginate(10);
            }
        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('post_id')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->paginate(10);
            }
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('post_id')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->paginate(10);
            }
        }
    }
    
    //Extension filter for latest content
    elseif($number == 3)
    {
        if($user->location == 0)
        {
            if ($type == 'Post')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('extenception')->paginate(10);
            }
        }
        elseif($user->location == 1)
        {
            if ($type == 'Post')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('extenception')->paginate(10);
            }
        }
        elseif($user->location == 2)
        {
            if ($type == 'Post')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->orderByRaw('max(created_at) desc')->groupBy('extenception')->paginate(10);
            }
        }
    }

    //Source Specific Content location (posts only, extensions have source built-in)
    elseif ($number == 4)
    {
        if($user->location == 0)
        {
            $filteredContent = Post::whereNull('status')->where('source', '=', $type)->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
        }
        elseif($user->location == 1)
        {
            $filteredContent = Post::whereNull('status')->where('source', '=', $type)->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
        }
        elseif($user->location == 2)
        {
            $filteredContent = Post::whereNull('status')->where('source', '=', $type)->latest('created_at')->paginate(10);
        }
    }

    return $filteredContent;
}

function filterContentLocationTime($user, $number, $type, $time, $order)
{

    $location = session('coordinates');
    //Time-based filters
    if($number == 0) {
        //Filter by City
        if ($user->location == 0)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'] . '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }

        } //Filter by Country
        elseif ($user->location == 1)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            } elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'] . '%')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
        } //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('created_at', '>=', Carbon::now()->$time())->latest($order)->paginate(10);
            }
        }
    }

    //Order by Time, Elevation/Extension and Location
    //Order by Time, Elevation and Location
    elseif($number == 1)
    {
        if ($user->location == 0)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'] . '%')->where('updated_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
        } //Filter by Country
        elseif ($user->location == 1)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'] . '%')->where('updated_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('updated_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
            }
        }
    }

    //Date specific content location
    elseif($number == 2)
    {
        $location = session('coordinates');
        if($user->location == 0)
        {
            if($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->whereDate('created_at', '=', $time)->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest($order)->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->whereDate('created_at', '=', $time)->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest($order)->paginate(10);
            }
        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->whereDate('created_at', '=', $time)->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest($order)->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->whereDate('created_at', '=', $time)->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest($order)->paginate(10);
            }
            
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->whereDate('created_at', '=', $time)->latest('created_at')->paginate(10);
            }
            elseif($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->whereDate('created_at', '=', $time)->latest('created_at')->paginate(10);
            }
        }
    }
    return $timeFilteredContent;
}

function filterContentLocationAllTime($user, $number, $type, $order)
{
    //Used for All time location filtering with orderBy (i.e all time elevations)
    $location = session('coordinates');
    if($number == 0) {
        if ($user->location == 0)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'] . '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {
                $timeFilteredContent = Beacon::where('status', '!=', 'deactivated')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Sponsor')
            {
                $timeFilteredContent = Sponsor::where('status', '!=', 'deactivated')->where('sponsor_tag', 'LIKE', $location['shortTag'] . '%')->orderBy($order, 'desc')->paginate(10);
            }

        } //Filter by Country
        elseif ($user->location == 1)
        {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderBy($order, 'desc')->paginate(10);
            } elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'] . '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {
                $timeFilteredContent = Beacon::where('status', '!=', 'deactivated')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Sponsor')
            {
                $timeFilteredContent = Sponsor::where('status', '!=', 'deactivated')->where('sponsor_tag', 'LIKE', $location['country']. '-'. '%')->orderBy($order, 'desc')->paginate(10);
            }
      
        } //Filter by Global
        else {
            if ($type == 'Post')
            {
                $timeFilteredContent = Post::whereNull('status')->orderBy($order, 'desc')->paginate(10);
            } elseif ($type == 'Extension')
            {
                $timeFilteredContent = Extension::whereNull('status')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $timeFilteredContent = User::where('verified', '=', 1)->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {
                $timeFilteredContent = Beacon::where('status', '!=', 'deactivated')->orderBy($order, 'desc')->paginate(10);
            }
            elseif ($type == 'Sponsor')
            {
                $timeFilteredContent = Sponsor::where('status', '!=', 'deactivated')->orderBy($order, 'desc')->paginate(10);
            }
        }
    }
    return $timeFilteredContent;
}



//Search-based filters (i.e Post, Extension, Beacon, Sponsor searches)
function filterContentLocationSearch($user, $number, $type, $search)
{

    $location = session('coordinates');

    if ($number == 0)
    {
        //Filter by City
        if ($user->location == 0)
        {
            if ($type == 'Post')
            {
                $searchFilteredContent = Post::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $searchFilteredContent = Extension::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {

                $searchFilteredContent = Beacon::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->orWhere('beacon_tag', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->paginate(10);
            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->where('sponsor_tag', 'LIKE', $location['shortTag'] . '%')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $searchFilteredContent = User::where('verified', '=', 1)->where('handle', 'LIKE', '%'.$search.'%')->where('last_tag', 'LIKE', $location['country'] . '-' . $location['cityCode']. '%')->paginate(10);
            }
            elseif ($type == 'Legacy')
            {
                $searchFilteredContent = LegacyPost::where('title', 'LIKE', '%' . $search . '%')->latest('created_at')->paginate(10);
            }

        }
        //Filter by Country
        elseif ($user->location == 1)
        {

            if ($type == 'Post')
            {
                $searchFilteredContent = Post::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $searchFilteredContent = Extension::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {
                $searchFilteredContent = Beacon::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->orWhere('beacon_tag', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->paginate(10);

            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->where('sponsor_tag', 'LIKE', $location['country'] . '%')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $searchFilteredContent = User::where('verified', '=', 1)->where('handle', 'LIKE', '%'.$search.'%')->where('last_tag', 'LIKE', $location['country'] . '%')->paginate(10);
            }
            elseif ($type == 'Legacy')
            {
                $searchFilteredContent = LegacyPost::where('title', 'LIKE', '%' . $search . '%')->latest('created_at')->paginate(10);
            }
        }
        //Filter by Global
        else
        {

            if ($type == 'Post')
            {
                $searchFilteredContent = Post::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Extension')
            {
                $searchFilteredContent = Extension::whereNull('status')->where('title', 'LIKE', '%' . $search . '%')->latest('created_at')->paginate(10);
            }
            elseif ($type == 'Beacon')
            {

                $searchFilteredContent = Beacon::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->orWhere('beacon_tag', 'LIKE', '%'.$search.'%')->paginate(10);
            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('status', '!=', 'deactivated')->where('name', 'LIKE', '%'.$search.'%')->paginate(10);
            }
            elseif ($type == 'User')
            {
                $searchFilteredContent = User::where('verified', '=', 1)->where('handle', 'LIKE', '%'.$search.'%')->paginate(10);
            }
            elseif ($type == 'Legacy')
            {
                $searchFilteredContent = LegacyPost::where('title', 'LIKE', '%' . $search . '%')->latest('created_at')->paginate(10);
            }
        }
    }
    return $searchFilteredContent;
}

//Creates links from user text (Source: http://code.seebz.net/p/autolink-php/)
function autolink($str, $attributes=array()) {
    $attrs = '';
    foreach ($attributes as $attribute => $value) {
        $attrs .= " {$attribute}=\"{$value}\"";
    }

    $str = ' ' . $str;
    $str = preg_replace(
        '`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
        '$1<a href="$2"'.$attrs.'>$2</a>',
        $str
    );
    $str = substr($str, 1);

    return $str;
}

/*
 * Prepare cards by getting content for posts
 * @param $posts
 * @param $user
 */
function preparePostCards($posts ,$user)
{
    //Filter each post for content and if it is an image or text
    //Check for Elevation
    foreach($posts as $post)
    {
        //Get type of post (i.e Image or Txt)
        $type = substr($post->post_path, -3);
        if($type == 'txt')
        {
            $post->excerpt = autolink($post->excerpt, array("target"=>"_blank","rel"=>"nofollow"));
        }
        else
        {
            $post->caption = autolink($post->caption, array("target"=>"_blank","rel"=>"nofollow"));
        }
        $post->type = $type;

        //Check if viewing user has already elevated post
        if(Elevation::where('post_id', $post->id)->where('user_id', $user->id)->exists())
        {
            $post->elevationStatus = 'Elevated';
        }
        else
        {
            $post->elevationStatus = 'Elevate';
        }
    }
    return $posts;
}

/*
 * Prepare cards by getting content for extensions
 * @param $posts
 * @param $user
 */
function prepareExtensionCards($extensions ,$user)
{

    //Check for Elevation
    foreach($extensions as $extension)
    {
        $extension->excerpt = autolink($extension->excerpt, array("target"=>"_blank","rel"=>"nofollow"));

        //Check if viewing user has already elevated post
        if(Elevation::where('extension_id', $extension->id)->where('user_id', $user->id)->exists())
        {
            $extension->elevationStatus = 'Elevated';
        }
        else
        {
            $extension->elevationStatus = 'Elevate';
        }
    }
    return $extensions;
}

/*
 * Prepare cards by getting content for Legacy Posts
 * @param $posts
 * @param $user
 */
function prepareLegacyPostCards($legacyPosts ,$user)
{
    //Check for Elevation
    foreach($legacyPosts as $legacyPost)
    {

        $legacyPost->excerpt = autolink($legacyPost->excerpt, array("target"=>"_blank","rel"=>"nofollow"));

        //Check if viewing user has already elevated post
        if(Elevation::where('legacy_post_id', $legacyPost->id)->where('user_id', $user->id)->exists())
        {
            $legacyPost->elevationStatus = 'Elevated';
        }
        else
        {
            $legacyPost->elevationStatus = 'Elevate';
        }
    }
    return $legacyPosts;
}

/*
 * Prepare cards by getting content for Legacy Posts
 * @param $posts
 * @param $user
 */
function prepareQuestionCards($questions ,$user)
{
    //Check for Elevation
    foreach($questions as $question)
    {

        //Check if viewing user has already elevated post
        if(Elevation::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $question->elevationStatus = 'Elevated';
        }
        else
        {
            $question->elevationStatus = 'Elevate';
        }
    }
    return $questions;
}

