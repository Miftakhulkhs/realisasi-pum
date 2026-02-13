<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Pum;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunSekarang = date('Y');
        $anggaran = Anggaran::where('tahun', $tahunSekarang)
            ->where('is_active', true)
            ->first();

        $totalPum = Pum::whereHas('anggaran', function($q) use ($tahunSekarang) {
            $q->where('tahun', $tahunSekarang);
        })->where('jenis', 'PUM')->sum('total_pum_spp');

        $totalSpp = Pum::whereHas('anggaran', function($q) use ($tahunSekarang) {
            $q->where('tahun', $tahunSekarang);
        })->where('jenis', 'SPP')->sum('total_pum_spp');

        $totalRealisasi = Pum::whereHas('anggaran', function($q) use ($tahunSekarang) {
            $q->where('tahun', $tahunSekarang);
        })->sum('realisasi');

        $recentPum = Pum::with(['anggaran', 'user'])
            ->whereHas('anggaran', function($q) use ($tahunSekarang) {
                $q->where('tahun', $tahunSekarang);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'anggaran',
            'totalPum',
            'totalSpp',
            'totalRealisasi',
            'recentPum'
        ));
    }
}
