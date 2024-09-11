<div class="modal fade" id="deleteCompanyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="myModalLabel">You want delete this company?</h4>
            </div>
            <div class="modal-body">
                Action will delete permanently this company.
            </div>
            <div class="modal-footer">
                @include('crm.companies.forms.delete_company_form')
            </div>
        </div>
    </div>
</div>
