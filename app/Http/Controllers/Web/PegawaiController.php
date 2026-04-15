<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\User;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = User::query()
            ->where('role', 'pegawai')
            ->latest()
            ->paginate(10);

        return view('pegawai.index', compact('pegawai'));
    }

    public function store(StorePegawaiRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'pegawai';

        User::query()->create($data);

        return back()->with('success', 'Akun pegawai berhasil ditambahkan.');
    }

    public function update(UpdatePegawaiRequest $request, User $user)
    {
        abort_unless($user->role === 'pegawai', 404);

        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        abort_unless($user->role === 'pegawai', 404);

        $user->delete();

        return back()->with('success', 'Akun pegawai berhasil dihapus.');
    }
}
