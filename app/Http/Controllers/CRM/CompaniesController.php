<?php

namespace App\Http\Controllers\CRM;

use App\Companies;
use Illuminate\Http\Request;
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
        $rules = array(
            'name'       => 'required',
            'tags'       => 'required',
            'tax_number'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('companies/index')
                ->withErrors($validator);
        } else {
            // store
            $nerd = new Companies;
            $nerd->name       = Input::get('name');
            $nerd->tags      = Input::get('tags');
            $nerd->tax_number = Input::get('tax_number');
            $nerd->save();

            // redirect
            Session::flash('message', 'Successfully created companies!');
            return Redirect::to('companies');
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
        $rules = array(
            'name'       => 'required',
            'tax_number' => 'required',
            'tags' => 'required',

        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            Session::flash('message', 'Error!');
            return Redirect::to('companies/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            $companies = Companies::find($id);
            $companies->name       = Input::get('name');
            $companies->tax_number      = Input::get('tax_number');
            $companies->tags      = Input::get('tags');
            $companies->save();
            Session::flash('message', 'Successfully updated companies!');
            return Redirect::to('companies');
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
