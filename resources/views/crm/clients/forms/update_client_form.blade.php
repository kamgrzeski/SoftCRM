<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('clients.update', $clientDetails->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group input-row">
                <label for="full_name">Full name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Write something..." value="{{ $clientDetails->full_name }}">
            </div>

            <div class="form-group input-row">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Write something..." value="{{ $clientDetails->phone }}">
            </div>

            <div class="form-group input-row">
                <label for="budget">Budget</label>
                <input type="text" name="budget" class="form-control" placeholder="Write something..." value="{{ $clientDetails->budget }}">
            </div>

            <div class="form-group input-row">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Write something..." value="{{ $clientDetails->location }}">
            </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="email">Email address</label>
            <input type="text" name="email" class="form-control" placeholder="Write something..." value="{{ $clientDetails->email }}">
        </div>

        <div class="form-group input-row">
            <label for="priority">Priority</label>
            <select name="priority" class="form-control">
                <option value="" disabled {{ is_null($clientDetails->priority) ? 'selected' : '' }}>Please select priority</option>
                <option value="1" {{ $clientDetails->priority == 1 ? 'selected' : '' }}>1</option>
                <option value="2" {{ $clientDetails->priority == 2 ? 'selected' : '' }}>2</option>
                <option value="3" {{ $clientDetails->priority == 3 ? 'selected' : '' }}>3</option>
            </select>
        </div>

        <div class="form-group input-row">
            <label for="section">Section</label>
            <select name="section" class="form-control">
                <option value="" disabled {{ is_null($clientDetails->section) ? 'selected' : '' }}>Please select section</option>
                <option value="transport" {{ $clientDetails->section == 'transport' ? 'selected' : '' }}>Transport</option>
                <option value="logistic" {{ $clientDetails->section == 'logistic' ? 'selected' : '' }}>Logistic</option>
                <option value="finances" {{ $clientDetails->section == 'finances' ? 'selected' : '' }}>Finances</option>
            </select>
        </div>

        <div class="form-group input-row">
            <label for="zip">Zip</label>
            <input type="text" name="zip" class="form-control" placeholder="Write something..." value="{{ $clientDetails->zip }}">
        </div>

        <div class="form-group input-row">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" placeholder="Write something..." value="{{ $clientDetails->city }}">
        </div>

        <div class="form-group input-row">
            <label for="country">Country</label>
            <input type="text" name="country" class="form-control" placeholder="Write something..." value="{{ $clientDetails->country }}">
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Edit client</button>
    </div>
    </form>
</div>
