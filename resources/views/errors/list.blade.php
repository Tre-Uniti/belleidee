@if ($errors->any())
    <div class = "errors">
    <h4>Your input has the following errors:</h4>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
     </ul>
    </div>
@endif