<?php

namespace App\Http\Requests\Products;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ForUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $a = Category::max('id');
        $b = (Category::min('id')) + 1;

        return [
            'price'         => 'integer',
            'name'          => 'unique:products',
            'code'          => 'unique:products',
            'category_id'   => 'integer|between:'.$b.','.$a,
            'count_store'   => 'integer',
        ];
    }
}
