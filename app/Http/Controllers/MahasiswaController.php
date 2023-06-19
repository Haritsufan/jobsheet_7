<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\kelas;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');

        // Query untuk mencari mahasiswa berdasarkan nama
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $mahasiswa = Mahasiswa::orderby('id', 'asc')->paginate(3);


        return view('mahasiswa.index',['mahasiswa' => $mahasiswa]);



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas_id' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',

        ]);


        $mahasiswa =new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->No_Handphone = $request->get('No_Handphone');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Tanggal_Lahir = $request->get('Tanggal_Lahir');

        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id= $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')
        ->with('succsess', 'Mahasiswa Berhasil Ditambahkan');

        //fungsi eloquent untuk menambah data
        Mahasiswa::create($request->all());
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $Nim)
    {
        //
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $Nim)
    {
        //
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);
        Mahasiswa::create($request->all() + ['Tanggal_Lahir' => $request->input('Tanggal_Lahir')]);
        Mahasiswa::create($request->all() + ['Email' => $request->input('Email')]);
        //fungsi eloquent untuk mengupdate data inputan kita
        Mahasiswa::find($Nim)->update($request->all());
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $Nim)
    {
        //
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
