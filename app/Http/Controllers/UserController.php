<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::find($id);

        return new UserResource($user);
    }

    public function store(UserCreateRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make(1234),
            'role_id' => $request->input('role_id')
        ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        User::destroy($id);
    
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user()
    {
        return Auth::user();
    }

    public function updateInfo(UserUpdateRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
