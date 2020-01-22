<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Config;

class DealsTermsModel extends Model
{
    protected $table = 'deals_terms';

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

    public function getTermsBody(int $termId)
    {
        return $this->where('id', $termId)->get()->last()->body;
    }

    public function deleteTerm(int $termId)
    {
        return $this->find($termId)->delete();
    }
}
