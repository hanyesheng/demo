<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminUser;
use App\AssumedName;

class RegisterController extends Controller
{
    // 注册页面
    public function index()
    {
        return view('register.index');
    }

    // 注册行为
    public function register()
    {
        // 验证
        $this->validate(request(), [
            'username' => '',
            'name' => 'required|min:3',
            'email' => 'required|unique:admin_users,email|email',
            'password' => 'required|min:5|max:20|confirmed',
        ]);


        // 逻辑
        $names = AssumedName::inRandomOrder()->first();
//        逻辑
        $ssumedname = $names->name;
        $assumed_name = $ssumedname;
        $dice_id = 2;
        $username = request('email');
        $name = request('name');
        $email = request('email');
        $password = bcrypt(request('password'));

        $admin_users = AdminUser::create(compact('username','name', 'email', 'password','assumed_name','dice_id'));

        // 渲染
        return redirect('/login');
    }
}
