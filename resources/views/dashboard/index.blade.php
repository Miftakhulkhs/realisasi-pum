@extends('layouts.app')

@section('title', 'Dashboard')

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
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    /* Info Box */
    .info-box {
        background: #f0f9ff;
        border-left: 4px solid #2563eb;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }

    .info-box-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .info-box-text {
        font-size: 12px;
        color: #475569;
        line-height: 1.5;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Stat Card */
    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        border-left: 4px solid;
        transition: all 0.2s;
    }

    .stat-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .stat-card.primary {
        border-left-color: #2563eb;
    }

    .stat-card.success {
        border-left-color: #10b981;
    }

    .stat-card.warning {
        border-left-color: #f59e0b;
    }

    .stat-card.info {
        border-left-color: #06b6d4;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 11px;
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        word-break: break-word;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-percentage {
        font-size: 11px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-percentage.positive {
        color: #10b981;
    }

    .stat-percentage.negative {
        color: #ef4444;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-card.primary .stat-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-card.success .stat-icon {
        background: #d1fae5;
        color: #10b981;
    }

    .stat-card.warning .stat-icon {
        background: #fef3c7;
        color: #f59e0b;
    }

    .stat-card.info .stat-icon {
        background: #cffafe;
        color: #06b6d4;
    }

    /* Card */
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .card-header {
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
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

    .card-body {
        padding: 16px;
    }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 260px;
        width: 100%;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-value {
            font-size: 18px;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            font-size: 16px;
        }
    }
</style>

<div class="page-header">
    <h2 class="page-title">Dashboard</h2>
</div>

@if (session('success'))
    <div class="alert alert-success">
        ✓ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error">
        ⚠ {{ session('error') }}
    </div>
@endif

<!-- Info Box -->
<div class="info-box">
    <div class="info-box-title">📊 Ringkasan Anggaran Tahun {{ date('Y') }}</div>
    <div class="info-box-text">
        Monitoring penggunaan anggaran dan perbandingan antara PUM dan SPP secara real-time.
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-header">
            <div class="stat-info">
                <div class="stat-label">Total Anggaran</div>
                <div class="stat-value">Rp {{ $anggaran ? number_format($anggaran->anggaran, 0, ',', '.') : 0 }}</div>
                <div class="stat-percentage">
                    Tahun {{ date('Y') }}
                </div>
            </div>
            <div class="stat-icon">💰</div>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-info">
                <div class="stat-label">Total PUM</div>
                <div class="stat-value">Rp {{ number_format($totalPum, 0, ',', '.') }}</div>
                <div class="stat-percentage">
                    {{ $anggaran && $anggaran->anggaran > 0 ? round(($totalPum / $anggaran->anggaran) * 100, 1) : 0 }}% dari anggaran
                </div>
            </div>
            <div class="stat-icon">📊</div>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-header">
            <div class="stat-info">
                <div class="stat-label">Total SPP</div>
                <div class="stat-value">Rp {{ number_format($totalSpp, 0, ',', '.') }}</div>
                <div class="stat-percentage">
                    {{ $anggaran && $anggaran->anggaran > 0 ? round(($totalSpp / $anggaran->anggaran) * 100, 1) : 0 }}% dari anggaran
                </div>
            </div>
            <div class="stat-icon">📈</div>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-info">
                <div class="stat-label">Sisa Anggaran</div>
                <div class="stat-value">Rp {{ $anggaran ? number_format($anggaran->sisa_anggaran, 0, ',', '.') : 0 }}</div>
                <div class="stat-percentage {{ $anggaran && $anggaran->sisa_anggaran < 0 ? 'negative' : 'positive' }}">
                    {{ $anggaran && $anggaran->anggaran > 0 ? round(($anggaran->sisa_anggaran / $anggaran->anggaran) * 100, 1) : 0 }}% tersisa
                </div>
            </div>
            <div class="stat-icon">💵</div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-grid">
    <!-- Budget Usage Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Penggunaan Anggaran</h3>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="budgetChart"></canvas>
            </div>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 12px; font-size: 11px; color: #6b7280;">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="display: inline-block; width: 10px; height: 10px; background: #ef4444; border-radius: 2px;"></span>
                    Terpakai: {{ $anggaran && $anggaran->anggaran > 0 ? round(($anggaran->sum_total / $anggaran->anggaran) * 100, 1) : 0 }}%
                </div>
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="display: inline-block; width: 10px; height: 10px; background: #10b981; border-radius: 2px;"></span>
                    Sisa: {{ $anggaran && $anggaran->anggaran > 0 ? round(($anggaran->sisa_anggaran / $anggaran->anggaran) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>
    </div>

    <!-- PUM vs SPP Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Perbandingan PUM & SPP</h3>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="pumSppChart"></canvas>
            </div>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 12px; font-size: 11px; color: #6b7280;">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="display: inline-block; width: 10px; height: 10px; background: #3b82f6; border-radius: 2px;"></span>
                    PUM: {{ ($totalPum + $totalSpp) > 0 ? round(($totalPum / ($totalPum + $totalSpp)) * 100, 1) : 0 }}%
                </div>
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="display: inline-block; width: 10px; height: 10px; background: #f59e0b; border-radius: 2px;"></span>
                    SPP: {{ ($totalPum + $totalSpp) > 0 ? round(($totalSpp / ($totalPum + $totalSpp)) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Data from Laravel
const totalAnggaran = {{ $anggaran ? $anggaran->anggaran : 0 }};
const totalTerpakai = {{ $anggaran ? $anggaran->sum_total : 0 }};
const sisaAnggaran = {{ $anggaran ? $anggaran->sisa_anggaran : 0 }};
const totalPum = {{ $totalPum }};
const totalSpp = {{ $totalSpp }};

// Budget Usage Chart (Doughnut)
const budgetCtx = document.getElementById('budgetChart');
if (budgetCtx) {
    new Chart(budgetCtx, {
        type: 'doughnut',
        data: {
            labels: ['Terpakai', 'Sisa'],
            datasets: [{
                data: [totalTerpakai, sisaAnggaran],
                backgroundColor: ['#ef4444', '#10b981'],
                borderWidth: 0,
                hoverOffset: 5,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleFont: { size: 12 },
                    bodyFont: { size: 11 },
                    padding: 8,
                    cornerRadius: 4
                }
            }
        }
    });
}

// PUM vs SPP Chart (Bar)
const pumSppCtx = document.getElementById('pumSppChart');
if (pumSppCtx) {
    new Chart(pumSppCtx, {
        type: 'bar',
        data: {
            labels: ['PUM', 'SPP'],
            datasets: [{
                data: [totalPum, totalSpp],
                backgroundColor: ['#3b82f6', '#f59e0b'],
                borderRadius: 4,
                borderWidth: 0,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed.y || 0;
                            let total = totalPum + totalSpp;
                            let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(0, 0, 0, 0.7)',
                    titleFont: { size: 12 },
                    bodyFont: { size: 11 },
                    padding: 8,
                    cornerRadius: 4
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            return 'Rp ' + value;
                        },
                        font: { size: 10 }
                    },
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.03)'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '500' } }
                }
            }
        }
    });
}
</script>
@endsection