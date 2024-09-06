<?php

namespace App\Jobs;

use App\Models\AdminModel;
use App\Models\SystemLogsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreSystemLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $actions;
    private int $statusCode;
    private AdminModel $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $actions, int $statusCode, AdminModel $admin)
    {
        $this->actions = $actions;
        $this->statusCode = $statusCode;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $userInformation = $this->admin->getUserInformation();

        $model = new SystemLogsModel();

        $model->admin_id = $this->admin->id;
        $model->actions = $this->actions;
        $model->status_code = $this->statusCode;
        $model->date = now();
        $model->ip_address = $userInformation['geoplugin_request'];
        $model->city = $userInformation['geoplugin_city'];
        $model->country = $userInformation['geoplugin_countryName'];

        $model->save();
    }
}
