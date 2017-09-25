<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use App\Deals;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class DealsController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfDeals = [
            'deals' => Deals::all(),
            'dealsPaginate' => Deals::paginate(Config::get('crm_settings.pagination_size'))
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
        $dataOfDeals = Companies::pluck('name', 'id');
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

        $validator = Validator::make($allInputs, Deals::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('deals/create')->with('message_danger', $validator->errors());
        } else {
            if (Deals::insertRow($allInputs)) {
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
        $dataOfDeals = Deals::find($id);

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
        $dataOfDeals = Deals::find($id);
        $dataWithPluckOfCompanies = Companies::pluck('name', 'id');

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

        $validator = Validator::make($allInputs, Deals::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Deals::updateRow($id, $allInputs)) {
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
     */
    public function destroy($id)
    {
        $dataOfDeals = Deals::find($id);
        $dataOfDeals->delete();

        return Redirect::to('deals')->with('message_success', Language::getMessage('messages.SuccessDealsDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $dataOfDeals = Deals::find($id);

        if (Deals::setActive($dataOfDeals->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessDealsActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorDealsActive'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $dataOfDeals = Deals::find($id);

        if (Deals::setActive($dataOfDeals->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.DealsIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.DealsIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findDealsByValue = count(Deals::trySearchDealsByValue('name', $getValueInput, 10));
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
