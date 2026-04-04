<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WargaController extends Controller
{
    public function dashboard(): View
    {
        $hour = Carbon::now()->hour;

        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Selamat pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat sore';
        } else {
            $greeting = 'Selamat malam';
        }

        $jumlahKepalaKeluarga = Warga::count();

        return view('welcome', [
            'greeting' => $greeting,
            'jumlahKepalaKeluarga' => $jumlahKepalaKeluarga,
            'pengumuman' => Pengumuman::latest()->take(3)->get(),
        ]);
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');

        $kepalaKeluargas = Warga::query()
            ->when($search, function ($query, $searchTerm) {
                $query->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('alamat', 'like', '%' . $searchTerm . '%')
                    ->orWhere('no_telepon', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->get();

        $kepalaKeluargaEdit = null;

        if ($request->filled('edit')) {
            $kepalaKeluargaEdit = Warga::find($request->query('edit'));
        }

        return view('index', [
            'kepalaKeluargas' => $kepalaKeluargas,
            'kepalaKeluargaEdit' => $kepalaKeluargaEdit,
            'search' => $search,
            'totalKepalaKeluarga' => Warga::count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ]);

        Warga::create($validated);

        return redirect()
            ->route('kepala-keluarga.index')
            ->with('success', 'Data kepala keluarga berhasil ditambahkan.');
    }

    public function update(Request $request, Warga $warga): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
        ]);

        $warga->update($validated);

        return redirect()
            ->route('kepala-keluarga.index')
            ->with('success', 'Data kepala keluarga berhasil diperbarui.');
    }

    public function destroy(Warga $warga): RedirectResponse
    {
        $warga->delete();

        return redirect()
            ->route('kepala-keluarga.index')
            ->with('success', 'Data kepala keluarga berhasil dihapus.');
    }
}
