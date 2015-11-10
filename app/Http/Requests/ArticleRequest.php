<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Entities\Article;

class ArticleRequest extends Request
{
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
        $statuses = implode(',', Article::$statuses);

        return [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'numeric',
            'status' => "required|in:{$statuses}",
            'published_at' => 'required|date',
        ];
    }

    public function attributes()
    {
        return trans('attributes.article');
    }
}
