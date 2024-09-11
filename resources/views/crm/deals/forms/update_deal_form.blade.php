<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('deals.update', $deal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group input-row">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $deal->name }}" placeholder="Write something...">
            </div>

            <div class="form-group input-row">
                <label for="start_time">Start date</label>
                <input type="date" name="start_time" id="start_time" class="form-control" value="{{ $deal->start_time }}" placeholder="Write something...">
            </div>
    </div>

    <div class="col-lg-6">

        <div class="form-group input-row">
            <label for="end_time">End date</label>
            <input type="date" name="end_time" id="end_time" class="form-control" value="{{ $deal->end_time }}" placeholder="Write something...">
        </div>

        <div class="form-group input-row">
            <label for="companies_id">Deal between company:</label>
            <select name="companies_id" id="companies_id" class="form-control">
                <option value="" disabled selected>{{ App\Traits\Language::getMessage('messages.input_text') }}</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $deal->companies_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Edit deals</button>
    </div>

    </form>
</div>
