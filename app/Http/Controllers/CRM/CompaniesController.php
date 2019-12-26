<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesStoreRequest;
use View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function processListOfCompanies()
    {
        $collectDataForView = array_merge($this->collectedData(), $this->companiesService->loadDataAndPagination());

        return View::make('crm.companies.index')->with($collectDataForView);
    }

    public function showCreateForm()
    {
        $collectDataForView = array_merge($this->collectedData(), ['dataWithPluckOfClient' => $this->companiesService->pluckData()]);

        return View::make('crm.companies.create')->with($collectDataForView);
    }

    public function viewCompaniesDetails(int $companiesId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['companies' => $this->companiesService->loadCompanie($companiesId)]);

        return View::make('crm.companies.show')->with($collectDataForView);
    }

    public function showUpdateForm(int $companiesId)
    {
        $collectDataForView = array_merge($this->collectedData(), ['companies' => $this->companiesService->loadCompanie($companiesId)],
            ['clients' => $this->companiesService->pluckData()]);

        return View::make('crm.companies.edit')->with($collectDataForView);
    }

    public function processCreateCompanies(CompaniesStoreRequest $request)
    {
        if ($companie = $this->companiesService->execute($request->validated())) {
            $this->systemLogsService->insertSystemLogs('CompaniesModel has been add with id: '. $companie, $this->systemLogsService::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesStore'));
        }
    }

    public function processUpdateCompanies(Request $request, int $companiesId)
    {
        if ($this->companiesService->update($companiesId, $request->all())) {
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesUpdate'));
        } else {
            return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorCompaniesUpdate'));
        }
    }

    public function processDeleteCompanies(int $companiesId)
    {
        $dataOfCompanies = $this->companiesService->loadCompanie($companiesId);

        $countDeals = $this->companiesService->countAssignedDeals($dataOfCompanies);

        if ($countDeals > 0) {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.firstDeleteDeals'));
        }

        $dataOfCompanies->delete();

        $this->systemLogsService->insertSystemLogs('CompaniesModel has been deleted with id: ' . $dataOfCompanies->id, $this->systemLogsService::successCode);

        return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesDelete'));
    }

    public function processSetIsActive(int $companiesId, bool $value)
    {
        if ($this->companiesService->loadSetActive($companiesId, $value)) {
            $this->systemLogsService->insertSystemLogs('CompaniesModel has been enabled with id: ' . $companiesId, $this->systemLogsService::successCode);
            return Redirect::to('companies')->with('message_success', $this->getMessage('messages.SuccessCompaniesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorCompaniesActive'));
        }
    }
}
