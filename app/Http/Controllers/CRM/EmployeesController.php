<?php

namespace App\Http\Controllers\CRM;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Jobs\Employee\StoreEmployeeJob;
use App\Jobs\Employee\UpdateEmployeeJob;
use App\Jobs\StoreSystemLogJob;
use App\Models\EmployeesModel;
use App\Queries\ClientsQueries;
use App\Queries\EmployeesQueries;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EmployeesController
 *
 * Controller for handling employee-related operations in the CRM.
 */
class EmployeesController extends Controller
{
    use DispatchesJobs;

    public function __construct()
    {
        $this->middleware(self::MIDDLEWARE_AUTH);
    }

    /**
     * Render the form for creating a new employee record.
     *
     * @return \Illuminate\View\View
     */
    public function processRenderCreateForm(): \Illuminate\View\View
    {
        // Load the clients data to be used in the form.
        return view('crm.employees.create')->with(['clients' => ClientsQueries::getAll()]);
    }

    /**
     * Show the details of a specific employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\View\View
     */
    public function processShowEmployeeDetails(EmployeesModel $employee): \Illuminate\View\View
    {
        // Load the employee record details.
        return view('crm.employees.show')->with(['employee' => $employee]);
    }

    /**
     * List all employee records with pagination.
     *
     * @return \Illuminate\View\View
     */
    public function processListOfEmployees(): \Illuminate\View\View
    {
        // Load the employee records and render the list page.
        return view('crm.employees.index')->with([
            'employees' => EmployeesQueries::getPaginate()
        ]);
    }

    /**
     * Render the form for updating an existing employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\View\View
     */
    public function processRenderUpdateForm(EmployeesModel $employee): \Illuminate\View\View
    {
        // Load the employee record details and the clients data to be used in the form.
        return view('crm.employees.edit')->with([
            'employee' => $employee,
            'clients' => ClientsQueries::getAll()
        ]);
    }

    /**
     * Store a new employee record.
     *
     * @param EmployeeStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processStoreEmployee(EmployeeStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to store the employee record.
        $this->dispatchSync(new StoreEmployeeJob($request->validated(), auth()->user()));

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('Employees has been added.', 201, auth()->user()));

        // Redirect to the employees page with a success message.
        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_store'));
    }

    /**
     * Update an existing employee record.
     *
     * @param EmployeeUpdateRequest $request
     * @param EmployeesModel $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processUpdateEmployee(EmployeeUpdateRequest $request, EmployeesModel $employee): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to update the employee record.
        $this->dispatchSync(new UpdateEmployeeJob($request->validated(), $employee));

        // Dispatch the job to store the system log.
        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }

    /**
     * Delete an employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processDeleteEmployee(EmployeesModel $employee): \Illuminate\Http\RedirectResponse
    {
        // Check if the employee has any tasks assigned.
        if ($employee->tasks()->count() > 0) {
            return redirect()->back()->with('message_error', $this->getMessage('messages.task_delete_tasks'));
        }

        // Dispatch the job to delete the employee record.
        $employee->delete();

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('Employees has been deleted with id: ' . $employee->id, 201, auth()->user()));

        // Redirect to the employees page with a success message.
        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_delete'));
    }

    /**
     * Set the active status of an employee record.
     *
     * @param EmployeesModel $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function processEmployeeSetIsActive(EmployeesModel $employee): \Illuminate\Http\RedirectResponse
    {
        // Dispatch the job to update the employee record.
        $this->dispatchSync(new UpdateEmployeeJob(['is_active' => ! $employee->is_active], $employee));

        // Dispatch the job to store the system log.
        $this->dispatchSync(new StoreSystemLogJob('Employees has been enabled with id: ' . $employee->id, 201, auth()->user()));

        // Redirect to the employees page with a success message.
        return redirect()->to('employees')->with('message_success', $this->getMessage('messages.employee_update'));
    }
}
