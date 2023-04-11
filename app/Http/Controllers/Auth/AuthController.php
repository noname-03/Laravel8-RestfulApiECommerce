<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $fileName = '';
        if ($request->hasFile('avatar')) {
            $fileName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/images/user', $fileName);
        }
        User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'avatar' => $fileName
        ]);

        return response()->json([
            'code' => '200',
            'message' => 'Registrasi Sukses',
        ], 200);
    }
    public function user()
    {
        $users = User::all();
        $users->map(function ($obj) {
            if ($obj->avatar) {
                $obj['avatar'] = asset('storage/images/user/' . $obj->avatar);
                return $obj;
            } else {
                $obj['avatar'] = null;
                return $obj;
            }
        });
        return response()->json([
            'code' => '200',
            'data' => $users,
        ], 200);
    }
}