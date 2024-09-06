<?php

namespace App\Jobs\Employee;

use App\Models\EmployeesModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateEmployeeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private array $validatedData;
    private EmployeesModel $employee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, EmployeesModel $employee)
    {
        $this->validatedData = $validatedData;
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->employee->update($this->validatedData);
    }
}
