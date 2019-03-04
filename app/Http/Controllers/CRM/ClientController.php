<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Support\Facades\Input;
use Validator;
use Request;
use Illuminate\Support\Facades\Redirect;
use Config;

class ClientController extends Controller
{
    use Language;

    private $systemLogs;
    private $clientService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->clientService = new ClientService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.client.index')->with($this->clientService->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.client.create')->with([
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

        $validator = Validator::make($allInputs, $this->clientService->loadRules());

        if ($validator->fails()) {
            return Redirect::to('client/create')->with('message_danger', $validator->errors());
        } else {
            if ($client = $this->clientsModel->insertRow($allInputs)) {
                $this->systemLogs->insertSystemLogs('ClientsModel has been add with id: ' . $client, $this->systemLogs::successCode);
                return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_success', $this->getMessage('messages.ErrorClientStore'));
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
                'clients' => $this->clientService->findClient($id)
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
                'client', $this->clientService->findClient($id),
                'inputText' => $this->getMessage('messages.InputText')
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

        $validator = Validator::make($allInputs, $this->clientService->loadRules());

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->clientsModel->updateRow($id, $allInputs)) {
                return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorClientStore'));
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

        return Redirect::to('client')->with('message_success', $this->getMessage('messages.SuccessClientDelete'));
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
            return $this->getMessage('messages.SuccessClientActive');
        } else {
            return $this->getMessage('messages.ClientIsActived');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findClientByValue = $this->clientService->loadSearch($getValueInput);
        $dataOfClient = $this->clientService->getDataAndPagination();

        if (!$findClientByValue > 0) {
            return redirect('client')->with('message_danger', $this->getMessage('messages.ThereIsNoClient'));
        } else {
            $dataOfClient += ['client_search' => $findClientByValue];
            Redirect::to('client/search')->with('message_success', 'Find ' . $findClientByValue . ' client!');
        }

        return View::make('crm.client.index')->with($dataOfClient);
    }
}
