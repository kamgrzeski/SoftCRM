<?php

namespace App\Models;

use App\Services\FinancesService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancesModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'companies_id',
        'gross',
        'net',
        'vat',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'finances';

    public function companies()
    {
        return $this->belongsTo(CompaniesModel::class);
    }

    public function countFinances(): int
    {
        return $this->get()->count();
    }

    public function getFinancesSortedByCreatedAt()
    {
        return $this->all()->sortByDesc('created_at');
    }

    public function getPaginate()
    {
        return $this->orderByDesc('id')->paginate(SettingsModel::where('key', 'pagination_size')->get()->last()->value);
    }
}
