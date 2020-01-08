<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinancesStoreRequest;
use App\Services\FinancesService;
use App\Services\SystemLogService;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class FinancesController extends Controller
{
    private $financesService;
    private $systemLogsService;

    public function __construct()
    {
        $this->middleware('auth');

        $this->financesService = new FinancesService();
        $this->systemLogsService = new SystemLogService();
    }

    public function processListOfFinances()
    {
        return View::make('crm.finances.index')->with($this->financesService->loadDataAndPagination());
    }

    public function showCreateForm()
    {
        return View::make('crm.finances.create')->with(['dataWithPluckOfCompanies' => $this->financesService->pluckCompanies()]);
    }

    public function viewFinancesDetails($financeId)
    {
        return View::make('crm.finances.show')->with(['finances' => $this->financesService->loadFinance($financeId)]);
    }

    public function showUpdateForm($financeId)
    {
        return View::make('crm.finances.edit')->with(
            [
                'finances' => $this->financesService->loadFinance($financeId),
                'dataWithPluckOfCompanies' => $this->financesService->pluckCompanies()
            ]
        );
    }

    public function processCreateFinances(FinancesStoreRequest $request)
    {
        if ($finance = $this->financesService->execute($request->validated(), $this->getAdminId())) {
            $this->systemLogsService->insertSystemLogs('FinancesModel has been add with id: ' . $finance, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesStore'));
        }
    }

    public function processUpdateFinances(Request $request, $financeId)
    {
        if ($this->financesService->update($financeId, $request->all())) {
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorFinancesUpdate'));
        }
    }

    public function processDeleteFinances($financeId)
    {
        $dataOfFinances = $this->financesService->loadFinance($financeId);

        $dataOfFinances->delete();

        $this->systemLogsService->insertSystemLogs('FinancesModel has been deleted with id: ' . $dataOfFinances->id, $this->systemLogsService::successCode, $this->getAdminId());

        return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesDelete'));
    }

    public function processSetIsActive($financeId, $value)
    {
        if ($this->financesService->loadIsActiveFunction($financeId, $value)) {
            $this->systemLogsService->insertSystemLogs('FinancesModel has been enabled with id: ' . $financeId, $this->systemLogsService::successCode, $this->getAdminId());
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesActive'));
        }
    }
}
