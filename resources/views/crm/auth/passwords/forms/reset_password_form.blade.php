<form action="{{ route('password.reset.process') }}" method="POST">
    @csrf

    <div class="col-lg-12">
        <div class="form-group input-row">
            <label for="old_password">Old password</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                <input type="text" name="old_password" id="old_password" class="form-control" placeholder="Write something...">
            </div>
        </div>
        <div class="form-group input-row">
            <label for="new_password">New password</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                <input type="text" name="new_password" id="new_password" class="form-control" placeholder="Write something...">
            </div>
        </div>
        <div class="form-group input-row">
            <label for="confirm_password">Repeat new password</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                <input type="text" name="confirm_password" id="confirm_password" class="form-control" placeholder="Write something...">
            </div>
        </div>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Change password</button>
    </div>
</form>
