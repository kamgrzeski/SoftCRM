<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeesStoreRequest;
use App\Http\Requests\EmployeesUpdateRequest;
use App\Services\EmployeesService;
use Illuminate\Http\Request;
use Illuminate\Http\{JsonResponse};

class EmployeesController extends Controller
{
    private $employeesService;

    public function __construct()
    {
        parent::__construct();

        $this->employeesService = new EmployeesService();
    }

    public function processListOfEmployees() : JsonResponse
    {
        if ($employeesList = $this->employeesService->loadEmployeesList()) {
            return $this->jsonResponse('Employees list.', $employeesList, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collection employee list.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processCreateEmployee(EmployeesStoreRequest $request) : JsonResponse
    {
        $validatedData = $this->convertToObject($request->validated());

        if ($employeeId = $this->employeesService->execute($validatedData)) {
            $this->insertSystemLogs('Employee has been stored. Employee ID: ' . $employeeId, $this->successCode);
            return $this->jsonResponse('You have successfully stored employee!', [], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while storing employee.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processEmployeeDetails(Request $request) : JsonResponse
    {
        if ($employeeDetails = $this->employeesService->loadEmployeeDetails($request->route('employeeId'))) {
            return $this->jsonResponse('Employee details', $employeeDetails, $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting employee data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processDeleteEmployee(Request $request) : JsonResponse
    {
        $employeeId = $request->route('employ   eeId');

        if ($this->employeesService->loadEmployeeDelete($employeeId)) {
            return $this->jsonResponse('Employee has been deleted.', ['employeeId' => $employeeId], $this->successCode, $this->startTime);
        } else {
            return $this->jsonResponse('Something went wrong while collecting employee data.', [], $this->unauthorized, $this->startTime);
        }
    }

    public function processUpdateEmployee(EmployeesUpdateRequest $request) : JsonResponse
    {
        $groupId = (int) $request->route('employeeId');
        $validated = $this->convertToObject($request->validated());

        if($groupDetails = $this->employeesService->update($validated, $groupId)) {
            return $this->jsonResponse('You have been updated employee!', $groupDetails, $this->successCreatedCode, $this->startTime);
        } else {
            return $this->jsonResponse('There is no employee with given employeeId.', [], $this->notFound, $this->startTime);
        }
    }

    public function processSetIsActive(Request $request) : JsonResponse
    {
        $employeeId = (int) $request->get('employeeId');
        $value = $request->get('type');

        if($groupDetails = $this->employeesService->setIsActive($employeeId, $value)) {
            if($value == 1) {
                return $this->jsonResponse('You have been deactive employee!', $groupDetails, $this->successCreatedCode, $this->startTime);
            } else {
                return $this->jsonResponse('You have been active employee!', $groupDetails, $this->successCreatedCode, $this->startTime);
            }
        } else {
            return $this->jsonResponse('There is no user with given employeeId.', [], $this->notFound, $this->startTime);
        }
    }
}
