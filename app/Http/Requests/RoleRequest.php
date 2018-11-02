<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
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
        return [
            'role_name' => 'required|max:40',
            'privilege_type' => 'required|integer',
            'user_flag' => 'required|integer',
        ];
    }

    /**
     * attributes
     *
     * @return array
     */
    public function attributes() {
        return [
            'role_name' => 'ロール名',
            'privilege_type' => '権限区分',
            'user_flag' => 'ユーザ管理権限',
        ];
    }
}
