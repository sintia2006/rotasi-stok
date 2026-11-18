<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Rotasi Stok Retail')</title>

    <style>
        :root {
            --app-bg: #f3f6fc;
            --app-surface: #ffffff;
            --app-surface-soft: #f5f8fd;
            --app-text: #25344a;
            --app-heading: #1f3350;
            --app-muted: #8a98aa;
            --app-border: #e9eef6;
            --app-primary: #2478dc;
            --app-primary-dark: #1765c0;
            --app-danger: #d94d6c;
            --app-success: #1f9d6b;
            --app-warning: #c77a31;
            --app-radius: 14px;
            --app-shadow: 0 3px 16px rgba(30, 55, 90, .05);
            --app-sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background: var(--app-bg);
            color: var(--app-text);
            font-family: 'Segoe UI', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        /* SHELL */
        .app-main {
            display: flex;
            flex-direction: column;
            gap: 22px;
            min-height: 100vh;
            margin-left: var(--app-sidebar-width);
            padding: 24px 28px;
        }

        .app-content {
            flex: 1;
            min-width: 0;
        }

        .app-footer {
            padding-top: 4px;
            color: var(--app-muted);
            font-size: 12px;
            text-align: center;
        }

        /* TOPBAR */
        .app-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 16px 22px;
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: var(--app-radius);
            box-shadow: var(--app-shadow);
        }

        .app-topbar__left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .app-topbar__heading {
            min-width: 0;
        }

        .app-topbar__heading h1 {
            color: var(--app-heading);
            font-size: 19px;
            line-height: 1.25;
        }

        .app-topbar__heading p {
            margin-top: 4px;
            color: var(--app-muted);
            font-size: 12px;
            line-height: 1.4;
        }

        .sidebar-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            flex: 0 0 40px;
            width: 40px;
            height: 40px;
            padding: 0;
            color: var(--app-heading);
            font-size: 20px;
            background: var(--app-surface-soft);
            border: 1px solid var(--app-border);
            border-radius: 11px;
            cursor: pointer;
        }

        .sidebar-toggle:hover {
            color: var(--app-primary);
            border-color: var(--app-primary);
        }

        .sidebar-toggle:focus-visible {
            outline: 2px solid var(--app-primary);
            outline-offset: 2px;
        }

        .app-topbar__right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 0 0 auto;
        }

        .app-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 12px;
            border-left: 1px solid var(--app-border);
        }

        .app-user__avatar {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            color: var(--app-primary);
            font-size: 15px;
            font-weight: 700;
            background: #e8f1ff;
            border-radius: 50%;
        }

        .app-user__name {
            color: var(--app-heading);
            font-size: 13px;
            font-weight: 700;
            line-height: 1.3;
        }

        .app-user__role {
            margin-top: 2px;
            color: var(--app-muted);
            font-size: 11px;
        }

        /* REUSABLE PANEL */
        .panel {
            padding: 22px;
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: var(--app-radius);
            box-shadow: var(--app-shadow);
        }

        /* TOPBAR ACTIONS */
        .topbar-icon-btn {
            position: relative;
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            font-size: 18px;
            color: var(--app-heading);
            text-decoration: none;
            background: var(--app-surface-soft);
            border: 1px solid var(--app-border);
            border-radius: 11px;
            transition: border-color .2s ease, transform .2s ease;
        }

        .topbar-icon-btn:hover {
            border-color: var(--app-primary);
            transform: translateY(-2px);
        }

        .topbar-icon-btn__dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ff5d75;
            border: 2px solid var(--app-surface);
            border-radius: 50%;
        }

        @media (max-width: 992px) {
            .app-main {
                margin-left: 0;
                padding: 18px;
            }

            .sidebar-toggle {
                display: inline-flex;
            }

            .app-topbar {
                padding: 14px 16px;
            }
        }

        @media (max-width: 640px) {
            .app-main {
                gap: 16px;
                padding: 14px 12px;
            }

            .app-topbar {
                gap: 12px;
            }

            .app-topbar__heading h1 {
                font-size: 16px;
            }

            .app-topbar__heading p {
                display: none;
            }

            .app-user {
                padding-left: 0;
                border-left: 0;
            }

            .app-user__text {
                display: none;
            }

            .app-footer {
                font-size: 11px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <x-sidebar />

    <button type="button"
            class="app-sidebar-overlay"
            data-sidebar-close
            aria-label="Tutup menu"
            tabindex="-1"></button>

    <div class="app-main">
        <header class="app-topbar">
            <div class="app-topbar__left">
                <button type="button"
                        class="sidebar-toggle"
                        data-sidebar-toggle
                        aria-controls="app-sidebar"
                        aria-expanded="false"
                        aria-label="Buka menu navigasi">
                    ☰
                </button>

                <div class="app-topbar__heading">
                    <h1>@yield('heading', 'Dashboard')</h1>
                    <p>@yield('subheading', 'Sistem Informasi Pengelolaan Stok Retail')</p>
                </div>
            </div>

            <div class="app-topbar__right">
                @yield('actions')

                <div class="app-user">
                    <div class="app-user__avatar" aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="app-user__text">
                        <div class="app-user__name">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="app-user__role">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="app-content">
            @yield('content')
        </main>

        <footer class="app-footer">
            © {{ date('Y') }} Rotasi Stok — Sistem Informasi Pengelolaan Stok Retail
        </footer>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('app-sidebar');
            const toggle = document.querySelector('[data-sidebar-toggle]');
            const overlay = document.querySelector('[data-sidebar-close]');

            if (!sidebar || !toggle) {
                return;
            }

            function setOpen(isOpen) {
                sidebar.classList.toggle('is-open', isOpen);
                overlay?.classList.toggle('is-visible', isOpen);
                document.body.classList.toggle('sidebar-open', isOpen);
                toggle.setAttribute('aria-expanded', String(isOpen));
            }

            toggle.addEventListener('click', function () {
                setOpen(!sidebar.classList.contains('is-open'));
            });

            overlay?.addEventListener('click', function () {
                setOpen(false);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    setOpen(false);
                }
            });

            sidebar.querySelectorAll('a, button').forEach(function (element) {
                element.addEventListener('click', function () {
                    setOpen(false);
                });
            });

            window.addEventListener('resize', function () {
                if (window.innerWidth > 992) {
                    setOpen(false);
                }
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
