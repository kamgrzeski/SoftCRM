<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use App\Deals;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
Use Illuminate\Support\Facades\Redirect;

class DealsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'deals' => Deals::all(),
            'dealsPaginate' => Deals::paginate(10)
        ];
        return View::make('crm.deals.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $deals = Companies::pluck('name', 'id');
        return View::make('crm.deals.create', compact('deals'));
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
                return Redirect::to('deals')->with('message_success', 'Z powodzeniem dodano umowę!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas dodawania umowę!');
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
        $clients = Deals::find($id);

        return View::make('crm.deals.show')
            ->with('deals', $clients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $clients = Deals::find($id);

        return View::make('crm.deals.edit')
            ->with('deals', $clients);
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
                return Redirect::back()->with('message_success', 'Z powodzeniem zaktualizowano umowę!');
            } else {
                return Redirect::back()->with('message_success', 'Błąd podczas aktualizowania umowy!');
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
        $clients = Deals::find($id);
        $clients->delete();

        return Redirect::back()->with('message_success', 'Umowa została pomyślnie usunięta.');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $clients = Deals::find($id);

        if (Deals::setActive($clients->id, TRUE)) {
            return Redirect::back()->with('message_success', 'Umowa od teraz jest aktywna.');
        } else {
            return Redirect::back()->with('message_danger', 'Umowa jest już aktywna.');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $clients = Deals::find($id);

        if (Deals::setActive($clients->id, FALSE)) {
            return Redirect::back()->with('message_success', 'Umowa został deaktywowana.');
        } else {
            return Redirect::back()->with('message_danger', 'Umowa jest juz nieaktywna.');
        }
    }
}
