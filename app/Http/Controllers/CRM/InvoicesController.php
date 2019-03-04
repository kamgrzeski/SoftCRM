<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\CompaniesModel;
use App\Models\InvoicesModel;
use App\Models\ProductsModel;
use App\Services\InvoicesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

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

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithInvoices = [
            'invoices' => $this->invoicesService->getInvoices(),
            'invoicesPaginate' => $this->invoicesService->getPagination()
        ];

        return $dataWithInvoices;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.invoices.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfCompanies = CompaniesModel::pluck('name', 'id');
        $dataOfClient = ClientsModel::pluck('full_name', 'id');
        $dataOfProducts = ProductsModel::pluck('name', 'id');

        return View::make('crm.invoices.create')->with(
            [
                'dataOfCompanies' => $dataOfCompanies,
                'dataOfClient' => $dataOfClient,
                'dataOfProducts' => $dataOfProducts
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, $this->invoicesModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('invoices/create')->with('message_danger', $validator->errors());
        } else {
            if ($invoice = $this->invoicesService->execute($allInputs)) {
                $this->systemLogs->insertSystemLogs('Invoice has been add with id: '. $invoice, $this->systemLogs::successCode);
                return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesStore'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorInvoicesStore'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {

        return View::make('crm.invoices.show')
            ->with([
                'invoices' => $this->invoicesService->getInvoice($id),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return View::make('crm.invoices.edit')
            ->with('invoices', $this->invoicesService->getInvoice($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, $this->invoicesModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->invoicesService->update($id, $allInputs)) {
                return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorInvoicesStore'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $invoicesDetails = $this->invoicesService->getInvoice($id);
        $invoicesDetails->delete();

        $this->systemLogs->insertSystemLogs('InvoicesModel has been deleted with id: ' . $invoicesDetails->id, $this->systemLogs::successCode);

        return Redirect::to('invoices')->with('message_success', $this->getMessage('messages.SuccessInvoicesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $invoicesDetails = InvoicesModel::find($id);

        if ($this->invoicesService->loadIsActiveFunction($invoicesDetails->id, $value)) {
            $this->systemLogs->insertSystemLogs('InvoicesModel has been enabled with id: ' . $invoicesDetails->id, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessInvoicesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.InvoicesIsActived'));
        }
    }
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findInvoicesByValue = $this->invoicesService->loadSearch($getValueInput);
        $dataOfInvoices = $this->getDataAndPagination();

        if (!$findInvoicesByValue > 0) {
            return redirect('invoices')->with('message_danger', $this->getMessage('messages.ThereIsNoInvoices'));
        } else {
            $dataOfInvoices += ['invoices_search' => $findInvoicesByValue];
            Redirect::to('invoices/search')->with('message_success', 'Find ' . $findInvoicesByValue . ' invoices!');
        }

        return View::make('crm.invoices.index')->with($dataOfInvoices);
    }
}
