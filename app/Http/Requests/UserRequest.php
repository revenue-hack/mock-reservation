<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $service = \App::make('\App\Services\UserService');
        if ($service->getUserById(\Auth::user()->id)->user_flag == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $actionName = getActionName();
        switch ($actionName) {
        case "update":
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'role_id' => 'required|integer|exists:roles,id',
                //'type_id' => 'required|integer|exists:user_types,id',
                'password' => 'required|min:6',
            ];
            break;
        default:
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'role_id' => 'required|integer|exists:roles,id',
                'type_id' => 'required|integer|exists:user_types,id',
                'password' => 'required|min:6|confirmed',
            ];
            break;
        }
        return $rules;
    }

    /**
     * attributes
     *
     * @return array
     */
    public function attributes() {
        return [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
            'type_id' => 'ユーザタイプ',
            'role_id' => 'ロール',
            'password' => 'パスワード',
        ];
    }
}
