<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{

    public function store(UserRequest $request)
    {
        $user = User::create($request->except(['password_confirmation']));
        
        if(is_null($user)){
            return response()->json([
                'type' => 'error',
                'message' => 'Fail to create a new user',
            ], 400);
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Success create a record',
            'data' => $user
        ], 201);
    }
}
