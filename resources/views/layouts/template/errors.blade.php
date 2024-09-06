@if(Session::has('message-error'))
    <div class="alert alert-danger">
        <strong>Danger!</strong> {{ Session::get('message-error') }}
    </div>
@elseif(Session::has('message-success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{ Session::get('message-success') }}
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
