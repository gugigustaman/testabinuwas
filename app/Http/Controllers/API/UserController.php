<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->sendResponse($users->toArray(), 'Daftar user berhasil diterima.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $messages = [
            'required' => 'Kolom ini wajib diisi.',
            'umur.min' => 'Mohon maaf, Anda belum cukup umur.',
        ];

        $validator = Validator::make($input, [
            'nama' => 'required',
            'umur' => 'required|numeric|min:17',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Mohon isi formulir dengan benar.', $validator->errors(), 400);
        }

        $user = User::create($input);

        return $this->sendResponse($user->toArray(), 'Berhasil menambahkan user.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User tidak ditemukan.');
        }

        return $this->sendResponse($user->toArray(), 'Data user berhasil diterima.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $messages = [
            'required' => 'Kolom ini wajib diisi.',
            'umur.min' => 'Mohon maaf, Anda belum cukup umur.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'umur' => 'required|numeric|min:17',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Mohon isi formulir dengan benar.', $validator->errors(), 400);
        }

        $user->nama = $request->nama;
        $user->umur = $request->umur;
        $user->save();

        return $this->sendResponse($user->toArray(), 'Berhasil mengubah user.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendResponse($user->toArray(), 'User berhasil dihapus.');
    }
}
