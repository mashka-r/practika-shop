<?php

namespace App\Http\Requests\Products;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ForStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $a = Category::max('id');
        $b = (Category::min('id'));

        return [
            'name'           => 'required|unique:products',
            'category_id'    => 'required|integer|between:'.$b.','.$a,
            'code'           => 'required|unique:products',
            'price'          => 'required|integer',
            
        ];
    }
}
