<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|unique:users',
            'name' => 'required|unique:users',
            'role' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg|max:1024',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah ada',
            'name.required' => 'Nama wajib diisi',
            'name.unique' => 'Nama sudah ada',
            'role.required' => 'Role wajib diisi',
            'avatar.image' => 'Avatar harus berformat foto',
            'avatar.mimes' => 'Avatar hanya menggunakan jpeg,png dan jpg',
            'avatar.max' => 'Avatar maksimal berukuran 1MB',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => 400,
            'message' => $validator->errors()
        ]));
    }
}