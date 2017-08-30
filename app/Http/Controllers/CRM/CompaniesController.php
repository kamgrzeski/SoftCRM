<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use App\Http\Controllers\Controller;
use App\Language;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Client;

class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataOfCompanies = [
            'companies' => Companies::all(),
            'companiesPaginate' => Companies::paginate(10)
        ];
        return View::make('crm.companies.index')->with($dataOfCompanies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataWithPluckOfClient = Client::pluck('full_name', 'id');
        return View::make('crm.companies.create', compact('dataWithPluckOfClient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies/create')->with('message_danger', $validator->errors());
        } else {
            if (Companies::insertRow($allInputs)) {
                return Redirect::to('companies')->with('message_success', Language::getMessage('messages.SuccessCompaniesStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorCompaniesStore'));
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
        $dataOfCompanies = Companies::find($id);

        return View::make('crm.companies.show')
            ->with([
                'companies' => $dataOfCompanies
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
        $dataOfCompanies = Companies::find($id);
        $dataWithPluckOfClients = Client::pluck('full_name', 'id');

        return View::make('crm.companies.edit')
            ->with([
                'companies' => $dataOfCompanies,
                'clients' => $dataWithPluckOfClients
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

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator->errors());
        } else {
            if (Companies::updateRow($id, $allInputs)) {
                return Redirect::to('companies')->with('message_success', Language::getMessage('messages.SuccessCompaniesUpdate'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorCompaniesUpdate'));
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
        $dataOfCompanies = Companies::find($id);
        $dataOfCompanies->delete();

        return Redirect::to('companies')->with('message_success', Language::getMessage('messages.SuccessCompaniesDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $dataOfCompanies = Companies::find($id);

        if (Companies::setActive($dataOfCompanies->id, TRUE)) {
            return Redirect::to('companies')->with('message_success', Language::getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorCompaniesActive'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $dataOfCompanies = Companies::find($id);

        if (Companies::setActive($dataOfCompanies->id, FALSE)) {
            return Redirect::to('companies')->with('message_success', Language::getMessage('messages.CompaniesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.CompaniesIsDeactivated'));
        }
    }
}
