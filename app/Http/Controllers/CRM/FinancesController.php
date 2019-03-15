<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinancesStoreRequest;
use App\Models\FinancesModel;
use App\Services\FinancesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
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

    private function getDataAndPagination()
    {
        $dataOfFinances = [
            'finances' => $this->financesService->getFinances(),
            'financesPaginate' => $this->financesService->getPagination()
        ];

        return $dataOfFinances;
    }

    public function index()
    {
        return View::make('crm.finances.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.finances.create')
            ->with([
                'dataWithPluckOfCompanies' => $this->financesService->pluckCompanies(),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }
    
    public function show($companieId)
    {
        return View::make('crm.finances.show')
            ->with([
                'finances' => $this->financesService->getFinance($companieId),
                'inputText' => $this->getMessage('messages.InputText')
            ]);
    }

    public function edit($companieId)
    {
        return View::make('crm.finances.edit')
            ->with([
                'finances' => $this->financesService->getFinance($companieId),
                'dataWithPluckOfCompanies' => $this->financesService->pluckCompanies()
            ]);
    }

    public function store(FinancesStoreRequest $request)
    {
        if ($finance = $this->financesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('FinancesModel has been add with id: '. $finance, $this->systemLogs::successCode);
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesStore'));
        }
    }

    public function update(Request $request, $companieId)
    {
        if ($this->financesService->update($companieId, $request->all())) {
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorFinancesUpdate'));
        }
    }

    public function destroy($companieId)
    {
        $dataOfFinances = $this->financesService->getFinance($companieId);

        $dataOfFinances->delete();

        $this->systemLogs->insertSystemLogs('FinancesModel has been deleted with id: ' . $dataOfFinances->id, $this->systemLogs::successCode);

        return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesDelete'));
    }

    public function isActiveFunction($companieId, $value)
    {
        if ($this->financesService->loadIsActiveFunction($companieId, $value)) {
            $this->systemLogs->insertSystemLogs('FinancesModel has been enabled with id: ' . $companieId, $this->systemLogs::successCode);
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesActive'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
