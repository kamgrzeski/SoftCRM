<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use App\Http\Controllers\Controller;
use View;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CompaniesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $companies = Companies::all();

        return View::make('crm.companies.index')->with('companies', $companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('crm.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies/create')->with('message_danger', $validator->errors());
        } else {
            if(Companies::insertRow($allInputs)) {
                return Redirect::to('companies')->with('message_success', 'Successfully created the companies!!');
            } else {
                return Redirect::to('companies')->with('message_success', 'Error with create the companies!!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $companies = Companies::find($id);

        return View::make('crm.companies.show')
            ->with('companies', $companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $companies = Companies::find($id);

        return View::make('crm.companies.edit')
            ->with('companies', $companies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies')->with('message_danger', $validator);
        } else {
            if(Companies::updateRow($id, $allInputs)) {
                return Redirect::to('companies')->with('message_success', 'Successfully updated the companies!!');
            } else {
                return Redirect::to('companies')->with('message_success', 'Error with update the companies!!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $companies = Companies::find($id);
        $companies->delete();

        return Redirect::to('companies')->with('message_success', 'Successfully deleted the companies!!');
    }

    public function enable($id) {
        $companies = Companies::find($id);

        if(Companies::setActive($companies->id, TRUE)) {
            return Redirect::back()->with('message_success', 'Successfully enable the companies!!');
        } else {
            return Redirect::back()->with('message_danger', 'Companies already enabled.');
        }
    }

    public function disable($id) {
        $companies = Companies::find($id);

        if(Companies::setActive($companies->id, FALSE)) {
            return Redirect::back()->with('message_success', 'Successfully disable the companies!!');
        } else {
            return Redirect::back()->with('message_danger', 'Companies already disabled.');
        }
    }
}
