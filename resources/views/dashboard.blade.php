<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
                <p class="text-gray-600">Welcome back! Here's what's happening today.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Users Card -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Total Users</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $userCount }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-users text-blue-500 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('user.index') }}" class="mt-4 inline-flex items-center text-blue-500 hover:text-blue-700">
                        View details
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Categories Card -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Kategori</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $kategoriCount }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-tags text-green-500 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('kategori.index') }}" class="mt-4 inline-flex items-center text-blue-500 hover:text-blue-700">
                        View details
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Products Card -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Barang</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $barangCount }}</h3>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-boxes text-purple-500 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('barang.index') }}" class="mt-4 inline-flex items-center text-blue-500 hover:text-blue-700">
                        View details
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Borrowing Card -->
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Peminjaman</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $pinjamCount }}</h3>
                        </div>
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-exchange-alt text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('pinjam.index') }}" class="mt-4 inline-flex items-center text-blue-500 hover:text-blue-700">
                        View details
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Additional Content Section -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
                <p class="text-gray-600">Your recent activities will appear here.</p>
                <!-- You can add recent activity items here -->
            </div>
        </div>
    </div>
</body>

</html>