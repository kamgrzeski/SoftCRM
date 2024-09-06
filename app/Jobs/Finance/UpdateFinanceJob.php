<?php

namespace App\Jobs\Finance;

use App\Models\FinancesModel;
use App\Services\FinancesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFinanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $validatedData;
    private FinancesModel $finance;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, FinancesModel $finance)
    {
        $this->validatedData = $validatedData;
        $this->finance = $finance;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if(isset($this->validatedData['gross'])) {
            $financesHelper = new FinancesService();
            $dataToInsert = $financesHelper->loadCalculateNetAndVatByGivenGross($this->validatedData['gross']);

            $this->validatedData['net'] = $dataToInsert['net'];
            $this->validatedData['vat'] = $dataToInsert['vat'];
        }

        $this->finance->update($this->validatedData);
    }
}
