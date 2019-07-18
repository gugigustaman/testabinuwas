<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Validator;

class BookController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('user')->get();

        return $this->sendResponse($books->toArray(), 'Daftar buku berhasil diterima.');
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
            'pemilik.exists' => 'User tidak ditemukan.',
        ];

        $validator = Validator::make($input, [
            'judul' => 'required',
            'jumlah_halaman' => 'required|numeric',
            'penerbit' => 'required',
            'user_id' => 'required|exists:User,id',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Mohon isi formulir dengan benar.', $validator->errors(), 400);
        }

        $user = User::withCount('book')->find($request->user_id);

        if ($user->book_count >= 3) {
            return $this->sendError('Maaf, anda harus punya maksimal 3 buku.', $validator->errors(), 401);
        }

        $book = Book::create($input);

        return $this->sendResponse($book->toArray(), 'Berhasil menambahkan buku.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        if (is_null($book)) {
            return $this->sendError('Buku tidak ditemukan.');
        }

        return $this->sendResponse($book->toArray(), 'Data buku berhasil diterima.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $messages = [
            'required' => 'Kolom ini wajib diisi.',
            'umur.min' => 'Mohon maaf, Anda belum cukup umur.',
        ];

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'jumlah_halaman' => 'required|numeric',
            'penerbit' => 'required',
            'user_id' => 'required|exists:User,id',
        ], $messages);

        if ($validator->fails()) {
            return $this->sendError('Mohon isi formulir dengan benar.', $validator->errors(), 400);
        }

        $user = User::withCount('book')->find($request->user_id);

        if ($user->book_count >= 3 && $book->user_id != $request->user_id) {
            return $this->sendError('Maaf, anda harus punya maksimal 3 buku.', $validator->errors(), 401);
        }

        $book->judul = $request->judul;
        $book->jumlah_halaman = $request->jumlah_halaman;
        $book->penerbit = $request->penerbit;
        $book->user_id = $request->user_id;
        $book->save();

        return $this->sendResponse($book->toArray(), 'Berhasil mengubah buku.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return $this->sendResponse($book->toArray(), 'Buku berhasil dihapus.');
    }
}
