<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoicesStoreRequest;
use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\InvoicesModel;
use App\Models\ProductsModel;
use App\Services\InvoicesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;
use Config;
use Response;

class InvoicesController extends Controller
{
    use Language;

    private $systemLogs;
    private $invoicesModel;
    private $invoicesService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->invoicesModel = new InvoicesModel();
        $this->invoicesService = new InvoicesService();
    }

    private function getDataAndPagination()
    {
        $dataWithInvoices = [
            'invoices' => $this->invoicesService->getInvoices(),
            'invoicesPaginate' => $this->invoicesService->getPagination()
        ];

        return $dataWithInvoices;
    }

    public function index()
    {
        return View::make('crm.invoices.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        $dataOfCompanies = CompaniesModel::pluck('name', 'id');
        $dataOfClient = ClientsModel::pluck('full_name', 'id');
        $dataOfProducts = ProductsModel::pluck('name', 'id');

        return View::make('crm.invoices.create')->with(
            [
                'dataOfCompanies' => $dataOfCompanies,
                'dataOfClient' => $dataOfClient,
                'dataOfProducts' => $dataOfProducts,
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function show($invoiceId)
    {

        return View::make('crm.invoices.show')
            ->with([
                'invoices' => $this->invoicesService->getInvoice($invoiceId),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function edit($invoiceId)
    {
        return View::make('crm.invoices.edit')
            ->with('invoices', $this->invoicesService->getInvoice($invoiceId));
    }

    public function store(InvoicesStoreRequest $request)
    {
        if ($invoice = $this->invoicesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('Invoice has been add with id: '. $invoice, $this->systemLogs::successCode);
            return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesStore'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorInvoicesStore'));
        }
    }

    public function update(Request $request, int $invoiceId)
    {
        if ($this->invoicesService->update($invoiceId, $request->all())) {
            return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorInvoicesStore'));
        }
    }

    public function destroy($invoiceId)
    {
        $invoicesDetails = $this->invoicesService->getInvoice($invoiceId);
        $invoicesDetails->delete();

        $this->systemLogs->insertSystemLogs('InvoicesModel has been deleted with id: ' . $invoicesDetails->id, $this->systemLogs::successCode);

        return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesDelete'));
    }

    public function isActiveFunction($invoiceId, $value)
    {
        if ($this->invoicesService->loadIsActiveFunction($invoiceId, $value)) {
            $this->systemLogs->insertSystemLogs('InvoicesModel has been enabled with id: ' . $invoiceId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessInvoicesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.InvoicesIsActived'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
