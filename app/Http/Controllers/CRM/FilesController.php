<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilesStoreRequest;
use App\Services\FilesService;
use App\Services\SystemLogService;
use App\Traits\Language;
use View;
use Illuminate\Http\Request;
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

    private function getDataAndPagination()
    {
        $dataOfFiles = [
            'files' => $this->filesService->loadFiles(),
            'filesPaginate' => $this->filesService->loadPaginate()
        ];

        return $dataOfFiles;
    }

    public function index()
    {
        return View::make('crm.files.index')->with($this->getDataAndPagination());
    }

    public function create()
    {
        return View::make('crm.files.create')->with([
            'dataOfCompanies' => $this->filesService->getPluckCompanies(),
            'inputText' => $this->getMessage('messages.InputText')
        ]);
    }

    public function show($fileId)
    {
        return View::make('crm.files.show')
            ->with('files', $this->filesService->getFile($fileId));
    }

    public function edit($fileId)
    {
        return View::make('crm.files.edit')
            ->with([
                'files' => $this->filesService->getFile($fileId),
                'companies' => $this->filesService->getPluckCompanies()
            ]);
    }

    public function store(FilesStoreRequest $request)
    {
        if ($file = $this->filesService->execute($request->validated())) {
            $this->systemLogs->insertSystemLogs('File has been add with id: '. $file, $this->systemLogs::successCode);
            return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesStore'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesStore'));
        }
    }

    public function update(Request $request, int $fileId)
    {
        if ($this->filesService->update($fileId, $request->all())) {
            return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesUpdate'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesUpdate'));
        }
    }

    public function destroy($fileId)
    {
        $dataOfFiles = $this->filesService->getFile($fileId);
        $dataOfFiles->delete();

        $this->systemLogs->insertSystemLogs('FilesModel has been deleted with id: ' . $dataOfFiles->id, $this->systemLogs::successCode);

        return Redirect::to('files')->with('message_success', $this->getMessage('messages.SuccessFilesDelete'));
    }

    public function isActiveFunction($fileId, $value)
    {
        if ($this->filesService->loadIsActive($fileId, $value)) {
            $this->systemLogs->insertSystemLogs('FilesModel has been enable with id: ' . $fileId, $this->systemLogs::successCode);
            return Redirect::back()->with('message_success', $this->getMessage('messages.SuccessFilesActive'));
        } else {
            return Redirect::back()->with('message_danger', $this->getMessage('messages.ErrorFilesActive'));
        }
    }

    public function search()
    {
        return true; // TODO
    }
}
