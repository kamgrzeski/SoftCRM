<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\FinancesModel;
use App\Services\FinancesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class FinancesController extends Controller
{
    use Language;

    private $systemLogs;
    private $financesModel;
    private $financesService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->financesModel = new FinancesModel();
        $this->financesService = new FinancesService();
    }
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
        $validator = Validator::make($allInputs, $this->financesModel->getRules('STORE'));
        if ($validator->fails()) {
            return Redirect::to('finances/create')->with('message_danger', $validator->errors());
        } else {
            if ($finance = $this->financesModel->insertRow($allInputs)) {

                $this->systemLogs->insertSystemLogs('FinancesModel has been add with id: '. $finance, $this->systemLogs::successCode);
                return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesStore'));
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
                'finances' => $dataOfFinances,
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
        $dataOfFinances = FinancesModel::find($id);
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.finances.edit')
            ->with([
                'finances' => $dataOfFinances,
                'dataWithPluckOfCompanies' => $dataWithPluckOfCompanies
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

        $validator = Validator::make($allInputs, $this->financesModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator->errors());
        } else {
            if ($this->financesModel->updateRow($id, $allInputs)) {
                return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesUpdate'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorFinancesUpdate'));
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

        $this->systemLogs->insertSystemLogs('FinancesModel has been deleted with id: ' . $dataOfFinances->id, $this->systemLogs::successCode);

        return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfFinances = FinancesModel::find($id);

        if ($this->financesModel->setActive($dataOfFinances->id, $value)) {
            $this->systemLogs->insertSystemLogs('FinancesModel has been enabled with id: ' . $dataOfFinances->id, $this->systemLogs::successCode);
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findFinancesByValue = count($this->financesModel->trySearchFinancesByValue('name', $getValueInput, 10));
        $dataOfFinances = $this->getDataAndPagination();

        if (!$findFinancesByValue > 0) {
            return redirect('finances')->with('message_danger', $this->getMessage('messages.ThereIsNoFinances'));
        } else {
            $dataOfFinances += ['finances_search' => $findFinancesByValue];
            Redirect::to('finances/search')->with('message_success', 'Find ' . $findFinancesByValue . ' finances!');
        }

        return View::make('crm.finances.index')->with($dataOfFinances);
    }
}
