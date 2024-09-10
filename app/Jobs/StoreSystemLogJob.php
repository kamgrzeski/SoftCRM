<?php

namespace App\Jobs;

use App\Models\AdminModel;
use App\Models\SystemLogsModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreSystemLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $actions;
    private int $statusCode;
    private Authenticatable $authUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $actions, int $statusCode, Authenticatable $authUser)
    {
        $this->actions = $actions;
        $this->statusCode = $statusCode;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $userInformation = $this->authUser->getUserInformation();

        $model = new SystemLogsModel();

        $model->admin_id = $this->authUser->id;
        $model->actions = $this->actions;
        $model->status_code = $this->statusCode;
        $model->date = now();
        $model->ip_address = $userInformation['geoplugin_request'];
        $model->city = $userInformation['geoplugin_city'];
        $model->country = $userInformation['geoplugin_countryName'];

        $model->save();
    }
}
