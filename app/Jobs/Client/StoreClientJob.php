<?php

namespace App\Jobs\Client;

use App\Models\Administrator;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreClientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $validatedData;
    private Administrator $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $validatedData, Administrator $admin)
    {
        $this->validatedData = $validatedData;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $model = new Client();

        foreach($this->validatedData as $key => $value) {
            $model->$key = $value;
        }

        $model->admin_id = $this->admin->id;

        $model->save();
    }
}
