<?php

namespace App\Http\Requests\Idea;

use Illuminate\Foundation\Http\FormRequest;

class StoreUploadFileRequest extends FormRequest
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
        $mimes = str_replace(' ','', join(',',config('app.file_type')).', '.join(',',config('app.image_type')));
        return [
            'idea_id' => 'required',
            'file' => 'required|max:10000|mimes:'.$mimes, //a required, max 10000kb, allow file type of config/app.php
        ];
    }
}
