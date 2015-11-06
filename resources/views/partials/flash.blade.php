@if (Session::has('flash_notification.message'))
    <div class="flash-{{ Session::get('flash_notification.level') }}">
        <table align="center">
            <tr>
                <td style="background-color: #202020">{{ Session::get('flash_notification.message') }}</td>
            </tr>
        </table>
    </div>
@endif