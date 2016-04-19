<div id = "createOptions">

    <div class = "formInput">
        <b>{!! Form::label('name', 'Beacon Name') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('belief', 'Belief:') !!}
    </div>
    <div class = "formInput">
        {!! Form::select('belief', $beliefs) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('country_code', 'Country:') !!}
    </div>
    <div class = "formInput">
        {!! Form::select('country_code', array(
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
'Ãƒâ€¦land' => 'Ãƒâ€¦land',
'Azerbaijan' => 'Azerbaijan',
'Bosnia And Herzegovina' => 'Bosnia And Herzegovina',
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
'PeopleÃ¢â‚¬â„¢s Republic of China' => 'PeopleÃ¢â‚¬â„¢s Republic of China',
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
'Lao PeopleÃ¢â‚¬â„¢s Democratic Republic' => 'Lao PeopleÃ¢â‚¬â„¢s Democratic Republic',
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
), $beacon->country) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('address', 'Address:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('beacon_tag', 'Beacon Tag:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('beacon_tag', null, ['class' => 'createTitleText', 'placeholder' => 'Country-City-Shortname']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('website', 'Website:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('phone', 'Phone #:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('email', 'Email:') !!}
    </div>
    <div class = "formInput">
        {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
    </div>

    <div class = "formInput">
        {!! Form::label('guide', 'Beacon Guide:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('guide', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('manager', 'Manager:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('manager', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('tier', 'Tier:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('tier', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('Max Upload size: 2MB') !!}
        {!! Form::file('image', null, ['class' => 'navButton']) !!}
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>