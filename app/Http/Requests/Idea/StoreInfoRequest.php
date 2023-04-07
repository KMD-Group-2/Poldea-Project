<?php

namespace App\Http\Requests\Idea;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInfoRequest extends FormRequest
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
        return [
            'idea_id' => $this->input('idea_id') ? 'required' : 'nullable',
            'title' => 'required|max:100',
            'category_id' => 'required',
            'academic_year_id' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Please Select Category',
            'academic_year_id.required' => 'Please Select Academic Year',
        ];
    }

    public function validated()
    {
        return array_merge(parent::validated(),['user_id' => Auth::user()->id]);
    }
}
