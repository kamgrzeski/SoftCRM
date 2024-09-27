<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('clients.update', $client->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group input-row">
                <label for="full_name">Full name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Write something..." value="{{ $client->full_name }}">
            </div>

            <div class="form-group input-row">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Write something..." value="{{ $client->phone }}">
            </div>

            <div class="form-group input-row">
                <label for="budget">Budget</label>
                <input type="text" name="budget" class="form-control" placeholder="Write something..." value="{{ $client->budget }}">
            </div>

            <div class="form-group input-row">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Write something..." value="{{ $client->location }}">
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="email">Email address</label>
            <input type="text" name="email" class="form-control" placeholder="Write something..." value="{{ $client->email }}">
        </div>

        <div class="form-group input-row">
            <label for="priority">Priority</label>
            <select name="priority" class="form-control">
                <option value="" disabled {{ is_null($client->priority) ? 'selected' : '' }}>Please select priority</option>
                <option value="1" {{ $client->priority == 1 ? 'selected' : '' }}>1</option>
                <option value="2" {{ $client->priority == 2 ? 'selected' : '' }}>2</option>
                <option value="3" {{ $client->priority == 3 ? 'selected' : '' }}>3</option>
            </select>
        </div>

        <div class="form-group input-row">
            <label for="section">Section</label>
            <select name="section" class="form-control">
                <option value="" disabled {{ is_null($client->section) ? 'selected' : '' }}>Please select section</option>
                <option value="transport" {{ $client->section == 'transport' ? 'selected' : '' }}>Transport</option>
                <option value="logistic" {{ $client->section == 'logistic' ? 'selected' : '' }}>Logistic</option>
                <option value="finances" {{ $client->section == 'finances' ? 'selected' : '' }}>Finances</option>
            </select>
        </div>

        <div class="form-group input-row">
            <label for="zip">Zip</label>
            <input type="text" name="zip" class="form-control" placeholder="Write something..." value="{{ $client->zip }}">
        </div>

        <div class="form-group input-row">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" placeholder="Write something..." value="{{ $client->city }}">
        </div>

        <div class="form-group input-row">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control" placeholder="Write something..." value="{{ $client->country }}">
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Edit client</button>
    </div>
    </form>
</div>
