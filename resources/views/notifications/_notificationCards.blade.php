@if(!count($notifications))
    <p>No notifications to show!</p>
@else
@foreach ($notifications as $notification)
            @if($notification->source_type == 'Post')
                <article>
                    <div class = "contentCard">
                        <div class = "cardTitleSection">
                            <header>
                                <h3>
                                    <a href="{{ action('NotificationController@post', [$notification->id])}}">{{ $notification->title }}</a>
                                </h3>
                            </header>
                        </div>
                        <div class = "footerSection">
                                @if($notification->type == "Elevated")
                                    <div class = "leftSection"><a href="{{ action('NotificationController@post', [$notification->id])}}" class = "iconLink"> <i class="fa fa-heart fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                                @elseif($notification->type == "Extended")
                                    <div class = "leftSection"><a href="{{ action('NotificationController@extension', [$notification->id])}}" class = "iconLink"><i class="fa fa-comments fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                                @endif
                        </div>
                    </div>
                </article>
            @elseif($notification->source_type == 'Extension')
                <article>
                    <div class = "contentCard">
                        <div class = "cardTitleSection">
                            <header>
                                <h3>
                                    <a href="{{ action('NotificationController@extension', [$notification->id])}}">{{ $notification->title }}</a>
                                </h3>
                            </header>
                        </div>
                        <div class = "footerSection">
                            @if($notification->type == "Elevated")
                                <div class = "leftSection"><a href="{{ action('NotificationController@extension', [$notification->id])}}" class = "iconLink"> <i class="fa fa-heart fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                            @elseif($notification->type == "Extended")
                                <div class = "leftSection"><a href="{{ action('NotificationController@extension', [$notification->id])}}" class = "iconLink"><i class="fa fa-comments fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                            @endif
                        </div>
                    </div>
                </article>
            @elseif($notification->source_type == 'Question')
                <article>
                    <div class = "contentCard">
                        <div class = "cardTitleSection">
                            <header>
                                <h3>
                                    <a href="{{ action('NotificationController@question', [$notification->id])}}">{{ $notification->title }}</a>
                                </h3>
                            </header>
                        </div>
                        <div class = "footerSection">
                            @if($notification->type == "Elevated")
                                <div class = "leftSection"><a href="{{ action('NotificationController@extension', [$notification->id])}}" class = "iconLink"> <i class="fa fa-heart fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                            @elseif($notification->type == "Extended")
                                <div class = "leftSection"><a href="{{ action('NotificationController@extension', [$notification->id])}}" class = "iconLink"><i class="fa fa-comments fa-lg" aria-hidden="true"></i></a>
                                    <a href="{{ action('UserController@show', [$notification->user_id])}}"> by {{ $notification->user->handle }}</a> on {{ $notification->created_at->format('M-d-Y')}}</div>
                            @endif
                        </div>
                    </div>
                </article>
            @endif
@endforeach
    @endif