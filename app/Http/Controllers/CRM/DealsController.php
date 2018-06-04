<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\DealsModel;
use App\Models\Language;
use App\Services\SystemLogService;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class DealsController extends Controller
{
    private $systemLogs;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => DealsModel::all()->sortByDesc('created_at'),
            'dealsPaginate' => DealsModel::paginate(Config::get('crm_settings.pagination_size'))
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
        return View::make('crm.deals.create', compact('dataOfDeals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, DealsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('deals/create')->with('message_danger', $validator->errors());
        } else {
            if ($deal = DealsModel::insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('Deal has been add with id: '. $deal, 200);
                return Redirect::to('deals')->with('message_success', Language::getMessage('messages.SuccessDealsStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorDealsStore'));
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
        $dataOfDeals = DealsModel::find($id);

        return View::make('crm.deals.show')
            ->with('deals', $dataOfDeals);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataOfDeals = DealsModel::find($id);
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.deals.edit')
            ->with([
                'deals' => $dataOfDeals,
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

        $validator = Validator::make($allInputs, DealsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (DealsModel::updateRow($id, $allInputs)) {
                return Redirect::to('deals')->with('message_success', Language::getMessage('messages.SuccessDealsUpdate'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorDealsUpdate'));
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
        $dataOfDeals = DealsModel::find($id);
        $dataOfDeals->delete();

        $this->systemLogs->insertSystemLogs('DealsModel has been deleted with id: ' .$dataOfDeals->id, 200);

        return Redirect::to('deals')->with('message_success', Language::getMessage('messages.SuccessDealsDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfDeals = DealsModel::find($id);

        if (DealsModel::setActive($dataOfDeals->id, $value)) {
            $this->systemLogs->insertSystemLogs('DealsModel has been enabled with id: ' .$dataOfDeals->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorDealsActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findDealsByValue = count(DealsModel::trySearchDealsByValue('name', $getValueInput, 10));
        $dataOfDeals = $this->getDataAndPagination();

        if (!$findDealsByValue > 0) {
            return redirect('deals')->with('message_danger', Language::getMessage('messages.ThereIsNoDeals'));
        } else {
            $dataOfDeals += ['deals_search' => $findDealsByValue];
            Redirect::to('deals/search')->with('message_success', 'Find ' . $findDealsByValue . ' deals!');
        }

        return View::make('crm.deals.index')->with($dataOfDeals);
    }
}
