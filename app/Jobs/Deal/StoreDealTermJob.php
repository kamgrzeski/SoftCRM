<?php

namespace App\Jobs\Deal;

use App\Models\DealsModel;
use App\Models\DealsTermsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreDealTermJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $validatedData;
    private DealsModel $deal;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, DealsModel $deal)
    {
        $this->validatedData = $validatedData;
        $this->deal = $deal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $model = new DealsTermsModel();

        foreach ($this->validatedData as $key => $value) {
            $model->$key = $value;
        }


        $model->deal_id = $this->deal->id;

        $model->save();
    }
}
