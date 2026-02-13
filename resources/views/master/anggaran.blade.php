@extends('layouts.app')

@section('title', 'Data Master Anggaran')

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

        /* Container Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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

        .btn-tambah i {
            font-size: 12px;
        }

        .btn-tambah:hover {
            background-color: #1d4ed8;
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

        /* Button Small - untuk Aktifkan */
        .btn-sm {
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            white-space: nowrap;
        }

        .btn-sm i {
            font-size: 11px;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
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
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid transparent;
        }

        .badge i {
            font-size: 8px;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
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
            max-width: 340px;
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

        .form-hint {
            color: #6b7280;
            font-size: 11px;
            margin-top: 4px;
            display: block;
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
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .action-buttons {
                flex-direction: row;
            }

            .btn-sm {
                width: auto;
            }
        }
    </style>

    <div class="page-header">
        <h2 class="page-title">Data Master Anggaran</h2>
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

    <div class="card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Anggaran</th>
                        <th>Total Terpakai</th>
                        <th>Sisa Anggaran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggaran as $item)
                        <tr>
                            <td><strong style="font-size: 13px;">{{ $item->tahun }}</strong></td>
                            <td style="font-size: 13px;">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td style="font-size: 13px;">Rp {{ number_format($item->sum_total, 0, ',', '.') }}</td>
                            <td style="font-size: 13px;">Rp {{ number_format($item->sisa_anggaran, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->is_active)
                                    <span class="badge badge-active"><i class="bi bi-circle-fill"></i> Aktif</span>
                                @else
                                    <span class="badge badge-inactive"><i class="bi bi-circle"></i> Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button
                                        type="button"
                                        class="btn-icon btn-secondary btn-edit"
                                        data-id="{{ $item->id_anggaran }}"
                                        data-tahun="{{ $item->tahun }}"
                                        data-anggaran="{{ $item->anggaran }}"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    @if (!$item->is_active)
                                        <form action="{{ route('master.anggaran.activate', $item->id_anggaran) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Aktifkan
                                            </button>
                                        </form>
                                    @endif

                                    @if ($item->pum->count() == 0)
                                        <button 
                                            type="button"
                                            class="btn-icon btn-danger btn-delete"
                                            data-id="{{ $item->id_anggaran }}"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                    <div class="empty-state-text">Belum ada data anggaran</div>
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

    <!-- Modal Tambah -->
    <div id="addModal" class="modal-overlay">
        <div class="modal">
            <div class="form-modal-header">
                <h3 class="form-modal-title">Tambah Anggaran</h3>
                <button type="button" class="form-modal-close" data-close="addModal">&times;</button>
            </div>
            <form action="{{ route('master.anggaran.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tahun Anggaran</label>
                    <input type="number" name="tahun" class="form-control" min="2020" max="2100"
                        value="{{ date('Y') }}" required placeholder="2026">
                    <span class="form-hint">2020-2100</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Anggaran (Rp)</label>
                    <input type="number" name="anggaran" class="form-control" min="0" required
                        placeholder="10000000">
                    <span class="form-hint">Tanpa titik/koma</span>
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
                <h3 class="form-modal-title">Edit Anggaran</h3>
                <button type="button" class="form-modal-close" data-close="editModal">&times;</button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Tahun Anggaran</label>
                    <input type="number" id="editTahun" name="tahun" class="form-control" min="2020" max="2100" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah Anggaran (Rp)</label>
                    <input type="number" id="editAnggaran" name="anggaran" class="form-control" min="0" required>
                    <span class="form-hint">Tanpa titik/koma</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Tombol Tambah Anggaran
        const btnTambah = document.querySelector('.btn-tambah');
        if (btnTambah) {
            btnTambah.addEventListener('click', function() {
                document.getElementById('addModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        // Tombol Edit
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const id = this.getAttribute('data-id');
                const tahun = this.getAttribute('data-tahun');
                const anggaran = this.getAttribute('data-anggaran');
                
                document.getElementById('editForm').action = '/master/anggaran/' + id;
                document.getElementById('editTahun').value = tahun;
                document.getElementById('editAnggaran').value = anggaran;
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
                
                document.getElementById('deleteForm').action = '/master/anggaran/' + id;
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