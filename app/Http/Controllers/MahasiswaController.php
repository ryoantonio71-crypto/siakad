<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;


class MahasiswaController extends Controller
{
    // Menampilkan data mahasiswa
    // Menampilkan halaman data mahasiswa
    public function index(): View
    {
        $kolom = [
            'nim' => 'NIM',
            'nama' => 'Nama Lengkap',
            'angkatan' => 'Angkatan',
            'email' => 'Email',
        ];

        return view('mahasiswa.index', compact('kolom'));
    }

    // Mengambil data mahasiswa untuk DataTables
    public function data(): JsonResponse
    {
        return DataTables::eloquent(Mahasiswa::query())
            ->addIndexColumn()
            ->addColumn('aksi', function ($mahasiswa) {
                $aksi = '
                    <a href="' . route('mahasiswa.show', $mahasiswa->id) . '"
                        class="btn btn-sm btn-info">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                ';

                if (auth()->user()->role === 'admin') {
                    $aksi .= '
                        <a href="' . route('mahasiswa.edit', $mahasiswa->id) . '"
                            class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <button type="button"
                            class="btn btn-sm btn-danger btn-hapus"
                            data-url="' . route('mahasiswa.destroy', $mahasiswa->id) . '"
                            data-nama="' . e($mahasiswa->nama) . '">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    ';
                }

                return $aksi;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    // Menampilkan form tambah mahasiswa
    public function create(): View
    {
        return view('mahasiswa.create');
    }

    // Menyimpan data mahasiswa
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:15|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:mahasiswa,email',
            'angkatan' => 'required|integer',
            'program_studi' => 'required|string|max:255',
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    // Menampilkan form edit mahasiswa
    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // Memperbarui data mahasiswa
    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => [
                'required',
                'string',
                'max:15',
                Rule::unique('mahasiswa', 'nim')->ignore($mahasiswa->id),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('mahasiswa', 'email')->ignore($mahasiswa->id),
            ],
            'angkatan' => 'required|integer',
            'program_studi' => 'required|string|max:255',
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    // Menghapus data mahasiswa
    public function destroy(Mahasiswa $mahasiswa): JsonResponse
    {
        // Periksa apakah mahasiswa memiliki data KRS
        if ($mahasiswa->krs()->exists()) {
            return response()->json([
                'message' => 'Mahasiswa tidak dapat dihapus karena masih memiliki data KRS.',
            ], 422);
        }

        $mahasiswa->delete();

        return response()->json([
            'message' => 'Data mahasiswa berhasil dihapus.',
        ]);
    }

    // Menampilkan detail mahasiswa
    public function show(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }
}
