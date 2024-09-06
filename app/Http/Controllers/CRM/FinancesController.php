<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceStoreRequest;
use App\Http\Requests\FinanceUpdateRequest;
use App\Jobs\StoreSystemLogJob;
use App\Services\CompaniesService;
use App\Services\FinancesService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;
Use Illuminate\Support\Facades\Redirect;

class FinancesController extends Controller
{
    use DispatchesJobs;
    private FinancesService $financesService;
    private SystemLogService $systemLogsService;
    private CompaniesService $companiesService;

    public function __construct(FinancesService $financesService, SystemLogService $systemLogService, CompaniesService $companiesService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->financesService = $financesService;
        $this->systemLogsService = $systemLogService;
        $this->companiesService = $companiesService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.finances.create')->with(['dataWithPluckOfCompanies' => $this->companiesService->loadCompanies(true)]);
    }

    public function processShowFinancesDetails($financeId)
    {
        return view('crm.finances.show')->with(['finance' => $this->financesService->loadFinance($financeId)]);
    }

    public function processListOfFinances()
    {
        return view('crm.finances.index')->with(
            [
                'financesPaginate' => $this->financesService->loadPagination()
            ]
        );
    }

    public function processRenderUpdateForm($financeId)
    {
        return view('crm.finances.edit')->with(
            [
                'finance' => $this->financesService->loadFinance($financeId),
                'dataWithPluckOfCompanies' => $this->companiesService->loadCompanies(true)
            ]
        );
    }

    public function processStoreFinance(FinanceStoreRequest $request)
    {
        $storedFinanceId = $this->financesService->execute($request->validated(), $this->getAdminId());

        if ($storedFinanceId) {
            $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been add with id: ' . $storedFinanceId, $this->systemLogsService::successCode, auth()->user()));
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesStore'));
        }
    }

    public function processUpdateFinance(FinanceUpdateRequest $request, $financeId)
    {
        if ($this->financesService->update($financeId, $request->validated())) {
            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorFinancesUpdate'));
        }
    }

    public function processDeleteFinance($financeId)
    {
        $dataOfFinances = $this->financesService->loadFinance($financeId);

        $dataOfFinances->delete();

        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been deleted with id: ' . $dataOfFinances->id, $this->systemLogsService::successCode, auth()->user()));

        return Redirect::to('finances')->with('message_success', $this->getMessage('messages.SuccessFinancesDelete'));
    }

    public function processFinanceSetIsActive($financeId, $value)
    {
        if ($this->financesService->loadIsActive($financeId, $value)) {
            $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been enabled with id: ' . $financeId, $this->systemLogsService::successCode, auth()->user()));

            return Redirect::to('finances')->with('message_success', $this->getMessage('messages.' . $value ? 'SuccessFinancesActive' : 'FinancesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFinancesActive'));
        }
    }
}
