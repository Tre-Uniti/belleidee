<?php

namespace App\Http;

use App\Beacon;
use App\Elevation;
use App\Events\BeaconViewed;
use App\Events\SponsorViewed;
use App\Extension;
use App\Post;
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
            $sponsor = NULL;
        }
    }
    else
    {
        $sponsor = NULL;
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

    $beacon = Beacon::where('beacon_tag', '=', $content->beacon_tag)->first();

    if ($beacon != NULL && $beacon->tier >= 1)
    {
        //Beacon pays subscription for promotions
        Event::fire(new BeaconViewed($beacon));
    }
    else
    {
        $beacon = NULL;
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

/*
 * Retrieve content for a given user's location
 *
 * @param $user
 * @param $number (0 = only 10 records, 1 = paginate)
 * @param type Defines if what type of location filter is needed
 */
function filterContentLocation($user, $number, $type)
{
    $location = session('coordinates');

    //Simple Index (i.e Post and Extension main indexes)
    if($number == 0)
    {
        //Filter by local
        if($user->location == 0)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->take(10)->get();
            }
        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->where('beacon_tag', 'LIKE', $location['country'].'%')->latest('created_at')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->where('beacon_tag', 'LIKE', $location['country'].'%')->latest('created_at')->take(10)->get();
            }
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $filteredContent = Post::whereNull('status')->latest('created_at')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->latest('created_at')->take(10)->get();
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
                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::where('beacon_tag', 'LIKE', $location['shortTag'].'%')->where('status', '!=', 'deactivated')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::where('country', '=', $location['country'])->where('city', '=', $location['cityName']. '-' . $location['cityCode'])->latest('created_at')->paginate(10);
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
                $filteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'].'%')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->where('status', '!=', 'deactivated')->latest('created_at')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::where('country', '=', $location['country'])->latest('created_at')->paginate(10);
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
                $filteredContent = User::where('verified', '=', 1)->latest('created_at')->paginate(10);
            }
            elseif($type == 'Beacon')
            {
                $filteredContent = Beacon::latest('created_at')->where('status', '!=', 'deactivated')->paginate(10);
            }
            elseif($type == 'Sponsor')
            {
                $filteredContent = Sponsor::latest('created_at')->paginate(10);
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
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('post_id')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->take(10)->get();
            }
        }
        //Filter by Country
        elseif($user->location == 1)
        {
            if($type == 'Post')
            {
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('post_id')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->take(10)->get();
            }
        }
        //Filter by Global
        else
        {
            if($type == 'Post')
            {
                $filteredContent = Elevation::where('post_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('post_id')->take(10)->get();
            }
            elseif($type == 'Extension')
            {
                $filteredContent = Elevation::where('extension_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->take(10)->get();
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
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->latest('created_at')->take(10)->get();
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->where('beacon_tag', 'LIKE', $location['shortTag'].'%')->orderByRaw('max(created_at) desc')->groupBy('extenception')->take(10)->get();
            }
        }
        elseif($user->location == 1)
        {
            if ($type == 'Post')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->latest('created_at')->take(10)->get();
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->where('beacon_tag', 'LIKE', $location['country']. '-'. '%')->orderByRaw('max(created_at) desc')->groupBy('extenception')->take(10)->get();
            }
        }
        elseif($user->location == 2)
        {
            if ($type == 'Post')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('post_id')->latest('created_at')->take(10)->get();
            }
            elseif ($type == 'Extension')
            {
                $filteredContent = Extension::whereNull('status')->whereNotNull('extenception')->orderByRaw('max(created_at) desc')->groupBy('extenception')->take(10)->get();
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
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['shortTag'] . '%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
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
                $timeFilteredContent = User::where('verified', '=', 1)->where('last_tag', 'LIKE', $location['country'] . '%')->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
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
                $timeFilteredContent = User::where('verified', '=', 1)->where('created_at', '>=', Carbon::now()->$time())->orderBy($order, 'desc')->paginate(10);
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
        }
    }
    return $timeFilteredContent;
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
        $coordinates = session('coordinates');
        $location = 'Global';
    }
    else
    {
        $location = 'Undefined';
    }

    return $location;
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
            elseif ($type == 'Beacon-Name' || $type == 'Beacon-Tag')
            {
                if($type == 'Beacon-Name')
                {
                    $searchFilteredContent = Beacon::where('name', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->paginate(10);
                }
                elseif($type == 'Beacon-Tag')
                {
                    $searchFilteredContent = Beacon::where('beacon_tag', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['shortTag'] . '%')->paginate(10);
                }
            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('name', 'LIKE', '%'.$search.'%')->where('city', '=', $location['cityName'] . '-' . $location['cityCode'])->paginate(10);
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
            elseif ($type == 'Beacon-Name' || $type == 'Beacon-Tag')
            {
                if($type == 'Beacon-Name')
                {
                    $searchFilteredContent = Beacon::where('name', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['country'] . '%')->paginate(10);
                }
                elseif($type == 'Beacon-Tag')
                {
                    $searchFilteredContent = Beacon::where('beacon_tag', 'LIKE', '%'.$search.'%')->where('beacon_tag', 'LIKE', $location['country'] . '%')->paginate(10);
                }
            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('name', 'LIKE', '%'.$search.'%')->where('country', '=', $location['country'])->paginate(10);
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
            elseif ($type == 'Beacon-Name' || $type == 'Beacon-Tag')
            {
                if($type == 'Beacon-Name')
                {
                    $searchFilteredContent = Beacon::where('name', 'LIKE', '%'.$search.'%')->paginate(10);
                }
                elseif($type == 'Beacon-Tag')
                {
                    $searchFilteredContent = Beacon::where('beacon_tag', 'LIKE', '%'.$search.'%')->paginate(10);
                }
            }
            elseif ($type == 'Sponsor')
            {
                $searchFilteredContent = Sponsor::where('name', 'LIKE', '%'.$search.'%')->where('country', '=', $location['country'])->paginate(10);
            }
        }
    }
    return $searchFilteredContent;
}
