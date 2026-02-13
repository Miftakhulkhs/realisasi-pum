<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggaran = Anggaran::orderBy('tahun', 'desc')->get();
        return view('master.anggaran', compact('anggaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggaran' => 'required|numeric|min:0',
            'tahun' => 'required|digits:4|unique:anggaran,tahun',
        ]);

        // Nonaktifkan anggaran tahun sebelumnya
        Anggaran::where('tahun', '<', $validated['tahun'])
            ->update(['is_active' => false]);

        Anggaran::create([
            'anggaran' => $validated['anggaran'],
            'tahun' => $validated['tahun'],
            'sum_total' => 0,
            'sisa_anggaran' => $validated['anggaran'],
            'is_active' => true,
        ]);

        return redirect()->route('master.anggaran')->with('success', 'Anggaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $anggaran = Anggaran::findOrFail($id);

        $validated = $request->validate([
            'anggaran' => 'required|numeric|min:0',
            'tahun' => 'required|digits:4|unique:anggaran,tahun,' . $id . ',id_anggaran',
        ]);

        $anggaran->update([
            'anggaran' => $validated['anggaran'],
            'tahun' => $validated['tahun'],
        ]);

        $anggaran->updateSisaAnggaran();

        return redirect()->route('master.anggaran')->with('success', 'Anggaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        
        if ($anggaran->pum()->count() > 0) {
            return redirect()->route('master.anggaran')->with('error', 'Anggaran tidak dapat dihapus karena sudah digunakan');
        }

        $anggaran->delete();
        return redirect()->route('master.anggaran')->with('success', 'Anggaran berhasil dihapus');
    }

    public function activate($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        
        Anggaran::where('id_anggaran', '!=', $id)->update(['is_active' => false]);
        $anggaran->update(['is_active' => true]);

        return redirect()->route('master.anggaran')->with('success', 'Anggaran tahun ' . $anggaran->tahun . ' diaktifkan');
    }
}
