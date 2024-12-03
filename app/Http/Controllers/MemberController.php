<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('admin.members.index', compact('members'));
    }

    // Menyimpan data anggota
    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    // Mengupdate data anggota
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama_anggota' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    // Menghapus data anggota
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
