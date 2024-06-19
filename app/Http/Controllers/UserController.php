<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UpdateUserRequest;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $users = User::get();
    return $users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        //
        $input = $request->validated();

        return User::create($input);

    }
    /**
     * Display the specified resource.
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $user_id)
    {
        $user = User::find($user_id);

        $input = $request->validated();

        $user->name = $input['name'];
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id)
    {
        $user = User::find($user_id);

        $user->delete();
    
    }
}
