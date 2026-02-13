@extends('layouts.app')

@section('title', 'Input PUM/SPP')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Container Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            width: 100%;
        }

        /* Title */
        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        /* Button Style - KOMPAK */
        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            width: auto;
            white-space: nowrap;
        }

        .btn-tambah:hover {
            background-color: #1d4ed8;
        }

        .btn-tambah i {
            font-size: 12px;
        }

        /* Budget Info Card */
        .budget-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            padding: 16px 20px;
            margin-bottom: 18px;
            border-left: 4px solid #2563eb;
            border: 1px solid #e5e7eb;
        }

        .budget-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .budget-item {
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
            border: 1px solid #f1f5f9;
        }

        .budget-label {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            font-weight: 600;
        }

        .budget-value {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.2;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
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
            font-size: 12px;
            color: #1f2937;
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* Button Icon Only - untuk Edit & Hapus */
        .btn-icon {
            width: 26px;
            height: 26px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-icon i {
            font-size: 12px;
        }

        .btn-icon.btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-icon.btn-secondary:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .btn-icon.btn-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-icon.btn-danger:hover {
            background: #fecaca;
            color: #b91c1c;
        }

        /* Action Buttons Group */
        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* Badge */
        .badge {
            padding: 3px 10px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
            border: 1px solid transparent;
        }

        .badge-pum {
            background: #dbeafe;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .badge-spp {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        /* ===== MODAL KOMPAK ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            animation: modalSlideIn 0.2s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Modal Delete */
        .modal-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .modal-icon {
            width: 36px;
            height: 36px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            font-size: 18px;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
        }

        .modal-body {
            margin-bottom: 16px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        /* Modal Buttons - KOMPAK */
        .modal-btn {
            padding: 6px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            white-space: nowrap;
            min-width: 70px;
        }

        .modal-btn-cancel {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .modal-btn-cancel:hover {
            background: #e5e7eb;
        }

        .modal-btn-confirm {
            background: #ef4444;
            color: white;
        }

        .modal-btn-confirm:hover {
            background: #dc2626;
        }

        /* Form Modal Header */
        .form-modal-header {
            padding: 14px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
            margin: -20px -20px 16px -20px;
            border-radius: 10px 10px 0 0;
        }

        .form-modal-title {
            font-size: 15px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .form-modal-close {
            background: none;
            border: none;
            font-size: 22px;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .form-modal-close:hover {
            background: #e5e7eb;
            color: #4b5563;
        }

        /* Form - KOMPAK */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 13px;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control[readonly] {
            background: #f3f4f6;
            cursor: not-allowed;
        }

        .form-hint {
            color: #6b7280;
            font-size: 11px;
            margin-top: 4px;
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            justify-content: flex-end;
        }

        /* Form Buttons - KOMPAK */
        .form-actions .btn {
            padding: 6px 14px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            white-space: nowrap;
            min-width: 80px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Total Display - KOMPAK */
        .total-display {
            background: #f0f9ff;
            border: 1px solid #2563eb;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }

        .total-display.warning {
            background: #fee2e2;
            border-color: #ef4444;
        }

        .total-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .total-label {
            font-size: 12px;
            color: #1e40af;
            font-weight: 600;
        }

        .total-display.warning .total-label {
            color: #991b1b;
        }

        .total-sublabel {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
        }

        .total-value {
            font-size: 18px;
            font-weight: 700;
            color: #2563eb;
        }

        .total-display.warning .total-value {
            color: #ef4444;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-state-icon {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 15px;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .budget-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .budget-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: row;
            }

            .btn-icon {
                width: 30px;
                height: 30px;
            }
        }
    </style>

    <div class="page-header">
        <h2 class="page-title">Input PUM/SPP</h2>
        <button type="button" class="btn-tambah">
            <i class="bi bi-plus-lg"></i>
            Tambah
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!$anggaran)
        <div class="alert alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            Anggaran untuk tahun {{ date('Y') }} belum tersedia. Silakan hubungi administrator.
        </div>
    @else
        <!-- Info Anggaran -->
        <div class="budget-card">
            <div class="budget-grid">
                <div class="budget-item">
                    <div class="budget-label">Tahun Anggaran</div>
                    <div class="budget-value">{{ $anggaran->tahun }}</div>
                </div>
                <div class="budget-item">
                    <div class="budget-label">Total Anggaran</div>
                    <div class="budget-value">Rp {{ number_format($anggaran->anggaran, 0, ',', '.') }}</div>
                </div>
                <div class="budget-item">
                    <div class="budget-label">Total Terpakai</div>
                    <div class="budget-value" style="color: #ef4444;">Rp
                        {{ number_format($anggaran->sum_total, 0, ',', '.') }}</div>
                </div>
                <div class="budget-item">
                    <div class="budget-label">Sisa Anggaran</div>
                    <div class="budget-value" style="color: #10b981;">Rp
                        {{ number_format($anggaran->sisa_anggaran, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Tabel PUM/SPP -->
        <div class="card">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No. PUM/SPP</th>
                            <th>Nama Kegiatan</th>
                            <th>Jenis</th>
                            <th>Total PUM/SPP</th>
                            <th>Realisasi</th>
                            <th>Sisa Uang</th>
                            <th>Tgl PUM</th>
                            <th>Tgl LPJ</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pumList = $anggaran->pum()->orderBy('tanggal_pum', 'desc')->get();
                        @endphp
                        @forelse($pumList as $item)
                            <tr>
                                <td><strong style="font-size: 12px;">{{ $item->nopum }}</strong></td>
                                <td style="max-width: 200px; font-size: 12px;">{{ $item->nama_kegiatan }}</td>
                                <td>
                                    <span class="badge badge-{{ strtolower($item->jenis) }}">{{ $item->jenis }}</span>
                                </td>
                                <td style="font-size: 12px;">Rp {{ number_format($item->total_pum_spp, 0, ',', '.') }}</td>
                                <td style="font-size: 12px;">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                <td><strong style="font-size: 12px;">Rp
                                        {{ number_format($item->total_biaya, 0, ',', '.') }}</strong></td>
                                <td style="font-size: 12px;">{{ $item->tanggal_pum->format('d/m/Y') }}</td>
                                <td style="font-size: 12px;">
                                    {{ $item->tanggal_lpj ? $item->tanggal_lpj->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon btn-secondary btn-edit"
                                            data-id="{{ $item->id_pum }}" data-nopum="{{ $item->nopum }}"
                                            data-nama="{{ $item->nama_kegiatan }}" data-jenis="{{ $item->jenis }}"
                                            data-total-pum="{{ $item->total_pum_spp }}"
                                            data-realisasi="{{ $item->realisasi }}"
                                            data-tanggal-pum="{{ $item->tanggal_pum->format('Y-m-d') }}"
                                            data-tanggal-lpj="{{ $item->tanggal_lpj ? $item->tanggal_lpj->format('Y-m-d') : '' }}"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button type="button" class="btn-icon btn-danger btn-delete"
                                            data-id="{{ $item->id_pum }}" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                        <div class="empty-state-text">Belum ada data PUM/SPP</div>
                                        <div style="margin-top: 8px; font-size: 12px; color: #9ca3af;">
                                            Klik tombol "Tambah" untuk memulai
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal Tambah -->
    <div id="addModal" class="modal-overlay">
        <div class="modal">
            <div class="form-modal-header">
                <h3 class="form-modal-title">Tambah PUM/SPP</h3>
                <button type="button" class="form-modal-close" data-close="addModal">&times;</button>
            </div>
            <form action="{{ route('pum.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">No. PUM/SPP</label>
                    <input type="text" name="nopum" class="form-control" required placeholder="PUM/2025/001">
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="form-control" required placeholder="Nama kegiatan">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">Pilih</option>
                        <option value="PUM">PUM</option>
                        <option value="SPP">SPP</option>
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Total PUM/SPP</label>
                        <input type="number" id="add_total_pum_spp" name="total_pum_spp" class="form-control"
                            min="0" required placeholder="0">
                        <span class="form-hint">Uang diminta</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Realisasi</label>
                        <input type="number" id="add_realisasi" name="realisasi" class="form-control" min="0"
                            required placeholder="0">
                        <span class="form-hint">Uang digunakan</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal PUM</label>
                        <input type="date" name="tanggal_pum" class="form-control" value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal LPJ</label>
                        <input type="date" name="tanggal_lpj" class="form-control">
                    </div>
                </div>

                <!-- Total Display -->
                <div class="total-display" id="add_total_display">
                    <div class="total-header">
                        <div>
                            <div class="total-label">Sisa Uang</div>
                            <div class="total-sublabel">Total - Realisasi</div>
                        </div>
                        <div class="total-value" id="add_total_value">Rp 0</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" data-close="addModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal-overlay">
        <div class="modal">
            <div class="form-modal-header">
                <h3 class="form-modal-title">Edit PUM/SPP</h3>
                <button type="button" class="form-modal-close" data-close="editModal">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">No. PUM/SPP</label>
                    <input type="text" id="edit_nopum" name="nopum" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Kegiatan</label>
                    <input type="text" id="edit_nama_kegiatan" name="nama_kegiatan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select id="edit_jenis" name="jenis" class="form-control" required>
                        <option value="PUM">PUM</option>
                        <option value="SPP">SPP</option>
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Total PUM/SPP</label>
                        <input type="number" id="edit_total_pum_spp" name="total_pum_spp" class="form-control"
                            min="0" required>
                        <span class="form-hint">Uang diminta</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Realisasi</label>
                        <input type="number" id="edit_realisasi" name="realisasi" class="form-control" min="0"
                            required>
                        <span class="form-hint">Uang digunakan</span>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal PUM</label>
                        <input type="date" id="edit_tanggal_pum" name="tanggal_pum" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal LPJ</label>
                        <input type="date" id="edit_tanggal_lpj" name="tanggal_lpj" class="form-control">
                    </div>
                </div>

                <!-- Total Display -->
                <div class="total-display" id="edit_total_display">
                    <div class="total-header">
                        <div>
                            <div class="total-label">Sisa Uang</div>
                            <div class="total-sublabel">Total - Realisasi</div>
                        </div>
                        <div class="total-value" id="edit_total_value">Rp 0</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" data-close="editModal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete -->
    <div id="deleteModal" class="modal-overlay">
       <div class="modal">
            <div class="modal-header">
                <div class="modal-icon"><i class="bi bi-exclamation-triangle"></i></div>
                <div class="modal-title">Konfirmasi Hapus</div>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data anggaran ini?
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="button" class="modal-btn modal-btn-cancel" data-close="deleteModal">Batal</button>
                    <button type="submit" class="modal-btn modal-btn-confirm">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sisaAnggaran = {{ $anggaran ? $anggaran->sisa_anggaran : 0 }};

        document.addEventListener('DOMContentLoaded', function() {
            // Tombol Tambah
            const btnTambah = document.querySelector('.btn-tambah');
            if (btnTambah) {
                btnTambah.addEventListener('click', function() {
                    document.getElementById('addModal').classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            }

            // Calculate total for Add Modal
            document.getElementById('add_total_pum_spp').addEventListener('input', function() {
                calculateAddTotal();
            });
            document.getElementById('add_realisasi').addEventListener('input', function() {
                calculateAddTotal();
            });

            function calculateAddTotal() {
                const totalPum = parseFloat(document.getElementById('add_total_pum_spp').value) || 0;
                const realisasi = parseFloat(document.getElementById('add_realisasi').value) || 0;
                const sisaUang = totalPum - realisasi;

                const displayElement = document.getElementById('add_total_value');
                const containerElement = document.getElementById('add_total_display');

                displayElement.textContent = 'Rp ' + sisaUang.toLocaleString('id-ID');

                if (realisasi > sisaAnggaran) {
                    containerElement.classList.add('warning');
                } else {
                    containerElement.classList.remove('warning');
                }

                if (realisasi > totalPum) {
                    containerElement.classList.add('warning');
                }
            }

            // Calculate total for Edit Modal
            document.getElementById('edit_total_pum_spp').addEventListener('input', function() {
                calculateEditTotal();
            });
            document.getElementById('edit_realisasi').addEventListener('input', function() {
                calculateEditTotal();
            });

            function calculateEditTotal() {
                const totalPum = parseFloat(document.getElementById('edit_total_pum_spp').value) || 0;
                const realisasi = parseFloat(document.getElementById('edit_realisasi').value) || 0;
                const sisaUang = totalPum - realisasi;

                const displayElement = document.getElementById('edit_total_value');
                const containerElement = document.getElementById('edit_total_display');

                displayElement.textContent = 'Rp ' + sisaUang.toLocaleString('id-ID');

                if (realisasi > sisaAnggaran) {
                    containerElement.classList.add('warning');
                } else {
                    containerElement.classList.remove('warning');
                }

                if (realisasi > totalPum) {
                    containerElement.classList.add('warning');
                }
            }

            // Tombol Edit
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const id = this.getAttribute('data-id');
                    const nopum = this.getAttribute('data-nopum');
                    const nama = this.getAttribute('data-nama');
                    const jenis = this.getAttribute('data-jenis');
                    const totalPum = this.getAttribute('data-total-pum');
                    const realisasi = this.getAttribute('data-realisasi');
                    const tanggalPum = this.getAttribute('data-tanggal-pum');
                    const tanggalLpj = this.getAttribute('data-tanggal-lpj');

                    document.getElementById('editForm').action = '/pum/update/' + id;
                    document.getElementById('edit_nopum').value = nopum;
                    document.getElementById('edit_nama_kegiatan').value = nama;
                    document.getElementById('edit_jenis').value = jenis;
                    document.getElementById('edit_total_pum_spp').value = totalPum;
                    document.getElementById('edit_realisasi').value = realisasi;
                    document.getElementById('edit_tanggal_pum').value = tanggalPum;
                    document.getElementById('edit_tanggal_lpj').value = tanggalLpj;

                    calculateEditTotal();

                    document.getElementById('editModal').classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Tombol Delete
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const id = this.getAttribute('data-id');
                    document.getElementById('deleteForm').action = '/pum/delete/' + id;
                    document.getElementById('deleteModal').classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
            });

            // Close modal buttons
            document.querySelectorAll('[data-close]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-close');
                    document.getElementById(modalId).classList.remove('active');
                    document.body.style.overflow = '';
                });
            });

            // Close modal ketika klik di luar
            document.querySelectorAll('.modal-overlay').forEach(overlay => {
                overlay.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Close modal dengan ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay').forEach(modal => {
                        modal.classList.remove('active');
                    });
                    document.body.style.overflow = '';
                }
            });

            // Auto hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.3s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 4000);
        });
    </script>
@endsection
