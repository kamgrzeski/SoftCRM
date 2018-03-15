<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\FinancesModel;
use App\Models\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class FinancesController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfFinances = [
            'finances' => FinancesModel::all()->sortByDesc('created_at'),
            'financesPaginate' => FinancesModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataOfFinances;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.finances.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');
        return View::make('crm.finances.create', compact('dataWithPluckOfCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, FinancesModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('finances/create')->with('message_danger', $validator->errors());
        } else {
            if ($finance = FinancesModel::insertRow($allInputs)) {
                SystemLogsController::insertSystemLogs('FinancesModel has been add with id: '. $finance, 200);
                return Redirect::to('finances')->with('message_success', Language::getMessage('messages.SuccessFinancesStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorFinancesStore'));
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
        $dataOfFinances = FinancesModel::find($id);

        return View::make('crm.finances.show')
            ->with([
                'finances' => $dataOfFinances
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
        $dataOfFinances = FinancesModel::find($id);
        $dataWithPluckOfCompaniess = CompaniesModel::pluck('name', 'id');

        return View::make('crm.finances.edit')
            ->with([
                'finances' => $dataOfFinances,
                'companies' => $dataWithPluckOfCompaniess
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

        $validator = Validator::make($allInputs, FinancesModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator->errors());
        } else {
            if (FinancesModel::updateRow($id, $allInputs)) {
                return Redirect::to('finances')->with('message_success', Language::getMessage('messages.SuccessFinancesUpdate'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorFinancesUpdate'));
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
        $dataOfFinances = FinancesModel::find($id);

        $dataOfFinances->delete();

        SystemLogsController::insertSystemLogs('FinancesModel has been deleted with id: ' . $dataOfFinances->id, 200);

        return Redirect::to('finances')->with('message_success', Language::getMessage('messages.SuccessFinancesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfFinances = FinancesModel::find($id);

        if (FinancesModel::setActive($dataOfFinances->id, $value)) {
            SystemLogsController::insertSystemLogs('FinancesModel has been enabled with id: ' . $dataOfFinances->id, 200);
            return Redirect::to('finances')->with('message_success', Language::getMessage('messages.SuccessFinancesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorFinancesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findFinancesByValue = count(FinancesModel::trySearchFinancesByValue('name', $getValueInput, 10));
        $dataOfFinances = $this->getDataAndPagination();

        if (!$findFinancesByValue > 0) {
            return redirect('finances')->with('message_danger', Language::getMessage('messages.ThereIsNoFinances'));
        } else {
            $dataOfFinances += ['finances_search' => $findFinancesByValue];
            Redirect::to('finances/search')->with('message_success', 'Find ' . $findFinancesByValue . ' finances!');
        }

        return View::make('crm.finances.index')->with($dataOfFinances);
    }
}
