@extends('layouts.app')

@section('title', 'History PUM/SPP')

@section('content')
<style>
    /* Alert Messages */
    .alert {
        padding: 10px 14px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    /* FILTER SECTION - LEBIH KOMPAK */
    .filter-section {
        background: white;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .filter-left {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f9fafb;
        padding: 4px 8px 4px 12px;
        border-radius: 6px;
        border: 1px solid #f1f5f9;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 500;
        color: #4b5563;
        white-space: nowrap;
    }

    .filter-select {
        padding: 6px 28px 6px 10px;
        border: none;
        border-radius: 4px;
        font-size: 13px;
        color: #1f2937;
        background: white;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 14px;
        min-width: 130px;
    }

    .filter-select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
    }

    .btn-reset {
        padding: 6px 14px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #4b5563;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .filter-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #6b7280;
    }

    .filter-badge {
        background: #e6f0ff;
        color: #1e40af;
        padding: 4px 10px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid #bfdbfe;
    }

    /* STATS CARD - LEBIH KECIL */
    .stats-wrapper {
        margin-bottom: 18px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        border-left: 4px solid;
        transition: all 0.15s;
    }

    .stat-card:hover {
        background: #fafbfc;
    }

    .stat-card:first-child {
        border-left-color: #2563eb;
    }

    .stat-card:nth-child(2) {
        border-left-color: #10b981;
    }

    .stat-card:nth-child(3) {
        border-left-color: #f59e0b;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        font-weight: 600;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-sub {
        font-size: 11px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .stat-sub span {
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 12px;
        color: #475569;
        font-size: 11px;
    }

    /* CARD TABLE */
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .card-header {
        padding: 12px 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* TABLE */
    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    thead {
        background: #f9fafb;
    }

    th {
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #4b5563;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    td {
        padding: 12px 14px;
        font-size: 13px;
        color: #1f2937;
        border-bottom: 1px solid #f1f5f9;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    /* BADGE */
    .badge {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .badge-pum {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }

    .badge-spp {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state-icon {
        font-size: 40px;
        margin-bottom: 12px;
        opacity: 0.5;
    }

    .empty-state-text {
        font-size: 15px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .empty-state-sub {
        font-size: 12px;
        color: #6b7280;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .filter-section {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .filter-left {
            flex-direction: column;
            width: 100%;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .filter-select {
            width: 100%;
            min-width: auto;
        }
    }
</style>

<div class="page-header">
    <h2 class="page-title">📋 History PUM/SPP</h2>
</div>

@if (session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-error">⚠ {{ session('error') }}</div>
@endif

<!-- FILTER SECTION - KOMPAK -->
<div class="filter-section">
    <div class="filter-left">
        <form method="GET" action="{{ route('pum.history') }}" id="filterForm" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <div class="filter-group">
                <span class="filter-label">Tahun</span>
                <select name="tahun" class="filter-select" onchange="this.form.submit()">
                    <option value="">Pilih Tahun</option>
                    @foreach ($tahunList as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Jenis</span>
                <select name="jenis" class="filter-select" onchange="this.form.submit()">
                    <option value="">Pilih Jenis</option>
                    <option value="PUM" {{ $jenis == 'PUM' ? 'selected' : '' }}>PUM</option>
                    <option value="SPP" {{ $jenis == 'SPP' ? 'selected' : '' }}>SPP</option>
                </select>
            </div>
        </form>
    </div>
    <div class="filter-info">
        @if($tahun || $jenis)
            <span class="filter-badge">
                {{ $tahun ? $tahun : '' }}
                {{ $tahun && $jenis ? '•' : '' }}
                {{ $jenis ? $jenis : '' }}
            </span>
            <a href="{{ route('pum.history') }}" class="btn-reset">✕ Reset</a>
        @else
            <span style="color: #9ca3af; font-size: 12px;">Pilih filter untuk melihat data</span>
        @endif
    </div>
</div>

<!-- STATISTICS - MUNCUL HANYA JIKA ADA FILTER & DATA -->
@if(($tahun || $jenis) && $pumList->count() > 0)
<div class="stats-wrapper">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total PUM/SPP</div>
            <div class="stat-value">Rp {{ number_format($pumList->sum('total_pum_spp'), 0, ',', '.') }}</div>
            <div class="stat-sub">
                <span>{{ $pumList->count() }} transaksi</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Realisasi</div>
            <div class="stat-value">Rp {{ number_format($pumList->sum('realisasi'), 0, ',', '.') }}</div>
            <div class="stat-sub">
                <span>{{ round(($pumList->sum('realisasi') / max($pumList->sum('total_pum_spp'), 1)) * 100, 1) }}%</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Biaya</div>
            <div class="stat-value">Rp {{ number_format($pumList->sum('total_biaya'), 0, ',', '.') }}</div>
            <div class="stat-sub">
                <span>Keseluruhan</span>
            </div>
        </div>
    </div>
</div>
@endif

<!-- TABLE -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <span>📋</span> Daftar Transaksi
        </h3>
        @if($pumList->count() > 0)
            <span style="font-size: 12px; color: #6b7280;">
                {{ $pumList->count() }} data
                @if($tahun) • {{ $tahun }} @endif
                @if($jenis) • {{ $jenis }} @endif
            </span>
        @endif
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. PUM</th>
                    <th>Nama Kegiatan</th>
                    <th>Jenis</th>
                    <th>Total PUM/SPP</th>
                    <th>Realisasi</th>
                    <th>Total Biaya</th>
                    <th>Tgl PUM</th>
                    <th>Tgl LPJ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pumList as $item)
                <tr>
                    <td><strong style="font-size: 12px;">{{ $item->nopum }}</strong></td>
                    <td style="max-width: 220px; font-size: 12px;">{{ $item->nama_kegiatan }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower($item->jenis) }}">{{ $item->jenis }}</span>
                    </td>
                    <td style="font-size: 12px;">Rp {{ number_format($item->total_pum_spp, 0, ',', '.') }}</td>
                    <td style="font-size: 12px;">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                    <td style="font-size: 12px;">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                    <td style="font-size: 12px;">{{ \Carbon\Carbon::parse($item->tanggal_pum)->format('d/m/Y') }}</td>
                    <td style="font-size: 12px;">{{ $item->tanggal_lpj ? \Carbon\Carbon::parse($item->tanggal_lpj)->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">🔍</div>
                            <div class="empty-state-text">
                                @if($tahun || $jenis)
                                    Data tidak ditemukan
                                @else
                                    Belum ada data
                                @endif
                            </div>
                            <div class="empty-state-sub">
                                @if($tahun || $jenis)
                                    Tidak ada transaksi dengan filter yang dipilih
                                @else
                                    Pilih tahun atau jenis dokumen
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Auto-hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.3s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    });
}, 4000);
</script>
@endsection