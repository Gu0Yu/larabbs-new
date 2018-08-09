<?php

namespace App\Http\Controllers;

use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

use Illuminate\Auth\Access\AuthorizationException;

class UsersController extends Controller
{
    public  function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

//    个人页面展示接口
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        try{
            $this->authorize('update', $user);   //授权策略验证操作的用户为本用户
        } catch (AuthorizationException $e) {
            $result = $e->getMessage();
            return view('errors.403', compact('result'));
        }
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatar', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }
}
