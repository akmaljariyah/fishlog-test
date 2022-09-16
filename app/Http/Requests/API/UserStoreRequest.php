<?php

namespace App\Http\Requests\API;

/**
 * @property string $nama
 * @property string $email
 * @property string  $password
 */
class UserStoreRequest extends Request
{
    /** @return array<mixed> */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,$id',
            'password' => 'required|min:5',
        ];
    }
}
