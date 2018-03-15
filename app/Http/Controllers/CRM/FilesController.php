<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\FilesModel;
use App\Models\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class FilesController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfFiles = [
            'files' => FilesModel::all()->sortByDesc('created_at'),
            'filesPaginate' => FilesModel::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataOfFiles;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.files.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfCompanies = CompaniesModel::pluck('name', 'id');
        return View::make('crm.files.create', compact('dataOfCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, FilesModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('files/create')->with('message_danger', $validator->errors());
        } else {
            if ($file = FilesModel::insertRow($allInputs)) {
                SystemLogsController::insertSystemLogs('File has been add with id: '. $file, 200);
                return Redirect::to('files')->with('message_success', Language::getMessage('messages.SuccessFilesStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorFilesStore'));
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
        $dataOfFiles = FilesModel::find($id);

        return View::make('crm.files.show')
            ->with('files', $dataOfFiles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataOfFiles = FilesModel::find($id);
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.files.edit')
            ->with([
                'files' => $dataOfFiles,
                'companies' => $dataWithPluckOfCompanies
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

        $validator = Validator::make($allInputs, FilesModel::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (FilesModel::updateRow($id, $allInputs)) {
                return Redirect::to('files')->with('message_success', Language::getMessage('messages.SuccessFilesUpdate'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorFilesUpdate'));
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
        $dataOfFiles = FilesModel::find($id);
        $dataOfFiles->delete();

        SystemLogsController::insertSystemLogs('FilesModel has been deleted with id: ' . $dataOfFiles->id, 200);

        return Redirect::to('files')->with('message_success', Language::getMessage('messages.SuccessFilesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfFiles = FilesModel::find($id);

        if (FilesModel::setActive($dataOfFiles->id, $value)) {
            SystemLogsController::insertSystemLogs('FilesModel has been enable with id: ' . $dataOfFiles->id, 200);
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessFilesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorFilesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findFilesByValue = count(FilesModel::trySearchFilesByValue('name', $getValueInput, 10));
        $dataOfFiles = $this->getDataAndPagination();

        if (!$findFilesByValue > 0) {
            return redirect('files')->with('message_danger', Language::getMessage('messages.ThereIsNoFiles'));
        } else {
            $dataOfFiles += ['files_search' => $findFilesByValue];
            Redirect::to('files/search')->with('message_success', 'Find ' . $findFilesByValue . ' files!');
        }

        return View::make('crm.files.index')->with($dataOfFiles);
    }
}
