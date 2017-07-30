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
        $companies = Companies::all();

        return View::make('crm.companies.index')->with('companies', $companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('crm.companies.create');
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
            return Redirect::to('companies/index')
                ->withErrors($validator);
        } else {
            if(Companies::insertRow($allInputs)) {
                Session::flash('message', 'Successfully created companies!');
                return Redirect::to('companies');
            } else {
                Session::flash('message', 'Error with create companies!');
                return Redirect::to('companies/create');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
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
    public function edit($id)
    {
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
    public function update($id)
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Companies::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('companies/index')
                ->withErrors($validator);
        } else {
            if(Companies::updateRow($id, $allInputs)) {
                Session::flash('message', 'Successfully updated companies!');
                return Redirect::to('companies');
            } else {
                Session::flash('message', 'Error with update companies!');
                return Redirect::to('companies');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $companies = Companies::find($id);
        $companies->delete();

        Session::flash('message', 'Successfully deleted the companies!');
        return Redirect::to('companies');
    }
}
