@extends('layouts.app')

@section('title', 'Dashboard | Rotasi Stok')
@section('heading', 'Dashboard Analytics')
@section('subheading', 'Ringkasan dan pemantauan persediaan toko.')

@section('actions')
    <a href="{{ route('barang.index') }}"
       class="topbar-icon-btn"
       title="Lihat stok barang"
       aria-label="Lihat stok barang">
        🔔

        @if($stokMenipis > 0)
            <span class="topbar-icon-btn__dot"></span>
        @endif
    </a>
@endsection

@push('styles')
    <style>
        .dashboard-page {
            --d-surface: #ffffff;
            --d-surface-soft: #f1f5fc;
            --d-text: #252642;
            --d-muted: #85869f;
            --d-border: #ececf5;
            --d-primary: #2478dc;
            --d-shadow: 0 8px 28px rgba(40, 35, 80, .06);
        }

        .welcome {
            position: relative;
            padding: 27px 30px;
            margin-bottom: 23px;
            overflow: hidden;
            color: #fff;
            background: linear-gradient(110deg, #2478dc, #3f9bf0 55%, #1765c0);
            border-radius: 20px;
            box-shadow: 0 12px 28px rgba(36, 120, 220, .2);
        }

        .welcome::after {
            content: "";
            position: absolute;
            top: -105px;
            right: 45px;
            width: 210px;
            height: 210px;
            border: 35px solid rgba(255, 255, 255, .09);
            border-radius: 50%;
        }

        .welcome h2 {
            margin-bottom: 8px;
            font-size: 23px;
        }

        .welcome p {
            max-width: 550px;
            color: #eaf4ff;
            font-size: 13px;
            line-height: 1.7;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 17px;
            margin-bottom: 22px;
        }

        .stat-card {
            padding: 19px;
            background: var(--d-surface);
            border: 1px solid var(--d-border);
            border-radius: 17px;
            box-shadow: var(--d-shadow);
            transition: .25s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            font-size: 21px;
            border-radius: 13px;
        }

        .purple { background: #eee9ff; color: #8065db; }
        .blue { background: #e4f0ff; color: #4f91e8; }
        .green { background: #e0f7ed; color: #29a879; }
        .orange { background: #fff0df; color: #ed9b42; }

        .stat-card h3 {
            margin: 17px 0 4px;
            font-size: 26px;
        }

        .stat-card p {
            color: var(--d-muted);
            font-size: 12px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 14px;
            gap: 12px;
        }

        .section-heading h3 {
            color: var(--app-heading);
            font-size: 16px;
        }

        .section-heading span {
            color: var(--d-muted);
            font-size: 11px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 17px;
        }

        .chart-card {
            min-width: 0;
            padding: 20px;
            background: var(--d-surface);
            border: 1px solid var(--d-border);
            border-radius: 17px;
            box-shadow: var(--d-shadow);
        }

        .chart-card h3 {
            margin-bottom: 5px;
            color: var(--app-heading);
            font-size: 14px;
        }

        .chart-card p {
            margin-bottom: 17px;
            color: var(--d-muted);
            font-size: 11px;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 260px;
        }

        .chart-container.small {
            height: 230px;
        }

        .bottom-grid {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 17px;
            margin-top: 18px;
        }

        .notice-card,
        .fifo-card {
            padding: 21px;
            background: var(--d-surface);
            border: 1px solid var(--d-border);
            border-radius: 17px;
            box-shadow: var(--d-shadow);
        }

        .notice-title,
        .fifo-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .notice-title h3,
        .fifo-title h3 {
            color: var(--app-heading);
            font-size: 14px;
        }

        .notice-count {
            margin-left: auto;
            padding: 5px 10px;
            color: #d94d6c;
            background: #ffe5eb;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .notice-message {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px;
            background: var(--d-surface-soft);
            border-radius: 12px;
        }

        .notice-message .bell {
            font-size: 20px;
        }

        .notice-message strong {
            font-size: 12px;
        }

        .notice-message p {
            margin-top: 5px;
            color: var(--d-muted);
            font-size: 11px;
            line-height: 1.6;
        }

        .notice-link {
            display: inline-block;
            margin-top: 13px;
            color: var(--d-primary);
            font-size: 12px;
            font-weight: 700;
        }

        .fifo-card {
            display: block;
            color: #285c50;
            text-decoration: none;
            background: linear-gradient(135deg, #e9fff5, #e8f1ff);
            border: none;
            transition: .3s ease;
        }

        .fifo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(40, 35, 80, .13);
        }

        .fifo-title .fifo-icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            font-size: 21px;
            background: rgba(255, 255, 255, .65);
            border-radius: 13px;
        }

        .fifo-card p {
            font-size: 12px;
            line-height: 1.8;
            opacity: .85;
        }

        .fifo-status {
            display: inline-block;
            margin-top: 13px;
            padding: 6px 11px;
            color: #25845e;
            background: rgba(44, 160, 111, .13);
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .money-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 17px;
            margin-top: 18px;
        }

        .money-card {
            padding: 19px;
            background: var(--d-surface);
            border: 1px solid var(--d-border);
            border-radius: 16px;
            box-shadow: var(--d-shadow);
        }

        .money-card p {
            color: var(--d-muted);
            font-size: 12px;
        }

        .money-card h3 {
            margin-top: 10px;
            font-size: 21px;
        }

        .money-card:first-child h3 {
            color: #4e91df;
        }

        .money-card:last-child h3 {
            color: #27aa7d;
        }

        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 760px) {
            .charts-grid,
            .bottom-grid,
            .money-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .stats {
                gap: 10px;
            }

            .stat-card {
                padding: 14px;
            }

            .stat-card h3 {
                font-size: 22px;
            }

            .welcome {
                padding: 22px;
            }

            .chart-container {
                height: 230px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $kategoriLabels = $barangPerKategori->pluck('kategori')->map(fn($v) => $v ?: 'Tanpa Kategori')->values();
        $kategoriStok = $barangPerKategori->pluck('total_stok')->map(fn($v) => (int) $v)->values();
    @endphp

    <div class="dashboard-page">
        <section class="welcome">
            <h2>Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}! 👋</h2>
            <p>
                Kelola persediaan toko dengan lebih mudah.
                Pantau stok, transaksi, dan pergerakan barang melalui
                dashboard Rotasi Stok.
            </p>
        </section>

        <section class="stats">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon purple">📦</div>
                </div>
                <h3>{{ number_format($totalBarang ?? 0, 0, ',', '.') }}</h3>
                <p>Total Jenis Barang</p>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon blue">🗃️</div>
                </div>
                <h3>{{ number_format($totalStok ?? 0, 0, ',', '.') }}</h3>
                <p>Total Stok Barang</p>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon green">✅</div>
                </div>
                <h3>{{ number_format($stokAman ?? 0, 0, ',', '.') }}</h3>
                <p>Barang dengan Stok Aman</p>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon orange">⚠️</div>
                </div>
                <h3>{{ number_format($stokMenipis ?? 0, 0, ',', '.') }}</h3>
                <p>Barang dengan Stok Menipis</p>
            </div>
        </section>

        <div class="section-heading">
            <h3>📈 Analisis Persediaan</h3>
            <span>Data berdasarkan database</span>
        </div>

        <section class="charts-grid">
            <div class="chart-card">
                <h3>Pergerakan Stok per Kategori</h3>
                <p>Grafik garis dengan animasi saat dashboard dibuka.</p>
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Status Persediaan</h3>
                <p>Perbandingan stok aman dan stok menipis.</p>
                <div class="chart-container small">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>
        </section>

        <section class="charts-grid" style="margin-top:17px;">
            <div class="chart-card">
                <h3>Jumlah Stok per Kategori</h3>
                <p>Perbandingan jumlah stok setiap kategori barang.</p>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Ringkasan Kategori</h3>
                <p>Jumlah stok yang tersimpan pada setiap kategori.</p>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </section>

        <div class="section-heading">
            <h3>🔔 Informasi dan Sistem</h3>
            <span>Pemberitahuan persediaan</span>
        </div>

        <section class="bottom-grid">
            <div class="notice-card">
                <div class="notice-title">
                    <span style="font-size:22px;">🔔</span>
                    <h3>Notifikasi Stok</h3>

                    <span class="notice-count">
                        {{ $stokMenipis ?? 0 }} Peringatan
                    </span>
                </div>

                <div class="notice-message">
                    <span class="bell">⚠️</span>
                    <div>
                        @if(($stokMenipis ?? 0) > 0)
                            <strong>Ada barang yang stoknya menipis!</strong>
                            <p>
                                Terdapat {{ $stokMenipis }} jenis barang
                                dengan stok mencapai atau berada di bawah
                                batas minimum. Periksa data barang.
                            </p>
                        @else
                            <strong>Persediaan dalam kondisi aman.</strong>
                            <p>
                                Belum ada barang yang terdeteksi mencapai
                                batas minimum stok.
                            </p>
                        @endif
                    </div>
                </div>

                <a href="{{ route('barang.index') }}" class="notice-link">
                    Periksa data barang →
                </a>
            </div>

            <a href="{{ route('fifo.index') }}" class="fifo-card">
                <div class="fifo-title">
                    <div class="fifo-icon">🔄</div>
                    <div>
                        <h3>Sistem Rotasi Stok FIFO</h3>
                        <small>First In, First Out</small>
                    </div>
                </div>

                <p>
                    FIFO adalah metode pengelolaan persediaan yang
                    memprioritaskan barang yang masuk lebih dahulu
                    untuk dikeluarkan lebih dahulu.
                </p>

                <p style="margin-top:9px;">
                    Metode ini membantu menjaga urutan rotasi stok
                    dan mengurangi risiko barang terlalu lama tersimpan.
                </p>

                <span class="fifo-status">
                    ✓ Lihat Detail FIFO →
                </span>
            </a>
        </section>

        <section class="money-grid">
            <div class="money-card">
                <p>💰 Total Nilai Modal Persediaan</p>
                <h3>Rp {{ number_format($totalModal ?? 0, 0, ',', '.') }}</h3>
            </div>

            <div class="money-card">
                <p>💎 Total Nilai Jual Persediaan</p>
                <h3>Rp {{ number_format($totalNilaiJual ?? 0, 0, ',', '.') }}</h3>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const kategoriLabels = @json($kategoriLabels);
        const kategoriStok = @json($kategoriStok);

        const stokAman = Number(@json($stokAman ?? 0));
        const stokMenipis = Number(@json($stokMenipis ?? 0));

        const chartTextColor = '#777991';
        const chartGridColor = 'rgba(30, 30, 60, .07)';

        const chartColors = [
            '#8B72E8', '#48A6E8', '#35C99A', '#F5A65B',
            '#E77BA8', '#6CBAE8', '#B18AE8', '#E6CF62'
        ];

        function commonOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1800,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        labels: {
                            color: chartTextColor,
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 17
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: chartTextColor },
                        grid: { color: chartGridColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: chartTextColor },
                        grid: { color: chartGridColor }
                    }
                }
            };
        }

        // GRAFIK GARIS
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: kategoriLabels.length ? kategoriLabels : ['Belum ada kategori'],
                datasets: [{
                    label: 'Jumlah Stok',
                    data: kategoriStok.length ? kategoriStok : [0],
                    borderColor: '#9278F2',
                    backgroundColor: 'rgba(146,120,242,.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: .45,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#9278F2'
                }]
            },
            options: commonOptions()
        });

        // DIAGRAM DONAT
        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Stok Aman', 'Stok Menipis'],
                datasets: [{
                    data: [stokAman, stokMenipis],
                    backgroundColor: ['#35C99A', '#F16D91'],
                    borderWidth: 0,
                    hoverOffset: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '69%',
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1800
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: chartTextColor,
                            usePointStyle: true,
                            padding: 18
                        }
                    }
                }
            }
        });

        // GRAFIK BATANG
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: kategoriLabels.length ? kategoriLabels : ['Belum ada kategori'],
                datasets: [{
                    label: 'Jumlah Stok',
                    data: kategoriStok.length ? kategoriStok : [0],
                    backgroundColor: chartColors,
                    borderRadius: 9,
                    borderSkipped: false
                }]
            },
            options: {
                ...commonOptions(),
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // GRAFIK KATEGORI
        new Chart(document.getElementById('categoryChart'), {
            type: 'polarArea',
            data: {
                labels: kategoriLabels.length ? kategoriLabels : ['Belum ada kategori'],
                datasets: [{
                    data: kategoriStok.length ? kategoriStok : [0],
                    backgroundColor: chartColors,
                    borderWidth: 1,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1800,
                    easing: 'easeOutBounce'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: chartTextColor,
                            usePointStyle: true,
                            padding: 12
                        }
                    }
                },
                scales: {
                    r: {
                        ticks: { display: false },
                        grid: { color: chartGridColor }
                    }
                }
            }
        });
    </script>
@endpush
