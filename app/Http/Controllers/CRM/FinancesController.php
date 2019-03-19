<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinancesStoreRequest;
use View;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Redirect;

class FinancesController extends Controller
{
    public function processListOfFinances()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->financesService->loadDataAndPagination());

        return View::make('crm.finances.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataWithPluckOfCompanies' => $this->financesService->pluckCompanies()]);

        return View::make('crm.finances.create')->with($collectDataForView);
    }
    
    public function viewFinancesDetails($financeId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['finances' => $this->financesService->loadFinance($financeId)]);

        return View::make('crm.finances.show')->with($collectDataForView);
    }

    public function showUpdateForm($financeId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['finances' => $this->financesService->loadFinance($financeId)],
            ['dataWithPluckOfCompanies' => $this->financesService->pluckCompanies()]);

        return View::make('crm.finances.edit')->with($collectDataForView);
    }

    public function processCreateFinances(FinancesStoreRequest $request)
    {
        if ($finance = $this->financesService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('FinancesModel has been add with id: '. $finance, $this->systemLogsService::successCode);
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

        $this->systemLogsService->insertSystemLogs('FinancesModel has been deleted with id: ' . $dataOfFinances->id, $this->systemLogsService::successCode);

        return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesDelete'));
    }

    public function processSetIsActive($financeId, $value)
    {
        if ($this->financesService->loadIsActiveFunction($financeId, $value)) {
            $this->systemLogsService->insertSystemLogs('FinancesModel has been enabled with id: ' . $financeId, $this->systemLogsService::successCode);
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesActive'));
        }
    }
}
