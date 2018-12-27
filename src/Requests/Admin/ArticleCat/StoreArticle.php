<?php
namespace XRA\Blog\Requests\Admin\ArticleCat;

use Illuminate\Foundation\Http\FormRequest;
use XRA\XRA\Traits\FormRequestTrait;

class StoreArticle extends FormRequest
{
    use FormRequestTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
