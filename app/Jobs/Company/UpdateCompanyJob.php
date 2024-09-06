<?php

namespace App\Jobs\Company;

use App\Models\CompaniesModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCompanyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $validatedData;
    private CompaniesModel $company;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, CompaniesModel $company)
    {
        $this->validatedData = $validatedData;
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->company->update($this->validatedData);
    }
}
