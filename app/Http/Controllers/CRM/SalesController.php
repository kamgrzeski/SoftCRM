<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Language;
use App\Sales;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class SalesController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithSaless = [
            'sales' => Sales::all(),
            'salesPaginate' => Sales::paginate(Config::get('crm_settings.pagination_size'))
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
        return View::make('crm.sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Sales::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('sales/create')->with('message_danger', $validator->errors());
        } else {
            if ($sale = Sales::insertRow($allInputs)) {
                SystemLogsController::insertSystemLogs('Sales has been add with id: '. $sale);
                return Redirect::to('sales')->with('message_success', Language::getMessage('messages.SuccessSalesStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorSalesStore'));
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
        $dataOfSales = Sales::find($id);

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
        $salesDetails = Sales::find($id);

        return View::make('crm.sales.edit')
            ->with('sales', $salesDetails);
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

        $validator = Validator::make($allInputs, Sales::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Sales::updateRow($id, $allInputs)) {
                return Redirect::to('sales')->with('message_success', Language::getMessage('messages.SuccessSalesStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorSalesStore'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $salesDetails = Sales::find($id);
        $salesDetails->delete();

        SystemLogsController::insertSystemLogs('Sales has been deleted with id: ' . $salesDetails->id);

        return Redirect::to('sales')->with('message_success', Language::getMessage('messages.SuccessSalesDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $salesDetails = Sales::find($id);

        if (Sales::setActive($salesDetails->id, TRUE)) {
            SystemLogsController::insertSystemLogs('Sales has been enabled with id: ' . $salesDetails->id);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessSalesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.SalesIsActived'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $salesDetails = Sales::find($id);

        if (Sales::setActive($salesDetails->id, FALSE)) {
            SystemLogsController::insertSystemLogs('Sales has been disabled with id: ' . $salesDetails->id);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SalesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.SalesIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findSalesByValue = count(Sales::trySearchSalesByValue('full_name', $getValueInput, 10));
        $dataOfSales = $this->getDataAndPagination();

        if (!$findSalesByValue > 0) {
            return redirect('sales')->with('message_danger', Language::getMessage('messages.ThereIsNoSales'));
        } else {
            $dataOfSales += ['sales_search' => $findSalesByValue];
            Redirect::to('sales/search')->with('message_success', 'Find ' . $findSalesByValue . ' sales!');
        }

        return View::make('crm.sales.index')->with($dataOfSales);
    }
}
