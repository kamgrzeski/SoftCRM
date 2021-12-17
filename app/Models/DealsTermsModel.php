<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealsTermsModel extends Model
{
    use SoftDeletes;

    protected $table = 'deals_terms';
    protected $dates = ['deleted_at'];

    public function storeDealTerms(array $validatedData)
    {
        return $this->insertGetId(
            [
                'body' => $validatedData['body'],
                'deal_id' => $validatedData['dealId'],
            ]
        );
    }

    public function getDealTerms(int $dealId)
    {
        return $this->where('deal_id', $dealId)->get();
    }

    public function getTermsBody(int $termId) : string
    {
        return $this->where('id', $termId)->get()->last()->body;
    }

    public function deleteTerm(int $termId) : bool
    {
        return $this->find($termId)->delete();
    }

    public function countAssignedDealTerms(int $dealId)
    {
        return $this->where('deal_id', $dealId)->count();
    }
}
