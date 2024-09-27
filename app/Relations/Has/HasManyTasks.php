<?php

namespace App\Relations\Has;

use App\Models\TasksModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyTasks
{

    public function tasks(): HasMany
    {
        return $this->hasMany(TasksModel::class, 'employee_id');
    }
}
