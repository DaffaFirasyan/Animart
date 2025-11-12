<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class KaryawanController extends Controller
{
    /**
     * Menampilkan daftar semua karyawan.
     */
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')
                        ->latest()
                        ->paginate(10);
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Menampilkan form untuk membuat karyawan baru.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Menyimpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat karyawan baru dengan role 'karyawan' (tidak bisa membuat admin)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'karyawan', // Paksa role menjadi karyawan
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit karyawan.
     */
    public function edit(User $karyawan)
    {
        // Pastikan user yang diedit adalah karyawan, bukan admin
        if ($karyawan->role !== 'karyawan') {
            abort(403, 'Anda tidak dapat mengedit user dengan role admin.');
        }

        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update data karyawan.
     */
    public function update(Request $request, User $karyawan)
    {
        // Pastikan user yang diupdate adalah karyawan, bukan admin
        if ($karyawan->role !== 'karyawan') {
            abort(403, 'Anda tidak dapat mengupdate user dengan role admin.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $karyawan->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Update data karyawan
        $karyawan->name = $request->name;
        $karyawan->email = $request->email;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $karyawan->password = Hash::make($request->password);
        }

        // Pastikan role tetap karyawan
        $karyawan->role = 'karyawan';
        $karyawan->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('karyawan.index')
                         ->with('success', 'Data karyawan berhasil diupdate.');
    }

    /**
     * Hapus karyawan dari database.
     */
    public function destroy(User $karyawan)
    {
        // Pastikan user yang dihapus adalah karyawan, bukan admin
        if ($karyawan->role !== 'karyawan') {
            abort(403, 'Anda tidak dapat menghapus user dengan role admin.');
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')
                         ->with('success', 'Karyawan berhasil dihapus.');
    }
}
