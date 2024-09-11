<form action="{{ route('tasks.store') }}" method="POST">
    @csrf

    <div class="form-group input-row">
        <label for="name">Name</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
            <textarea name="name" id="name" class="form-control" placeholder="Write something..."></textarea>
        </div>
    </div>

    <div class="form-group input-row">
        <label for="employee_id">Assign employees</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
            <select name="employee_id" id="employee_id" class="form-control">
                <option value="" disabled selected>{{ App\Traits\Language::getMessage('messages.input_text') }}</option>
                @foreach($employees as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group input-row">
        <label for="duration">Duration</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-handshake-o"></i></span>
            <input type="text" name="duration" id="duration" class="form-control" placeholder="Write something...">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Add task</button>
</form>
