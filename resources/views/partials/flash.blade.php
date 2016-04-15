@if (Session::has('flash_notification.message'))
    <div class="flash-{{ Session::get('flash_notification.level') }}">
            {{ Session::get('flash_notification.message') }}
    </div>
@endif