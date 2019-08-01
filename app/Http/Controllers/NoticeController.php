<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class NoticeController extends Controller
{
    public function index()
    {
        // 获取当前用户

        $notifications = Auth::user()->notifications()->paginate(20);
        // 标记为已读，未读数量清零
        Auth::user()->markAsRead();
        return view('notice/index', compact('notifications'));
    }
}
