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
                <p class="text-gray-600">Selamat datang kembali!</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Users Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Total Users</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $userCount }}</h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-users text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('user.index') }}" class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800">
                        Tampilan Lengkap
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Categories Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Kategori</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $kategoriCount }}</h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-tags text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('kategori.index') }}" class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800">
                        Tampilan Lengkap
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Products Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Barang</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $barangCount }}</h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-boxes text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('barang.index') }}" class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800">
                        Tampilan Lengkap
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>

                <!-- Borrowing Card -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 font-medium">Peminjaman</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $pinjamCount }}</h3>
                        </div>
                        <div class="bg-gray-100 p-3 rounded-full">
                            <i class="fas fa-exchange-alt text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <a href="{{ route('pinjam.index') }}" class="mt-4 inline-flex items-center text-gray-600 hover:text-gray-800">
                        Tampilan Lengkap
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Activity Section - Updated Design -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Aktivitas Terakhir - Peminjaman</h2>
                    @if(!$recentPinjams->isEmpty())
                    <a href="{{ route('pinjam.index') }}" class="text-sm text-gray-600 hover:text-gray-800">Liat Semua</a>
                    @endif
                </div>

                @if($recentPinjams->isEmpty())
                <p class="text-gray-600">Tidak ada aktivitas peminjaman terbaru.</p>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentPinjams as $pinjam)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $pinjam->user->name ?? 'Unknown User' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800">{{ $pinjam->barang->nama_barang ?? 'Barang' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($pinjam->status == 'approved')
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-300">Sedang Dipinjam</span>
                                    @elseif($pinjam->status == 'returned')
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-300">Dikembalikan</span>
                                    @elseif($pinjam->status == 'pending')
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-300">Menunggu</span>
                                    @elseif($pinjam->status == 'rejected')
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-300">Ditolak</span>
                                    @else
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full border border-gray-300">Unknown</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $pinjam->updated_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>