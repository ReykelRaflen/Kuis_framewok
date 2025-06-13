<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BeritaController extends Controller
{
    public function index(): View
    {
        $beritas = Berita::latest()->paginate(10);
        return view('berita.index', compact('beritas'));
    }

    public function create(): View
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('berita.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'judul' => 'required|min:10|max:255',
            'konten' => 'required|min:20',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'required|max:100'
        ]);

        $fotoPath = $request->file('foto')->store('berita', 'public');

        Berita::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'foto' => $fotoPath,
            'penulis' => $request->penulis,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Berita $berita): View
    {
        return view('berita.show', compact('berita'));
    }

    public function edit(Berita $berita): View
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'judul' => 'required|min:10|max:255',
            'konten' => 'required|min:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'required|max:100'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'penulis' => $request->penulis,
        ];

        if ($request->hasFile('foto')) {
            if ($berita->foto) {
                Storage::disk('public')->delete($berita->foto);
            }
            $data['foto'] = $request->file('foto')->store('berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate!');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($berita->foto) {
            Storage::disk('public')->delete($berita->foto);
        }
        
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
