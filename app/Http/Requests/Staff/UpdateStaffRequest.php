<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'photo' => ['nullable','max:1024'],
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:staffs,email,'.$this->route('staff')->id.',id', 'max:50'],
            'phone' => ['required', 'max:25'],
            'address' => ['required', 'max:255'],
            'department_id' => ['required'],
            'position_id' => ['required'],
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
            'department_id.required' => 'Please Select Department',
            'position_id.required' => 'Please Select Job Title',
        ];
    }

    public function validated()
    {
        if ($this->hasFile('photo')) {
            $base64Image =  "data:image/png;base64,".base64_encode(file_get_contents($this->file('photo')));
            return array_merge(parent::validated(), ['photo' => $base64Image]);
        }

        return parent::validated();
    }
}
