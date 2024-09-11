<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="full_name">Full name</label>
                <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Write something..." value="{{ $employee->full_name }}">
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Write something..." value="{{ $employee->email }}">
            </div>

            <div class="form-group">
                <label for="client_id">Assign client</label>
                <select name="client_id" id="client_id" class="form-control">
                    <option value="" disabled>Select client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $employee->client_id == $client->id ? 'selected' : '' }}>{{ $client->full_name }}</option>
                    @endforeach
                </select>
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Write something..." value="{{ $employee->phone }}">
        </div>

        <div class="form-group">
            <label for="job">Job</label>
            <input type="text" name="job" id="job" class="form-control" placeholder="Write something..." value="{{ $employee->job }}">
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control" placeholder="Write something...">{{ $employee->note }}</textarea>
        </div>
    </div>

    <div class="col-lg-12">
        <button type="submit" class="btn btn-primary">Edit employee</button>
    </div>

    </form>
</div>
