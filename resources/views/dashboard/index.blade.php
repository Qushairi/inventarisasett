@extends('layouts.app')

@section('page_title', 'Dashboard Monitoring Aset')
@section('page_subtitle', 'Ringkasan kondisi inventaris Disdik Kabupaten Bengkalis')

@push('styles')
<style>
    .flexy-wrap {
        padding-top: 0.5rem;
    }

    .flexy-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.08);
        background: #ffffff;
    }

    .flexy-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #12213f;
        margin-bottom: 0.25rem;
    }

    .flexy-subtitle {
        color: #6c7a92;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .chart-shell {
        margin-top: 1.5rem;
        height: 290px;
    }

    .mini-chart-shell {
        margin-top: 1rem;
        height: 290px;
    }

    .metric-card {
        border: 0;
        border-radius: 10px;
        box-shadow: 0 1px 2px rgba(16, 24, 40, 0.08);
        height: 100%;
    }

    .metric-label {
        color: #6f7f97;
        font-size: 0.83rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .metric-value {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.15;
        color: #1a2b4f;
    }

    .asset-summary-table th {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #6f7f97;
        border-bottom-color: #edf1f7;
    }

    .asset-summary-table td {
        color: #1a2b4f;
        font-weight: 600;
        vertical-align: middle;
        border-bottom-color: #edf1f7;
    }

    @media (max-width: 1199.98px) {
        .chart-shell {
            height: 240px;
        }

        .mini-chart-shell {
            height: 240px;
        }
    }
</style>
@endpush

@section('content')
@php
    $chartLabels = [
        'Total Aset',
        'Aset Tersedia',
        'Aset Dipinjam',
        'Menunggu Persetujuan',
        'Menunggu Verifikasi',
    ];
    $chartValues = [
        (int) ($stats['total_aset'] ?? 0),
        (int) ($stats['aset_tersedia'] ?? 0),
        (int) ($stats['aset_dipinjam'] ?? 0),
        (int) ($stats['peminjaman_menunggu'] ?? 0),
        (int) ($stats['pengembalian_menunggu'] ?? 0),
    ];
    $conditionLabels = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
    $conditionValues = [
        (int) ($stats['kondisi_baik'] ?? 0),
        (int) ($stats['kondisi_rusak_ringan'] ?? 0),
        (int) ($stats['kondisi_rusak_berat'] ?? 0),
    ];
@endphp

    <div class="flexy-wrap">
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card flexy-card h-100">
                <div class="card-body p-4 p-xl-5">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <h4 class="flexy-title">Sales Overview</h4>
                            <p class="flexy-subtitle">Visualisasi jumlah inventaris berdasarkan data dashboard saat ini</p>
                        </div>
                        <span class="badge text-bg-light">Bar Chart</span>
                    </div>

                    <div class="chart-shell">
                        <canvas id="salesOverviewChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card flexy-card h-100">
                <div class="card-body p-4 p-xl-5">
                    <div class="mb-3">
                        <div>
                            <h4 class="flexy-title">Kondisi Aset</h4>
                            <p class="flexy-subtitle">Diagram kondisi inventaris saat ini</p>
                        </div>
                    </div>

                    <div class="mini-chart-shell">
                        <canvas id="assetConditionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-md-6 col-xl-4">
            <div class="card metric-card">
                <div class="card-body">
                    <div class="metric-label">Total Aset</div>
                    <div class="metric-value">{{ $stats['total_aset'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card metric-card">
                <div class="card-body">
                    <div class="metric-label">Aset Tersedia</div>
                    <div class="metric-value text-success">{{ $stats['aset_tersedia'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card metric-card">
                <div class="card-body">
                    <div class="metric-label">Aset Dipinjam</div>
                    <div class="metric-value text-warning">{{ $stats['aset_dipinjam'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card flexy-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1" style="color:#12213f;font-weight:700;">Ringkasan Data Aset</h5>
                            <p class="mb-0 text-muted">Tabel jumlah aset utama pada dashboard</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table asset-summary-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:72px;">No</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Total Aset</td>
                                    <td class="text-end">{{ $stats['total_aset'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Aset Tersedia</td>
                                    <td class="text-end text-success">{{ $stats['aset_tersedia'] ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Aset Dipinjam</td>
                                    <td class="text-end text-warning">{{ $stats['aset_dipinjam'] ?? 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    (() => {
        if (typeof Chart === 'undefined') return;

        const canvas = document.getElementById('salesOverviewChart');
        if (!canvas) return;

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah',
                    data: @json($chartValues),
                    backgroundColor: [
                        '#2c56c0',
                        '#2ebf74',
                        '#f4c20d',
                        '#20a9f5',
                        '#7e57c2'
                    ],
                    borderRadius: 10,
                    borderSkipped: false,
                    maxBarThickness: 60
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                return 'Jumlah: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#edf1f7'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const conditionCanvas = document.getElementById('assetConditionChart');
        if (!conditionCanvas) return;

        new Chart(conditionCanvas, {
            type: 'doughnut',
            data: {
                labels: @json($conditionLabels),
                datasets: [{
                    data: @json($conditionValues),
                    backgroundColor: ['#2c56c0', '#f4c20d', '#e53935'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            padding: 18
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                return context.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    })();
</script>
@endpush
