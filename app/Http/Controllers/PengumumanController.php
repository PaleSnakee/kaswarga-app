<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $pengumumans = Pengumuman::query()
            ->when($search, function ($query, $searchTerm) {
                $query->where('judul', 'like', '%' . $searchTerm . '%')
                    ->orWhere('isi', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->get();

        $pengumumanEdit = null;

        if ($request->filled('edit')) {
            $pengumumanEdit = Pengumuman::find($request->query('edit'));
        }

        return view('pengumuman.index', [
            'pengumumans' => $pengumumans,
            'pengumumanEdit' => $pengumumanEdit,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
        ]);

        Pengumuman::create($validated);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
        ]);

        $pengumuman->update($validated);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        $pengumuman->delete();

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
