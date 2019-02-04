<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);
        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }
        if (!hash_equals($verifyData['code'], $request->verification_code)){
            return $this->response->error('验证码错误', 401);
        }

        $user = User::insert([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->input('password')),
        ]);

        //清除验证码缓存
        \Cache::forget($request->varification_key);

        return $this->response->created();
    }
}
