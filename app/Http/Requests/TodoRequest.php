<?php

namespace App\Http\Requests;

use Illuminate\Routing\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TodoRequest extends FormRequest
{
    protected $validator;
    protected $validation_rules;

    protected $store = [
        'content' => 'required|string|max:20|min:1',
        'assigner' => 'string|max:25',
        'deadline' => 'date_format:Y-m-d|required',
    ];

    protected $update = [
        'content' => 'required|string|max:20|min:1',
        'assigner' => 'string|max:25',
        'deadline' => 'date_format:Y-m-d|required',
        'is_completed' => 'required',
        'is_deleted' => 'required',
    ];

    public function __construct(Route $route, $action_name = '')
    {
        if (!$action_name) {
            $action_name = explode('@', $route->getActionName())[1];
        }

        // 有指定屬於該 action_name 的 validation_rule 就自動指定
        if (property_exists($this, $action_name)) {
            $this->validation_rules = $this->{$action_name};
        }
    }
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
        return $this->validation_rules ?? [];
    }

    public function messages()
    {
        return [
            'required' => ' :attribute 不能為空',
            'string' => ' :attribute 須為字串',
            'integer' => ' :attribute 須為整數',
            'max' => ' :attribute 最大為 :max 字元',
            'min' => ' :attribute 不得低於 :min 字元',
            'unique' => ':attribute 資料須為單一',
            'deadline.date_format' => '日期格式須符合 Y-m-d',
        ];
    }
}
