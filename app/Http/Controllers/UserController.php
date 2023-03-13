<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function edit()
    {
        return view('user.edit', ['user' => Auth::user() ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatar = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/images', $avatar);
            $user->avatar = $avatar;
        }

        $user->save();

        // flashメッセージつけてリダイレクト
        return redirect('/tasks')->with('flash_message', 'ユーザー情報を更新しました');
    }
}
