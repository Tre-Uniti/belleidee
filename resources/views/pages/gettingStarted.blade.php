@extends('app')
@section('siteTitle')
    Getting Started
@stop

@section('centerText')
    <h2>Welcome, {{ $user->handle }}</h2>
    <article>
        <div class = "contentCard">
            <header>
                <div class = "cardTitleSection">
                    <h3>
                        Startup Guide
                    </h3>

                    <p class = "contentHandle">We recommend completing this guide to help you get started.</p>
                    <div>
                        <progress max="5" value="{{ $user->startup }}">
                            <div class="progress-bar">
                                <span style="width: {{ $user->startup * 2 }}%;">Progress: {{ $user->startup }} / 5</span>
                            </div>
                        </progress>
                    </div>
                </div>
            </header>
            </div>
    </article>

    <a href="{{ url('/home/skip') }}" class = " navLink">Skip for Now</a>
<hr class = "contentSeparator"/>
    @if($startupList['following'] == 0)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>Follow a User</h3>

                    <p>Anyone can join, <a href =" {{ url('/invites') }}">invite your friends!</a> </p>
                    <p>Following a User adds their posts to the "For You" areas.</p>

                    <a href = "{{ url('/users') }}" class = "indexLink">User Directory</a>
                    @if($user->last_tag == null)
                        <a href = "{{ url('/users') }}" class = "indexLink">Find Nearby</a>
                    @else
                    <a href = "{{ url('/users') }}" class = "indexLink">Find Nearby</a>
                    @endif
                </header>
            </div>
        </div>
    </article>
    @endif
    @if($startupList['beacon'] == 0)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>Connect to a Beacon</h3>
                    <p>Beacons are places of worship or thought.</p>
                    <p>Connecting allows you to engage with their online community.</p>

                    <a href = "{{ url('/beacons') }}" class = "indexLink">Beacon Directory</a>
                    <a href = "{{ url('/beacons') }}" class = "indexLink">Find Nearby</a>
                </header>
            </div>
        </div>
    </article>
    @endif
    @if($startupList['sponsor'] == 0)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>Start a Sponsorship</h3>

                    <p>Sponsors are businesses or non-profits.</p>
                    <p>Sponsorships give you access to exclusive promotions.</p>

                    <a href = "{{ url('/sponsors') }}" class = "indexLink">Sponsor Directory</a>
                    <a href = "{{ url('/sponsors') }}" class = "indexLink">Find Nearby</a>
                </header>
            </div>
        </div>
    </article>
    @endif
    @if($startupList['post'] == 0)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>Create a Post</h3>

                    <p>Each Post is connected to a Beacon.</p>
                    <p>Drafts are private until converted to public Posts.</p>
                    <p>Share beautiful ideas, values, and experiences instead of criticisms.</p>

                    <a href = "{{ url('/drafts/create') }}" class = "indexLink">Create Draft</a>
                    <a href = "{{ url('/posts/create') }}" class = "indexLink">Create Post</a>
                </header>
            </div>
        </div>
    </article>
    @endif
    @if($startupList['extension'] == 0)
    <article>
        <div class = "contentCard">
            <div class = "cardTitleSection">
                <header>
                    <h3>Create an Extension</h3>
                    <p>Each Extension is connected to a Beacon.</p>
                    <p>Posts, Questions, and Legacies can all be extended.</p>
                    <p>An extension should add to the source instead of criticising it.</p>

                    <a href = "{{ url('/posts') }}" class = "indexLink">Posts</a>
                    <a href = "{{ url('/questions') }}" class = "indexLink">Questions</a>
                    <a href = "{{ url('/legacies') }}" class = "indexLink">Legacies</a>
                </header>
            </div>
        </div>
    </article>
    @endif
@stop



