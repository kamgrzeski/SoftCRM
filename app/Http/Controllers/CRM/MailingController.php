<?php

namespace App\Http\Controllers\CRM;

use App\Mailing;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class MailingController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithMailing = [
            'mailing' => Mailing::all(),
            'mailingPaginate' => Mailing::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithMailing;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.mailing.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.mailing.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Mailing::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('mailing/create')->with('message_danger', $validator->errors());
        } else {
            if (Mailing::insertRow($allInputs)) {
                return Redirect::to('mailing')->with('message_success', Language::getMessage('messages.SuccessMailingStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorMailingStore'));
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
        $dataOfMailing = Mailing::find($id);

        return View::make('crm.mailing.show')
            ->with([
                'mailing' => $dataOfMailing,
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
        $mailingDetails = Mailing::find($id);

        return View::make('crm.mailing.edit')
            ->with('mailing', $mailingDetails);
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

        $validator = Validator::make($allInputs, Mailing::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Mailing::updateRow($id, $allInputs)) {
                return Redirect::to('mailing')->with('message_success', Language::getMessage('messages.SuccessMailingStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorMailingStore'));
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
        $mailingDetails = Mailing::find($id);
        $mailingDetails->delete();

        return Redirect::to('mailing')->with('message_success', Language::getMessage('messages.SuccessMailingDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $mailingDetails = Mailing::find($id);

        if (Mailing::setActive($mailingDetails->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessMailingActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.MailingIsActived'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $mailingDetails = Mailing::find($id);

        if (Mailing::setActive($mailingDetails->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.MailingIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.MailingIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findMailingByValue = count(Mailing::trySearchMailingByValue('full_name', $getValueInput, 10));
        $dataOfMailing = $this->getDataAndPagination();

        if (!$findMailingByValue > 0) {
            return redirect('mailing')->with('message_danger', Language::getMessage('messages.ThereIsNoMailing'));
        } else {
            $dataOfMailing += ['mailing_search' => $findMailingByValue];
            Redirect::to('mailing/search')->with('message_success', 'Find ' . $findMailingByValue . ' mailing!');
        }

        return View::make('crm.mailing.index')->with($dataOfMailing);
    }
}
