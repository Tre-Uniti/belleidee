@extends('auth')
@section('pageHeader')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src = "/js/required.js"></script>
@stop
@section('siteTitle')
   About Belle-idee
@stop

@section('centerContent')
    <div class = "contentCard">
        <a href="/img/tour.png" target="_blank"><img id = "tourImage" src = "/img/tour.png" alt="tour" width="100%" height="100%"></a>

    </div>
    <h4>An online community for sharing spiritual ideas, inspirations and experiences.</h4>
    <div class = "linkContainer">
    @if(isset($user))
    @else
        <a href="{{ secure_url('/auth/login') }}" class = "navLink">Login</a>
        <a href="{{ secure_url('/auth/register') }}" class = "navLink">Join</a>
    @endif
    </div>
    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Users
            </h3>
        </div>
        <div id = "centerTextContent">
        <p>
            Anyone can register for a free user account and share within the Belle-idee community.
            If a user is influential within the community then they may ascend the administrative roles (Moderator -> Admin -> Guardian).
            These roles guarantee the community is administered by influential and experienced users.
        </p>
        <p>
            Moderators:
        </p>
        <ol>
            <li>Beacon: Moderate content for a specific Beacon community.</li>
            <li>Global:  Moderate content throughout the entire Belle-idee community.</li>
        </ol>
        <p>Admins:</p>
        <ol>
            <li>Volunteer: Assist with Beacon/Sponsor requests and adjudication of intolerance. </li>
            <li>Employee: Volunteer duties + job function ex. development, marketing, support, etc.</li>
        </ol>
        <p>

        </p>
        <p>Guardians:</p>
        <ul>
            <li>Oversee user ascension, community questions, beliefs, and legacy elections.</li>
        </ul>
        </div>
    </div>



    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Content
            </h3>
        </div>
        <div id = "centerTextContent">
        <p>Users are encouraged to share beautiful ideas, inspirations, and experiences instead of critiquing or arguing for or against a certain belief or way of life.
            If content is intolerant of any belief or way of life it may be flagged by other users and locked by an Admin.
            </p>
        <p>Intolerant review process:</p>
            <ol>
                <li>Registered user flags and submits intolerance report</li>
                <li>Moderator reviews report and makes suggestions if intolerance is found.</li>
                <li>Admin reviews the report and moderator's suggestion to make a final decision.</li>
                <li>If intolerance is found the post is locked until the user removes the intolerance.</li>
                <li>Users will see a report for why a post is locked and may unlock to view it.</li>
                <li>Admin communicates with the post's user to help edit the post for lock removal.</li>
                <li>If user content is found to be illegal then it will be deleted instead of locked.</li>
            </ol>
        </div>
    </div>


    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Beacons
            </h3>
        </div>
        <div id = "centerTextContent">
        <p>Beacons are places of worship and/or thought.
            They represent physical locations where groups of people come together to share ideas, inspirations, and experiences in person.
            Beacons utilize Belle-idee to extend their sharing into the digital world and engage with a wider online audience both locally and globally.</p>
        <ul>
            <li>Common Beacons are libraries, churches, temples, mosques, synagogues, etc.</li>
            <li>Beacons designate a specific user as their "Guide" to lead their community online.</li>
            <li>A "Beacon Tag" is the identifier for a Beacon: Country-City-Shortname (US-SW-ACE)</li>
            <li>Users select a Beacon Tag to connect their content to a specific place/community.</li>
            <li>Beacons can subscribe for an ad-free experience as well as additional features.</li>
        </ul>
        </div>
    </div>
    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>Sponsors</h3>
        </div>
        <div id = "centerTextContent">
        <p>Sponsors are businesses promoting their goods or services within Belle-idee.</p>
        <ul>
            <li>Each user may select their own sponsor to receive exclusive promotions.</li>
            <li>Sponsor logo shows when a user posts content to a Beacon without a subscription.</li>
            <li>Promotions can be open to all or exclusive to loyal sponsored users.</li>
            <li>Users can change their sponsor at any time but will also lose exclusive promos.</li>
            <li>Users control how they receive promotions (email or sponsor's Belle-idee page).</li>
        </ul>
        </div>
    </div>
    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>History</h3>
        </div>
        <div id = "centerTextContent">
        <p>Belle-idee was created for the world to share beautiful ideas from the various beliefs and ways of life.
            It started with a Jesuit giving a copy of his homily to a student at Gonzaga University.
            The idea to share the Jesuit's homily online was the spark for creating an online community focused on sharing spirituality.</p>
            <ul>
                <li>Built on the Laravel framework and <a href = "https://github.com/tre-uniti/belle-idee">open source </a> since 2015.</li>
                <li>Created to be a global online community of spiritual light and guidance.</li>
                <li>Designed for the sharing of beautiful ideas instead of arguments of validity.</li>
            </ul>
        </div>
    </div>
    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>Contact</h3>
        </div>
        <div id = "centerTextContent">
            <p>Belle-idee is one of the three applications built and maintained by <a href = "https://tre-uniti.org/">Tre-Uniti</a>.</p>
            <ul>
                <li>Address: PO Box 888 Sedro-Woolley WA 98284.</li>
                <li>Phone: +1 (347) 897-5562</li>
                <li>Email: tre-uniti@belle-idee.org</li>
            </ul>
        </div>
    </div>
    <a href= "#" class= "back-to-top" >
        Back to Top
        <i class= "fa fa-arrow-circle-up 2x"></i>
    </a>
@stop