<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaskStoreRequest extends Request
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
            'task'=>'required|max:100',
            'description'=>'max:150',
            'start_day'=>'required',
            'performance_day'=>'required',
            'area_id'=>'required',
            'user_id'=>'required'
        ];
    }
}
