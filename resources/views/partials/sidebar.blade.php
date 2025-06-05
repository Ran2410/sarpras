<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: hidden;
            border-right: 1px solid #e5e7eb;
        }

        .menu-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: #6b7280;
            position: relative;
        }

        .menu-item:hover {
            background-color: #f8fafc;
            color: #374151;
            transform: translateX(2px);
        }

        .menu-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #9ca3af, #6b7280);
            border-radius: 0 2px 2px 0;
        }

        .active-menu {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: 500;
        }

        .active-menu::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #4b5563, #374151);
            border-radius: 0 2px 2px 0;
        }

        .logo-icon {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 1px solid #e5e7eb;
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 1rem 0;
        }

        .logout-btn {
            background: linear-gradient(135deg, #374151, #4b5563);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #1f2937, #374151);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="min-h-screen flex bg-gray-50">

    <!-- Sidebar -->
    <aside class="sidebar w-64 h-screen flex flex-col justify-between shadow-sm">

        <div>
            <!-- Logo Area -->
            <div class="p-6 flex items-center gap-3">
                <div class="logo-icon rounded-xl p-3">
                    <i class="fas fa-terminal text-xl text-gray-600"></i>
                </div>
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-800 hover:text-gray-600 transition-colors">
                    SARPRAS
                </a>
            </div>

            <div class="section-divider mx-6"></div>

            <!-- Main Navigation -->
            <div class="px-6 py-2">
                <div class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-4 px-3">
                    Navigation
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('dashboard') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-house mr-3 w-4 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('user.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('user*') ? 'active-menu' : '' }}">
                        <i class="fas fa-users mr-3 w-4 text-center"></i>
                        <span>User Management</span>
                    </a>
                    <a href="{{ route('kategori.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('kategori*') ? 'active-menu' : '' }}">
                        <i class="fas fa-tags mr-3 w-4 text-center"></i>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('barang.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('barang*') ? 'active-menu' : '' }}">
                        <i class="fas fa-box mr-3 w-4 text-center"></i>
                        <span>Barang</span>
                    </a>
                    <a href="{{ route('pinjam.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('pinjam*') ? 'active-menu' : '' }}">
                        <i class="fas fa-hand-holding mr-3 w-4 text-center"></i>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('kembali.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('kembali*') ? 'active-menu' : '' }}">
                        <i class="fas fa-undo-alt mr-3 w-4 text-center"></i>
                        <span>Pengembalian</span>
                    </a>
                    <a href="{{ route('laporan-barang.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('laporan-barang*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-file-alt mr-3 w-4 text-center"></i>
                        <span>Laporan Barang</span>
                    </a>
                    <a href="{{ route('laporan-pinjam.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('laporan-pinjam*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-file-alt mr-3 w-4 text-center"></i>
                        <span>Laporan Pinjam</span>
                    </a>
                    <a href="{{ route('laporan-kembali.index') }}"
                        class="menu-item flex items-center py-3 px-3 rounded-lg text-sm {{ request()->is('laporan-kembali*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-file-alt mr-3 w-4 text-center"></i>
                        <span>Laporan Kembali</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="p-6">
            <div class="section-divider mb-4"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="logout-btn w-full py-3 text-white rounded-lg text-sm font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-power-off text-xs"></i>
                    <span>Sign Out</span>
                </button>
            </form>

            <div class="mt-4 text-xs text-center text-gray-400">
                <p>© 2025 Admin System</p>
            </div>
        </div>
    </aside>

</body>

</html>