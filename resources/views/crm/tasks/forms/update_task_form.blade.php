<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $task->name }}" placeholder="Write something...">
    </div>
    <div class="form-group">
        <label for="duration">Duration</label>
        <input type="text" name="duration" id="duration" class="form-control" value="{{ $task->duration }}" placeholder="Write something...">
    </div>
    <div class="form-group">
        <label for="employee_id">Assign employee</label>
        <select name="employee_id" id="employee_id" class="form-control">
            <option value="" disabled selected>{{ App\Traits\Language::getMessage('messages.input_text') }}</option>
            @foreach($employees as $id => $employee)
                <option value="{{ $id }}" {{ $task->employee_id == $id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Edit task</button>
</form>
