<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Pum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PumController extends Controller
{
    public function index()
    {
        $tahunSekarang = date('Y');
        $anggaran = Anggaran::where('tahun', $tahunSekarang)
            ->where('is_active', true)
            ->first();

        return view('pum.input', compact('anggaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nopum' => 'required|string|max:50|unique:pum,nopum',
            'nama_kegiatan' => 'required|string|max:200',
            'jenis' => 'required|in:PUM,SPP',
            'total_pum_spp' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'tanggal_pum' => 'required|date',
            'tanggal_lpj' => 'nullable|date',
        ]);

        $tahunSekarang = date('Y');
        $anggaran = Anggaran::where('tahun', $tahunSekarang)
            ->where('is_active', true)
            ->first();

        if (!$anggaran) {
            return back()->with('error', 'Anggaran untuk tahun ' . $tahunSekarang . ' belum tersedia');
        }

        // Validasi: realisasi tidak boleh lebih besar dari total_pum_spp
        if ($validated['realisasi'] > $validated['total_pum_spp']) {
            return back()->with('error', 'Realisasi tidak boleh lebih besar dari Total PUM/SPP');
        }

        // Hitung total biaya (sisa uang)
        $totalBiaya = $validated['total_pum_spp'] - $validated['realisasi'];

        // Cek apakah realisasi baru melebihi sisa anggaran
        if ($validated['realisasi'] > $anggaran->sisa_anggaran) {
            return back()->with('error', 'Realisasi melebihi sisa anggaran yang tersedia');
        }

        Pum::create([
            'nopum' => $validated['nopum'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'jenis' => $validated['jenis'],
            'total_pum_spp' => $validated['total_pum_spp'],
            'realisasi' => $validated['realisasi'],
            'total_biaya' => $totalBiaya,
            'tanggal_pum' => $validated['tanggal_pum'],
            'tanggal_lpj' => $validated['tanggal_lpj'],
            'id_anggaran' => $anggaran->id_anggaran,
            'id_user' => Auth::id(),
        ]);

        // Update sum_total dan sisa_anggaran
        $anggaran->updateSisaAnggaran();

        return redirect()->route('pum.input')->with('success', 'Data PUM/SPP berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pum = Pum::findOrFail($id);

        $validated = $request->validate([
            'nopum' => 'required|string|max:50|unique:pum,nopum,' . $id . ',id_pum',
            'nama_kegiatan' => 'required|string|max:200',
            'jenis' => 'required|in:PUM,SPP',
            'total_pum_spp' => 'required|numeric|min:0',
            'realisasi' => 'required|numeric|min:0',
            'tanggal_pum' => 'required|date',
            'tanggal_lpj' => 'nullable|date',
        ]);

        // Validasi: realisasi tidak boleh lebih besar dari total_pum_spp
        if ($validated['realisasi'] > $validated['total_pum_spp']) {
            return back()->with('error', 'Realisasi tidak boleh lebih besar dari Total PUM/SPP');
        }

        // Hitung total biaya baru (sisa uang)
        $totalBiaya = $validated['total_pum_spp'] - $validated['realisasi'];

        // Hitung selisih realisasi (realisasi baru - realisasi lama)
        $selisihRealisasi = $validated['realisasi'] - $pum->realisasi;

        // Cek apakah selisih realisasi melebihi sisa anggaran
        if ($selisihRealisasi > $pum->anggaran->sisa_anggaran) {
            return back()->with('error', 'Perubahan realisasi melebihi sisa anggaran yang tersedia');
        }

        $pum->update([
            'nopum' => $validated['nopum'],
            'nama_kegiatan' => $validated['nama_kegiatan'],
            'jenis' => $validated['jenis'],
            'total_pum_spp' => $validated['total_pum_spp'],
            'realisasi' => $validated['realisasi'],
            'total_biaya' => $totalBiaya,
            'tanggal_pum' => $validated['tanggal_pum'],
            'tanggal_lpj' => $validated['tanggal_lpj'],
        ]);

        // Update sum_total dan sisa_anggaran
        $pum->anggaran->updateSisaAnggaran();

        return redirect()->route('pum.input')->with('success', 'Data PUM/SPP berhasil diupdate');
    }

    public function destroy($id)
    {
        $pum = Pum::findOrFail($id);
        $anggaran = $pum->anggaran;
        
        $pum->delete();

        // Update sum_total dan sisa_anggaran setelah hapus
        $anggaran->updateSisaAnggaran();

        return redirect()->route('pum.input')->with('success', 'Data PUM/SPP berhasil dihapus');
    }

    public function history(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $jenis = $request->get('jenis');

        $query = Pum::with(['anggaran', 'user'])
            ->whereHas('anggaran', function($q) use ($tahun) {
                $q->where('tahun', $tahun);
            });

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $pumList = $query->orderBy('tanggal_pum', 'desc')->get();
        $tahunList = Anggaran::orderBy('tahun', 'desc')->pluck('tahun');

        return view('pum.history', compact('pumList', 'tahunList', 'tahun', 'jenis'));
    }
}