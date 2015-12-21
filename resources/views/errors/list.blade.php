@if (count($errors) > 0)
    <div class="errors">
    <h3>Woooah! Input Errors:</h3>
    <ul>
        @foreach ($errors->all() as $error)
            <li style = "color:#33FF33; text-align: left; padding-bottom: 3px;">{{ $error }}</li>
        @endforeach
    </ul>
    </div>
@endif