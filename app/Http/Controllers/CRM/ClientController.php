<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\Language;
use App\Services\SystemLogService;
use View;
use Illuminate\Support\Facades\Input;
use Validator;
use Request;
use Illuminate\Support\Facades\Redirect;
use Config;

class ClientController extends Controller
{
    private $clientsModel;
    private $systemLogs;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->clientsModel = new ClientsModel();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithClients = [
            'client' => $this->clientsModel->getClientSortedBy('created_at'),
            'clientPaginate' => ClientsModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithClients;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.client.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, ClientsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('client/create')->with('message_danger', $validator->errors());
        } else {
            if ($client = $this->clientsModel->insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('ClientsModel has been add with id: '. $client, 200);
                return Redirect::to('client')->with('message_success', Language::getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorClientStore'));
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
        return View::make('crm.client.show')
            ->with([
                'clients' => $this->clientsModel->findClientByGivenClientId($id),
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
        return View::make('crm.client.edit')
            ->with('client', $this->clientsModel->findClientByGivenClientId($id));
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

        $validator = Validator::make($allInputs, ClientsModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->clientsModel->updateRow($id, $allInputs)) {
                return Redirect::to('client')->with('message_success', Language::getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorClientStore'));
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
        $clientDetails = $this->clientsModel->findClientByGivenClientId($id);
        $countCompanies = $clientDetails->companies()->count();
        $countEmployees = $clientDetails->employees()->count();

        if ($countCompanies > 0) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.firstDeleteCompanies'));
        }
        if ($countEmployees > 0) {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.firstDeleteEmployees'));
        }

        $clientDetails->delete();
        $this->systemLogs->insertSystemLogs('ClientsModel has been deleted with id: ' . $clientDetails->id, 200);

        return Redirect::to('client')->with('message_success', Language::getMessage('messages.SuccessClientDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $clientDetails = $this->clientsModel->findClientByGivenClientId($id);

        if ($this->clientsModel->setActive($clientDetails->id, $value)) {
            $this->systemLogs->insertSystemLogs('ClientsModel has been enabled with id: ' . $clientDetails->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessClientActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ClientIsActived'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findClientByValue = count(ClientsModel::trySearchClientByValue('full_name', $getValueInput, 10));
        $dataOfClient = $this->getDataAndPagination();

        if (!$findClientByValue > 0) {
            return redirect('client')->with('message_danger', Language::getMessage('messages.ThereIsNoClient'));
        } else {
            $dataOfClient += ['client_search' => $findClientByValue];
            Redirect::to('client/search')->with('message_success', 'Find ' . $findClientByValue . ' client!');
        }

        return View::make('crm.client.index')->with($dataOfClient);
    }
}
