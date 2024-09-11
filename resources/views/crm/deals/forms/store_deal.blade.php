<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('deals.store') }}" method="POST">
            @csrf

            <div class="form-group input-row">
                <label for="name">Name</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="start_time">Start date</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="date" name="start_time" id="start_time" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="Write something...">
                </div>
            </div>

    </div>
    <div class="col-lg-6">
        <div class="form-group input-row">
            <label for="end_time">End date</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" name="end_time" id="end_time" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="Write something...">
            </div>
        </div>

        <div class="form-group input-row">
            <label for="companies_id">Deal between company:</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
                <select name="companies_id" id="companies_id" class="form-control">
                    <option value="" disabled selected>Please select company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Add deal</button>
    </div>

    </form>
</div>
