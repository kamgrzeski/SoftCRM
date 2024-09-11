<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="form-group input-row">
                <label for="full_name">Full name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="full_name" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="phone">Phone</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                    <input type="text" name="phone" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="email">Email</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                    <input type="text" name="email" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="job">Job</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                    <input type="text" name="job" class="form-control" placeholder="Write something...">
                </div>
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="client_id">Assign client</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="client_id" class="form-control">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->full_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group input-row">
            <label for="note">Note</label>
            <textarea name="note" class="form-control" placeholder="Write something..."></textarea>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Add employee</button>
    </div>
    </form>
</div>
