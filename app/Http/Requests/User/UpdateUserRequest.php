<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
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
            'role_id' => ['required'],
            'active' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
           'role_id.required' => 'Please Select Role',
           'active.required' => 'Check Active Status',
        ];
    }

    public function validated(): array
    {
        if($this->input('active') == 'on')
        {
            return array_merge(parent::validated(), ['active' => 1]);
        }else{
            return array_merge(parent::validated(), ['active' => 0]);
        }

        return parent::validated();
    }
}
