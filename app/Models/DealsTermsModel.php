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
        $model = new DealsTermsModel();

        $model->body = $validatedData['body'];
        $model->deal_id = $validatedData['dealId'];

        return $model->save();
    }

    public function getDealTerms(int $dealId)
    {
        $query = $this->where('deal_id', $dealId)->get();

        foreach($query as $key => $value) {
            $query[$key]['formattedDate'] = $this->generateDate($value['created_at']);
        }

        return $query;
    }

    public function generateDate($date)
    {
        $formatted = Carbon::parse($date);

        return $formatted->format('d M, Y');
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
