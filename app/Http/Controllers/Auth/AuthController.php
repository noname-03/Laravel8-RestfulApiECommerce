<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

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

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'code' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}