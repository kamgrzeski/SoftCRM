<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CompaniesModel;
use App\Models\FilesModel;
use App\Services\FilesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class FilesController extends Controller
{
    use Language;

    private $systemLogs;
    private $filesService;

    public function __construct()
    {
        $this->systemLogs = new SystemLogService();
        $this->filesService = new FilesService();
    }

    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataOfFiles = [
            'files' => $this->filesService->loadFiles(),
            'filesPaginate' => $this->filesService->loadPaginate()
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

        return View::make('crm.files.create')->with([
            'dataOfCompanies' => $dataOfCompanies,
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

        $validator = Validator::make($allInputs, $this->filesService->loadRules());

        if ($validator->fails()) {
            return Redirect::to('files/create')->with('message_danger', $validator->errors());
        } else {
            if ($file = $this->filesService->execute($allInputs)) {
                $this->systemLogs->insertSystemLogs('File has been add with id: '. $file, $this->systemLogs::successCode);
                return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesStore'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesStore'));
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
        return View::make('crm.files.show')
            ->with('files', $this->filesService->getFile($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $dataWithPluckOfCompanies = CompaniesModel::pluck('name', 'id');

        return View::make('crm.files.edit')
            ->with([
                'files' => $this->filesService->getFile($id),
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

        $validator = Validator::make($allInputs, $this->filesService->loadRules());

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if ($this->filesService->update($id, $allInputs)) {
                return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesUpdate'));
            } else {
                return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesUpdate'));
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
        $dataOfFiles = $this->filesService->getFile($id);
        $dataOfFiles->delete();

        $this->systemLogs->insertSystemLogs('FilesModel has been deleted with id: ' . $dataOfFiles->id, $this->systemLogs::successCode);

        return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesDelete'));
    }

    /**
     * @param $id
     * @param $value
     * @return mixed
     */
    public function isActiveFunction($id, $value)
    {
        $dataOfFiles = FilesModel::find($id);

        if ($this->filesService->loadIsActive($dataOfFiles->id, $value)) {
            $this->systemLogs->insertSystemLogs('FilesModel has been enable with id: ' . $dataOfFiles->id, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessFilesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesActive'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findFilesByValue = $this->filesService->loadSearch($getValueInput);
        $dataOfFiles = $this->getDataAndPagination();

        if (!$findFilesByValue > 0) {
            return redirect('files')->with('message_danger', $this->getMessage('messages.ThereIsNoFiles'));
        } else {
            $dataOfFiles += ['files_search' => $findFilesByValue];
            Redirect::to('files/search')->with('message_success', 'Find ' . $findFilesByValue . ' files!');
        }

        return View::make('crm.files.index')->with($dataOfFiles);
    }
}
