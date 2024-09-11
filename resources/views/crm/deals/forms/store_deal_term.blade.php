<form action="{{ route('deals.terms.store', ['deal' => $deal->id]) }}" method="POST">
    @csrf

    <div class="col-lg-12 editor-style">
        <textarea name="body" class="form-control" id="summary-ckeditor">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.</textarea>
    </div>

    <div class="col-lg-12 validate_form">
        <button type="submit" class="btn btn-primary">Save terms of agreement</button>
    </div>
</form>
