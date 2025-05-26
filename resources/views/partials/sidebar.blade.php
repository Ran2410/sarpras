<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(12px);
            border-right: 1.5px solid rgba(99, 102, 241, 0.15);
        }

        .menu-item {
            transition: all 0.25s cubic-bezier(.4, 0, .2, 1);
        }

        .menu-item:hover {
            background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%);
            color: #fff !important;
            transform: scale(1.03) translateX(6px);
            box-shadow: 0 4px 24px 0 rgba(99, 102, 241, 0.12);
        }

        .active-menu {
            background: linear-gradient(90deg, #4f46e5 0%, #818cf8 100%);
            color: #fff !important;
            box-shadow: 0 4px 24px 0 rgba(99, 102, 241, 0.18);
            transform: scale(1.04);
        }
    </style>
</head>

<body class="bg-gradient-to-tr from-indigo-100 via-blue-100 to-pink-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="sidebar w-80 h-screen flex flex-col justify-between shadow-2xl text-white relative overflow-hidden">

        <div>
            <!-- Logo Area -->
            <div class="p-7 border-b border-indigo-800 flex items-center gap-3">
                <div class="bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-xl p-3 shadow-lg">
                    <i class="fas fa-terminal text-2xl"></i>
                </div>
                <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold tracking-wide text-white hover:text-indigo-200 transition-colors">Admin Panel</a>
            </div>

            <!-- Main Navigation -->
            <div class="p-7">
                <div class="text-xs text-indigo-200 font-semibold uppercase tracking-wider mb-5">Main Menu</div>
                <nav class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group hover:bg-red-700/60 hover:text-white">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-pink-500 to-blue-400 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('user.index') }}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group
                        {{ request()->is('user*') ? 'active-menu' : 'hover:bg-indigo-700/60 hover:text-white' }}">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-500 to-blue-500 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <span>User Management</span>
                    </a>
                    <a href="{{ route('kategori.index') }}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group hover:bg-indigo-700/60 hover:text-white">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-pink-500 to-indigo-400 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fas fa-tags text-xl"></i>
                        </div>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ route('barang.index') }}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group hover:bg-indigo-700/60 hover:text-white">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-green-400 to-blue-400 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <span>Barang</span>
                    </a>
                    <a href="{{route ('pinjam.index')}}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group hover:bg-indigo-700/60 hover:text-white">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-yellow-400 to-pink-400 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fas fa-hand-holding text-xl"></i>
                        </div>
                        <span>Peminjaman</span>
                    </a>
                    <a href="{{ route('kembali.index') }}"
                        class="menu-item flex items-center py-3 px-5 rounded-2xl font-medium group hover:bg-indigo-700/60 hover:text-white">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-pink-500 to-red-500 flex items-center justify-center mr-4 shadow-md group-hover:scale-110 transition">
                            <i class="fas fa-undo-alt text-xl"></i>
                        </div>
                        <span>Pengembalian</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Logout -->
        <div class="p-7">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-red-600 to-pink-700 text-white rounded-2xl font-bold flex items-center justify-center gap-3 transition-all transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-power-off text-lg"></i> Sign Out
                </button>
            </form>
            <div class="mt-5 text-xs text-center text-indigo-200">
                <p>© 2025 Your System</p>
            </div>
        </div>
    </aside>
</body>

</html>