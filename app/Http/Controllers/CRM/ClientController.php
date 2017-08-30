<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Client;
use App\Language;
use View;
use Illuminate\Support\Facades\Input;
use Validator;
use Request;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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
        $dataWithClients = [
            'client' => Client::all(),
            'clientPaginate' => Client::paginate(10)
        ];

        return View::make('crm.client.index')->with($dataWithClients);
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

        $validator = Validator::make($allInputs, Client::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('client/create')->with('message_danger', $validator->errors());
        } else {
            if (Client::insertRow($allInputs)) {
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
        $dataOfClient = Client::find($id);

        return View::make('crm.client.show')
            ->with([
                'clients' => $dataOfClient,
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
        $clientDetails = Client::find($id);

        return View::make('crm.client.edit')
            ->with('client', $clientDetails);
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

        $validator = Validator::make($allInputs, Client::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Client::updateRow($id, $allInputs)) {
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
     */
    public function destroy($id)
    {
        $clientDetails = Client::find($id);
        $clientDetails->delete();

        return Redirect::to('client')->with('message_success', Language::getMessage('messages.SuccessClientDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $clientDetails = Client::find($id);

        if (Client::setActive($clientDetails->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessClientActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ClientIsActived'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $clientDetails = Client::find($id);

        if (Client::setActive($clientDetails->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.ClientIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ClientIsDeactivated'));
        }
    }



    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findClientByValue = Client::where('full_name', 'LIKE', '%' . $getValueInput . '%')->paginate(10);

        $dataOfClients = [
            'client' => Client::all(),
            'clientPaginate' => Client::paginate(10)
        ];

        if(!count($findClientByValue) > 0 ) {
            return redirect('clients')->with('message_danger', Language::getMessage('messages.ThereIsNoClient'));
        } else {
            $dataOfClients += ['clients_search' => $findClientByValue];
            Redirect::to('client/search')->with('message_success', 'Find '.count($findClientByValue).' clients!');
        }

        return View::make('crm.client.index')->with($dataOfClients);
    }
}
