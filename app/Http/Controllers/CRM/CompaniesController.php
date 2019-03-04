<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\Language;
use App\Services\CompaniesService;
use App\Services\SystemLogService;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Request;
use Config;

class CompaniesController extends Controller
{
    private $systemLogs;
    private $companiesService;
    private $language;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->companiesService = new CompaniesService();
        $this->language = new Language();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.companies.index')->with($this->companiesService->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.companies.create')->with([
            'dataWithPluckOfClient' => $this->companiesService->pluckData(),
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

        $validator = Validator::make($allInputs, $this->companiesService->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies/create')->with('message_danger', $validator->errors());
        } else {
            if ($companie = CompaniesModel::insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('CompaniesModel has been add with id: '. $companie, $this->systemLogs::successCode);
                return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesStore'));
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
        return View::make('crm.companies.show')
            ->with([
                'companies' => $this->companiesService->loadCompanie($id)
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
        return View::make('crm.companies.edit')
            ->with([
                'companies' => $this->companiesService->loadCompanie($id),
                'clients' => $this->companiesService->pluckData()
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

        $validator = Validator::make($allInputs, $this->companiesService->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator->errors());
        } else {
            if (CompaniesModel::updateRow($id, $allInputs)) {
                return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesUpdate'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorCompaniesUpdate'));
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
        $dataOfCompanies = $this->companiesService->loadCompanie($id);

        $countDeals = $this->companiesService->countAssignedDeals($dataOfCompanies);
        $countFiles = $this->companiesService->countAssignedFile($dataOfCompanies);
        $countInvoices = $this->companiesService->countAssignedInvoice($dataOfCompanies);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        if ($countFiles > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteFiles'));
        }

        if ($countInvoices > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteInvoices'));
        }

        $dataOfCompanies->delete();

        $this->systemLogs->insertSystemLogs('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogs::successCode);

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfCompanies = $this->companiesService->loadCompanie($id);

        if (CompaniesModel::setActive($dataOfCompanies->id, $value)) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been enabled with id: ' . $dataOfCompanies->id, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $dataOfCompanies = $this->companiesService->loadCompanie($id);

        if (CompaniesModel::setActive($dataOfCompanies->id, FALSE)) {
            $this->systemLogs->insertSystemLogs('CompaniesModel has been disabled with id: ' . $dataOfCompanies->id, $this->systemLogs::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.CompaniesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.CompaniesIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findCompaniesByValue = $this->companiesService->loadSearch($getValueInput);
        $dataOfCompanies = $this->companiesService->getDataAndPagination();

        if (!$findCompaniesByValue > 0) {
            return redirect('companies')->with('message_danger', $this->getMessage('messages.ThereIsNoCompanies'));
        } else {
            $dataOfCompanies += ['companies_search' => $findCompaniesByValue];
            Redirect::to('companies/search')->with('message_success', 'Find ' . $findCompaniesByValue . ' companies!');
        }

        return View::make('crm.companies.index')->with($dataOfCompanies);
    }
}
