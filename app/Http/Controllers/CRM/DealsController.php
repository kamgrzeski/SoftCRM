<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\DealsModel;
use App\Services\DealsService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class DealsController extends Controller
{
    use Language;

    private $systemLogs;
    private $dealsModel;
    private $dealsService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->dealsModel = new DealsModel();
        $this->dealsService = new DealsService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => $this->dealsService->getDeals(),
            'dealsPaginate' => $this->dealsService->getPaginate()
        ];

        return $dataOfDeals;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.deals.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfDeals = CompaniesModel::pluck('name', 'id');

        return View::make('crm.deals.create')->with([
            'dataOfDeals' => $dataOfDeals,
            'inputText' => $this->getMessage('messages.InputText')
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

        $validator = Validator::make($allInputs, $this->dealsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('deals/create')->with('message_danger', $validator->errors());
        } else {
            if ($deal = $this->dealsService->execute($allInputs)) {
                $this->systemLogs->insertSystemLogs('Deal has been add with id: '. $deal, $this->systemLogs::successCode);
                return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsStore'));
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
       return View::make('crm.deals.show')
            ->with('deals', $this->dealsService->getDeal($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.deals.edit')
            ->with([
                'deals' => $this->dealsService->getDeal($id),
                'companies' => $dataWithPluckOfCompanies
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

        $validator = Validator::make($allInputs, $this->dealsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->dealsService->update($id, $allInputs)) {
                return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsUpdate'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsUpdate'));
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
        $dataOfDeals = $this->dealsService->getDeal($id);
        $dataOfDeals->delete();

        $this->systemLogs->insertSystemLogs('DealsModel has been deleted with id: ' .$dataOfDeals->id, $this->systemLogs::successCode);

        return Redirect::to('deals')->with('message_success', $this->getMessage('messages.SuccessDealsDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfDeals = DealsModel::find($id);

        if ($this->dealsModel->setActive($dataOfDeals->id, $value)) {
            $this->systemLogs->insertSystemLogs('DealsModel has been enabled with id: ' .$dataOfDeals->id, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorDealsActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findDealsByValue = $this->dealsService->loadSearch($getValueInput);
        $dataOfDeals = $this->getDataAndPagination();

        if (!$findDealsByValue > 0) {
            return redirect('deals')->with('message_danger', $this->getMessage('messages.ThereIsNoDeals'));
        } else {
            $dataOfDeals += ['deals_search' => $findDealsByValue];
            Redirect::to('deals/search')->with('message_success', 'Find ' . $findDealsByValue . ' deals!');
        }

        return View::make('crm.deals.index')->with($dataOfDeals);
    }
}
