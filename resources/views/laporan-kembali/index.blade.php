<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    .sidebar {
        width: 260px;
        min-width: 250px;
        background-color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        overflow-y: auto;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        flex: 1;
        min-width: 0;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 60px;
            min-width: 60px;
        }

        .main-content {
            margin-left: 60px;
        }
    }
</style>

<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar Include -->
        @include('partials.sidebar')

        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-file-alt text-gray-500 mr-2"></i>
                        Laporan Pengembalian
                    </h1>
                </div>

                <div class="mb-6 bg-gray-50 border-l-4 border-gray-500 p-4 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                        <p class="text-gray-700">Anda dapat mengekspor ke Excel</p>
                    </div>
                </div>

                <!-- Form Filter dan Export -->

                    <form action="{{ route('laporan-kembali.export') }}" method="GET" class="flex items-end">
                        <input type="hidden" name="barang" value="{{ request('barang') }}">
                        <input type="hidden" name="pinjam" value="{{ request('pinjam') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengembalian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($kembalis as $kembali)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kembali->pinjam->barang->nama_barang ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->pinjam->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($kembali->jumlah_kembali, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $kembali->status ? 'bg-gray-100 text-gray-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $kembali->status ? 'Approved' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->handledBy->name ?? 'admin' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data pengembalian
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>