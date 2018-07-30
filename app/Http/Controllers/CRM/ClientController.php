<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\Language;
use App\Services\ClientService;
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

    private $language;

    private $clientService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();

        $this->clientsModel = new ClientsModel();

        $this->language = new Language();

        $this->clientService = new ClientService();
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
        return View::make('crm.client.create')->with([
            'inputText' => $this->language->getMessage('messages.InputText')
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

        $validator = Validator::make($allInputs, $this->clientsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('client/create')->with('message_danger', $validator->errors());
        } else {
            if ($client = $this->clientsModel->insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('ClientsModel has been add with id: ' . $client, 200);
                return Redirect::to('client')->with('message_success', $this->language->getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_success', $this->language->getMessage('messages.ErrorClientStore'));
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
            ->with([
                'client', $this->clientsModel->findClientByGivenClientId($id),
                 'inputText' => $this->language->getMessage('messages.InputText')
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

        $validator = Validator::make($allInputs, $this->clientsModel->getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->clientsModel->updateRow($id, $allInputs)) {
                return Redirect::to('client')->with('message_success', $this->language->getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->language->getMessage('messages.ErrorClientStore'));
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
        $checkForeign = $this->clientService->checkIfClientHaveForeignKey($id);

        if(!empty($checkForeign)) {
            return Redirect::back()->with('message_danger', $checkForeign);
        } else {
            $this->clientService->processDeleteRow($id);
        }

        return Redirect::to('client')->with('message_success', $this->language->getMessage('messages.SuccessClientDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $status = $this->clientService->processIsActive($id, $value);

        if(!empty($status)) {
            return $this->language->getMessage('messages.SuccessClientActive');
        } else {
            return $this->language->getMessage('messages.ClientIsActived');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findClientByValue = count($this->clientsModel->trySearchClientByValue('full_name', $getValueInput, 10));
        $dataOfClient = $this->getDataAndPagination();

        if (!$findClientByValue > 0) {
            return redirect('client')->with('message_danger', $this->language->getMessage('messages.ThereIsNoClient'));
        } else {
            $dataOfClient += ['client_search' => $findClientByValue];
            Redirect::to('client/search')->with('message_success', 'Find ' . $findClientByValue . ' client!');
        }

        return View::make('crm.client.index')->with($dataOfClient);
    }
}
