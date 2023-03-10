<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        session()->flash('alert_message', 'ログインもしくはアカウント登録をしてください');
        return $request->expectsJson() ? null : route('login');

        if (!Auth::check()) { // 非ログインはログインページに飛ばす
            return redirect('/login');
        }
    }
}
