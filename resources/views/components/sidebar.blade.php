@php
    $menuGroups = [
        'Menu Utama' => [
            [
                'label' => 'Dashboard',
                'icon' => '🏠',
                'url' => route('dashboard'),
                'active' => ['dashboard'],
            ],
            [
                'label' => 'Data Barang',
                'icon' => '📦',
                'url' => route('barang.index'),
                'active' => ['barang.*'],
            ],
            [
                'label' => 'Barang Masuk',
                'icon' => '📥',
                'url' => route('barang-masuk.index'),
                'active' => ['barang-masuk.*'],
            ],
            [
                'label' => 'Barang Keluar',
                'icon' => '📤',
                'url' => route('barang-keluar.index'),
                'active' => ['barang-keluar.*'],
            ],
            [
                'label' => 'Riwayat Transaksi',
                'icon' => '🔄',
                'url' => route('transaksi.riwayat'),
                'active' => ['transaksi.*'],
            ],
            [
                'label' => 'Stok FIFO',
                'icon' => '🧾',
                'url' => route('fifo.index'),
                'active' => ['fifo.*'],
            ],
            [
                'label' => 'Laporan',
                'icon' => '📊',
                'url' => route('laporan.index'),
                'active' => ['laporan.*'],
            ],
        ],
        'Pengaturan Akun' => [
            [
                'label' => 'Profil Admin',
                'icon' => '👤',
                'url' => route('profile.edit'),
                'active' => ['profile.*'],
            ],
            [
                'label' => 'Manajemen Pengguna',
                'icon' => '👥',
                'url' => route('users.index'),
                'active' => ['users.*'],
            ],
        ],
    ];
@endphp

@once
    <style>
        .app-sidebar {
            --sidebar-width: 260px;
            --sidebar-bg: #172b4d;
            --sidebar-bg-soft: #1d3559;
            --sidebar-accent: #2478dc;
            --sidebar-accent-dark: #1765c0;
            --sidebar-text: #d3deee;
            --sidebar-muted: #8fa4c3;
            --sidebar-border: rgba(255, 255, 255, .11);
            --sidebar-radius: 10px;

            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1200;
            display: flex;
            flex-direction: column;
            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;
            padding: 22px 16px 18px;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(120% 70% at 0% 0%, rgba(64, 132, 218, .28), transparent 55%),
                linear-gradient(180deg, var(--sidebar-bg), #101f38);
            box-shadow: 12px 0 30px rgba(15, 30, 55, .08);
        }

        .app-sidebar__brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 8px 20px;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .app-sidebar__brand-icon {
            display: grid;
            place-items: center;
            flex: 0 0 43px;
            width: 43px;
            height: 43px;
            font-size: 22px;
            background: linear-gradient(135deg, #3b93f2, var(--sidebar-accent));
            border-radius: 12px;
            box-shadow: 0 8px 18px rgba(36, 120, 220, .35);
        }

        .app-sidebar__brand-text {
            min-width: 0;
        }

        .app-sidebar__brand-text h2 {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: .6px;
            white-space: nowrap;
        }

        .app-sidebar__brand-text small {
            display: block;
            margin-top: 2px;
            font-size: 10px;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            color: var(--sidebar-muted);
        }

        .app-sidebar__nav {
            flex: 1;
            margin: 0 -6px;
            padding: 4px 6px 16px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .25) transparent;
        }

        .app-sidebar__nav::-webkit-scrollbar {
            width: 5px;
        }

        .app-sidebar__nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .22);
            border-radius: 20px;
        }

        .app-sidebar__group-title {
            margin: 22px 12px 9px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--sidebar-muted);
        }

        .app-sidebar__group:first-child .app-sidebar__group-title {
            margin-top: 16px;
        }

        .app-sidebar__link {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 4px;
            padding: 11px 13px;
            color: var(--sidebar-text);
            font-size: 13px;
            line-height: 1.3;
            text-decoration: none;
            border-radius: var(--sidebar-radius);
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .app-sidebar__link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .09);
            transform: translateX(3px);
        }

        .app-sidebar__link:focus-visible {
            outline: 2px solid #8fc3ff;
            outline-offset: 2px;
        }

        .app-sidebar__link.is-active {
            color: #fff;
            background: linear-gradient(135deg, #2b8bef, var(--sidebar-accent-dark));
            box-shadow: 0 8px 18px rgba(20, 92, 180, .34);
        }

        .app-sidebar__link-icon {
            display: grid;
            place-items: center;
            flex: 0 0 22px;
            width: 22px;
            font-size: 17px;
            line-height: 1;
        }

        .app-sidebar__footer {
            flex: 0 0 auto;
            margin-top: 8px;
            padding-top: 14px;
            border-top: 1px solid var(--sidebar-border);
        }

        .app-sidebar__logout {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 11px 13px;
            font-size: 13px;
            color: #ffc1c9;
            text-align: left;
            background: transparent;
            border: 0;
            border-radius: var(--sidebar-radius);
            cursor: pointer;
            transition: background .2s ease, color .2s ease;
        }

        .app-sidebar__logout:hover {
            color: #fff;
            background: rgba(255, 90, 105, .16);
        }

        .app-sidebar__logout:focus-visible {
            outline: 2px solid #ff9daa;
            outline-offset: 2px;
        }

        .app-sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 1150;
            display: block;
            width: 100%;
            height: 100%;
            padding: 0;
            background: rgba(10, 20, 38, .55);
            border: 0;
            opacity: 0;
            visibility: hidden;
            cursor: pointer;
            transition: opacity .25s ease, visibility .25s ease;
        }

        .app-sidebar-overlay.is-visible {
            opacity: 1;
            visibility: visible;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        @media (max-width: 992px) {
            .app-sidebar {
                width: min(282px, 86vw);
                transform: translateX(-102%);
                transition: transform .28s ease;
                box-shadow: 18px 0 45px rgba(10, 20, 38, .3);
            }

            .app-sidebar.is-open {
                transform: translateX(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .app-sidebar,
            .app-sidebar__link,
            .app-sidebar-overlay {
                transition: none;
            }
        }
    </style>
@endonce

<aside class="app-sidebar" id="app-sidebar" aria-label="Navigasi utama">
    <a href="{{ route('dashboard') }}" class="app-sidebar__brand">
        <span class="app-sidebar__brand-icon" aria-hidden="true">📦</span>
        <span class="app-sidebar__brand-text">
            <h2>ROTASI STOK</h2>
            <small>Retail Inventory</small>
        </span>
    </a>

    <nav class="app-sidebar__nav">
        @foreach ($menuGroups as $groupTitle => $items)
            <div class="app-sidebar__group">
                <div class="app-sidebar__group-title">{{ $groupTitle }}</div>

                @foreach ($items as $item)
                    @php($isActive = request()->routeIs(...$item['active']))

                    <a href="{{ $item['url'] }}"
                       class="app-sidebar__link {{ $isActive ? 'is-active' : '' }}"
                       @if ($isActive) aria-current="page" @endif>
                        <span class="app-sidebar__link-icon" aria-hidden="true">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <div class="app-sidebar__footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="app-sidebar__logout">
                <span class="app-sidebar__link-icon" aria-hidden="true">🚪</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
