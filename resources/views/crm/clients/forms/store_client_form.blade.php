<div class="row">
    <div class="col-lg-6">
        <form action="{{ route('clients.store') }}" method="POST">
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
                <label for="budget">Budget</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                    <input type="text" name="budget" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="city">City</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input type="text" name="city" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="country">Country</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                    <input type="text" name="country" class="form-control" placeholder="Write something...">
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-6">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="form-group input-row">
                <label for="email">Email address</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                    <input type="text" name="email" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="section">Section</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-feed"></i></span>
                    <select name="section" class="form-control">
                        <option value="">Please select section</option>
                        <option value="transport">Transport</option>
                        <option value="logistic">Logistic</option>
                        <option value="finances">Finances</option>
                    </select>
                </div>
            </div>

            <div class="form-group input-row">
                <label for="location">Location</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-pie-chart"></i></span>
                    <input type="text" name="location" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="form-group input-row">
                <label for="zip">ZIP</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-registered"></i></span>
                    <input type="text" name="zip" class="form-control" placeholder="Write something...">
                </div>
            </div>

            <div class="col-lg-12 validate_form">
                <button type="submit" class="btn btn-primary">Add client</button>
            </div>
        </form>
    </div>
</div>
