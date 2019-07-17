<?php

namespace App\Http\Controllers;

use App\Models\SystemLogsModel;
use App\Traits\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Response;

    protected $startTime;
    private $administratorService;
    private $systemLogsModel;

    public function __construct()
    {
        $this->systemLogsModel = new SystemLogsModel();
        $this->startTime = microtime(true);
    }

    public function errorAuthorize()
    {
        return $this->jsonResponse('Unauthenticated action.', [], $this->unauthorized, $this->startTime);
    }

    public function getAdminRole()
    {
        return Auth::guard('admin')->user()->role_id;
    }

    public function getAdminId()
    {
//        return Auth::guard('admin')->id();
        return 1;
    }

    public function convertToObject(array $array)
    {
        return (object) $array;
    }

    public function insertSystemLogs($actions, $statusCode)
    {
        return $this->systemLogsModel->storeSystemLogs($actions, $statusCode);
    }
}
