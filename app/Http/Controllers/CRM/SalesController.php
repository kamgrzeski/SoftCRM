<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ProductsModel;
use App\Models\SalesModel;
use App\Services\SalesService;
use App\Services\SystemLogService;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class SalesController extends Controller
{
    private $systemLogs;
    private $language;
    private $salesModel;
    private $salesService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->language = new Language();
        $this->salesModel = new SalesModel();
        $this->salesService = new SalesService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithSaless = [
            'sales' => SalesModel::all()->sortByDesc('created_at'),
            'salesPaginate' => SalesModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithSaless;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.sales.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfProducts = ProductsModel::pluck('name', 'id');

        return View::make('crm.sales.create')->with(
            [
                'dataOfProducts' => $dataOfProducts,
                'inputText' => $this->language->getMessage('messages.InputText')
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

        $validator = Validator::make($allInputs, $this->salesModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('sales/create')->with('message_danger', $validator->errors());
        } else {
            if ($sale = $this->salesModel->insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('SalesModel has been add with id: ' . $sale, 200);
                return Redirect::to('sales')->with('message_success', $this->language->getMessage('messages.SuccessSalesStore'));
            } else {
                return Redirect::back()->with('message_success', $this->language->getMessage('messages.ErrorSalesStore'));
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
        $dataOfSales = SalesModel::find($id);

        return View::make('crm.sales.show')
            ->with([
                'sales' => $dataOfSales,
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
//        $salesDetails = SalesModel::find($id);
//
//        return View::make('crm.sales.edit')
//            ->with('sales', $salesDetails);

        $salesDetails = SalesModel::find($id);
        $dataWithPluckOfProducts = ProductsModel::pluck('name', 'id');

        return View::make('crm.sales.edit')
            ->with([
                'sales' => $salesDetails,
                'dataWithPluckOfProducts' => $dataWithPluckOfProducts
            ]);
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

        $validator = Validator::make($allInputs, $this->salesModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->salesModel->updateRow($id, $allInputs)) {
                return Redirect::to('sales')->with('message_success', $this->language->getMessage('messages.SuccessSalesStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->language->getMessage('messages.ErrorSalesStore'));
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
        $salesDetails = SalesModel::find($id);
        $salesDetails->delete();

        $this->systemLogs->insertSystemLogs('SalesModel has been deleted with id: ' . $salesDetails->id, 200);

        return Redirect::to('sales')->with('message_success', $this->language->getMessage('messages.SuccessSalesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $salesDetails = SalesModel::find($id);

        if ($this->salesModel->setActive($salesDetails->id, $value)) {
            $this->systemLogs->insertSystemLogs('SalesModel has been enabled with id: ' . $salesDetails->id, 200);
            return Redirect::back()->with('message_success', $this->language->getMessage('messages.SuccessSalesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->language->getMessage('messages.SalesIsActived'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findSalesByValue = count(SalesModel::trySearchSalesByValue('full_name', $getValueInput, 10));
        $dataOfSales = $this->getDataAndPagination();

        if (!$findSalesByValue > 0) {
            return redirect('sales')->with('message_danger', $this->language->getMessage('messages.ThereIsNoSales'));
        } else {
            $dataOfSales += ['sales_search' => $findSalesByValue];
            Redirect::to('sales/search')->with('message_success', 'Find ' . $findSalesByValue . ' sales!');
        }

        return View::make('crm.sales.index')->with($dataOfSales);
    }
}
