<?php

namespace App\Http\Controllers\API;

use App\Abstracts\Http\ApiController;
use App\Http\Requests\API\Request;
use App\Models\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestShow = $request['show'] ? $request['show'] : 5;

        $users = User::paginate($requestShow);
        $data = [];

        foreach($users as $user) {
            $data[] = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email']
            ];
        }

        return response()->json([
            'code' => 1,
            'message' => "Get data success",
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUserByEmail(Request $request) {
        $user = User::where('email', $request->email)->first();
        $code = 0;
        $message = '';
        $data = [];

        if($user) {
            $code = 1;
            $message = 'Pencarian User Berhasil';
            $data = [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
            ];

        } else {
            $code = 0;
            $message = 'Email Tidak Ditemukan';
        }

        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
