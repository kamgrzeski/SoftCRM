@if(Session::has('message_error'))
    <div class="alert alert-danger">
        <strong>Danger!</strong> {{ Session::get('message_error') }}
    </div>
@elseif(Session::has('message_success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{ Session::get('message_success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
