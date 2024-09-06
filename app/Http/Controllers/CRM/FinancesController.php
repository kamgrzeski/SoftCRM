<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceStoreRequest;
use App\Http\Requests\FinanceUpdateRequest;
use App\Jobs\Finance\StoreFinanceJob;
use App\Jobs\Finance\UpdateFinanceJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\FinancesModel;
use App\Services\CompaniesService;
use App\Services\FinancesService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

class FinancesController extends Controller
{
    use DispatchesJobs;
    private FinancesService $financesService;
    private SystemLogService $systemLogsService;
    private CompaniesService $companiesService;

    public function __construct(FinancesService $financesService, SystemLogService $systemLogService, CompaniesService $companiesService)
    {
        $this->middleware(self::MIDDLEWARE_AUTH);

        $this->financesService = $financesService;
        $this->systemLogsService = $systemLogService;
        $this->companiesService = $companiesService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.finances.create')->with(['dataWithPluckOfCompanies' => $this->companiesService->loadCompanies(true)]);
    }

    public function processShowFinancesDetails(FinancesModel $finance)
    {
        return view('crm.finances.show')->with(['finance' => $finance]);
    }

    public function processListOfFinances()
    {
        return view('crm.finances.index')->with([
            'financesPaginate' => $this->financesService->loadPagination()
        ]);
    }

    public function processRenderUpdateForm(FinancesModel $finance)
    {
        return view('crm.finances.edit')->with([
            'finance' => $finance,
            'dataWithPluckOfCompanies' => $this->companiesService->loadCompanies(true)
        ]);
    }

    public function processStoreFinance(FinanceStoreRequest $request)
    {
        $this->dispatchSync(new StoreFinanceJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_store'));
    }

    public function processUpdateFinance(FinanceUpdateRequest $request, FinancesModel $finance)
    {
        $this->dispatchSync(new UpdateFinanceJob($request->validated(), $finance));

        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_update'));
    }

    public function processDeleteFinance(FinancesModel $finance)
    {
        $finance->delete();

        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been deleted with id: ' . $finance->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_delete'));
    }

    public function processFinanceSetIsActive(FinancesModel $finance, $value)
    {
        $this->dispatchSync(new UpdateFinanceJob(['is_active' => $value], $finance));

        $this->dispatchSync(new StoreSystemLogJob('FinancesModel has been enabled with id: ' . $finance->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('finances')->with('message_success', $this->getMessage('messages.finance_update'));
    }
}
