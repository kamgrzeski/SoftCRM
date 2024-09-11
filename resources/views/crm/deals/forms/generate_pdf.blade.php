<form action="{{ route('deals.terms.generate-pdf', ['dealTerm' => $terms->id, 'deal' => $deal->id]) }}" method="POST" class="pull-right">
    @csrf

    <button type="submit" class="btn btn-small btn-padding btn-pdf">Generate PDF</button>
</form>
