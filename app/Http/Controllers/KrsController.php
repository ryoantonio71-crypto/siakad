<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\Krs;


class KrsController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Krs::with(['mahasiswa', 'mataKuliah']);

        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $krs = $query->get();

        $tahunAkademik = Krs::select('tahun_akademik')
            ->distinct()
            ->orderBy('tahun_akademik')
            ->pluck('tahun_akademik');

        return view('krs.index', compact('krs', 'tahunAkademik'));
    }


    public function create()
    {
        $mahasiswa = Mahasiswa::all();
        $matakuliah = MataKuliah::all();

        return view('krs.create', compact('mahasiswa', 'matakuliah'));
    }

    public function edit(Krs $krs)
    {
        $mahasiswa = Mahasiswa::all();
        $matakuliah = MataKuliah::all();

        $krs->load('mataKuliah');

        return view('krs.edit', compact('krs', 'mahasiswa', 'matakuliah'));
    }


    public function update(Request $request, Krs $krs)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $duplikat = Krs::where('mahasiswa_id', $validated['mahasiswa_id'])
            ->where('tahun_akademik', $validated['tahun_akademik'])
            ->where('semester', $validated['semester'])
            ->where('id', '!=', $krs->id)
            ->exists();

        if ($duplikat) {
            return back()->withInput()->withErrors([
                'mahasiswa_id' => 'Mahasiswa sudah memiliki KRS pada tahun akademik dan semester tersebut.',
            ]);
        }

        $krs->update([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'tahun_akademik' => $validated['tahun_akademik'],
            'semester' => $validated['semester'],
        ]);

        $krs->mataKuliah()->sync([
            $validated['mata_kuliah_id'],
        ]);

        return redirect()->route('krs.index')
            ->with('success', 'Data KRS berhasil diperbarui.');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'tahun_akademik' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $krs = Krs::firstOrCreate(
            [
                'mahasiswa_id' => $validated['mahasiswa_id'],
                'tahun_akademik' => $validated['tahun_akademik'],
                'semester' => $validated['semester'],
            ],
            [
                'status' => 'draft',
            ]
        );

        if ($krs->mataKuliah()->where('mata_kuliah.id', $validated['mata_kuliah_id'])->exists()) {
            return back()->withInput()
                ->withErrors([
                    'mata_kuliah_id' => 'Mata kuliah tersebut sudah terdaftar dalam KRS mahasiswa ini.',
                ]);
        }

        $krs->mataKuliah()->attach($validated['mata_kuliah_id']);

        return redirect()->route('krs.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function destroy(Krs $krs)
    {
        $krs->mataKuliah()->detach();
        $krs->delete();

        return response()->json([
            'message' => 'Data KRS berhasil dihapus.',
        ]);
    }
}
