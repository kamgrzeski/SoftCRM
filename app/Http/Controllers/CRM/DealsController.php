<?php

namespace App\Http\Controllers\CRM;

use App\Enums\SystemEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealStoreRequest;
use App\Http\Requests\DealUpdateRequest;
use App\Http\Requests\StoreDealTermRequest;
use App\Jobs\Deal\StoreDealJob;
use App\Jobs\Deal\StoreDealTermJob;
use App\Jobs\Deal\UpdateDealJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use App\Services\DealsService;
use App\Services\SystemLogService;
use Illuminate\Foundation\Bus\DispatchesJobs;

class DealsController extends Controller
{
    use DispatchesJobs;
    private DealsService $dealsService;
    private SystemLogService $systemLogsService;

    public function __construct(DealsService $dealsService, SystemLogService $systemLogService)
    {
        $this->middleware(SystemEnums::middleWareAuth);

        $this->dealsService = $dealsService;
        $this->systemLogsService = $systemLogService;
    }

    public function processRenderCreateForm()
    {
        return view('crm.deals.create')->with(['dataOfDeals' => $this->dealsService->pluckDeals()]);
    }

    public function processShowDealsDetails(DealsModel $deal)
    {
        return view('crm.deals.show')->with([
            'deal' => $deal,
            'dealsTerms' => $this->dealsService->loadDealsTerms($deal)
        ]);
    }

    public function processListOfDeals()
    {
        return view('crm.deals.index')->with(
            [
                'dealsPaginate' => $this->dealsService->loadPaginate()
            ]
        );
    }

    public function processRenderUpdateForm(DealsModel $deal)
    {
        return view('crm.deals.edit')->with(
            [
                'deal' => $deal,
                'companies' => $this->dealsService->pluckDeals()
            ]
        );
    }

    public function processStoreDeal(DealStoreRequest $request)
    {
        $this->dispatchSync(new StoreDealJob($request->validated(), auth()->user()));

        $this->dispatchSync(new StoreSystemLogJob('Deal has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsStore'));
    }

    public function processUpdateDeal(DealUpdateRequest $request, DealsModel $deal)
    {
        $this->dispatchSync(new UpdateDealJob($request->validated(), $deal));

        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsUpdate'));
    }

    public function processDeleteDeal(DealsModel $deal)
    {
        if ($deal->dealTerms()->count() > 0) {
            return redirect()->back()->with('message_danger', $this->getMessage('messages.firstDeleteDealTerms'));
        }

        $deal->delete();

        $this->dispatchSync(new StoreSystemLogJob('Deals has been deleted with id: ' . $deal->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    public function processSetIsActive(DealsModel $deal, bool $value)
    {
        $this->dispatchSync(new UpdateDealJob(['is_active' => $value], $deal));

        $this->dispatchSync(new StoreSystemLogJob('Deals has been enabled with id: ' . $deal->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->to('deals')->with('message_success', $this->getMessage('messages.' . $value ? 'SuccessDealsActive' : 'DealsIsNowDeactivated'));
    }

    public function processStoreDealTerms(StoreDealTermRequest $request, DealsModel $deal)
    {
        $this->dispatchSync(new StoreDealTermJob($request->validated(), $deal));

        $this->dispatchSync(new StoreSystemLogJob('Deals terms has been added.', $this->systemLogsService::successCode, auth()->user()));

        return redirect()->back()->with('message_success', $this->getMessage('messages.SuccessDealTermStore'));
    }

    public function processGenerateDealTermsInPDF(DealsTermsModel $dealTerm, DealsModel $deal)
    {
        return $this->dealsService->loadGenerateDealTermsInPDF($dealTerm->id, $deal->id);
    }

    public function processDeleteDealTerm(DealsTermsModel $dealTerm)
    {
        $dealTerm->delete();

        $this->dispatchSync(new StoreSystemLogJob('Deal terms has been deleted with id: ' . $dealTerm->id, $this->systemLogsService::successCode, auth()->user()));

        return redirect()->back()->with('message_success', $this->getMessage('messages.SuccessDealsTermDelete'));
    }
}
