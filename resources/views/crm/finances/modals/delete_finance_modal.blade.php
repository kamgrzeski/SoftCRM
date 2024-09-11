<div class="modal fade" id="deleteFinanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this finance?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this finance.
            </div>
            <div class="modal-footer">
                @include('crm.finances.forms.delete_finance_form')
            </div>
        </div>
    </div>
</div>
