<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Main content area */
        .main-content {
            flex: 1;
            min-width: 0;
            /* Allows content to shrink properly */
        }

        /* Table adjustments */
        .compact-table {
            font-size: 0.875rem;
            /* text-sm */
        }

        .compact-table th,
        .compact-table td {
            padding: 0.5rem 0.75rem;
            /* px-3 py-2 */
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                min-width: 60px;
            }
        }
    </style>
</head>

<body class="bg-gray-50 flex">
    <!-- Sidebar -->
    <div class="sidebar bg-gray-800 text-white flex-none">
        @include('partials.sidebar')
    </div>

    <!-- Main content -->
    <div class="main-content overflow-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-clipboard-list text-gray-500 mr-2"></i>
                        Laporan Peminjaman
                    </h1>
                </div>

                <div class="mb-6 bg-gray-50 border-l-4 border-gray-500 p-4 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                        <p class="text-gray-700">Anda dapat meneksport sebagai Excel</p>
                    </div>
                </div>

                <div></div>
                <!-- Export Button -->
                <!--Export -->
                    <form action="{{ route('laporan-pinjam.export') }}" method="GET" class="flex items-end">
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md flex items-center">
                            <i class="fas fa-file-excel mr-2"></i> Export Excel
                        </button>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 compact-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatoh Tempo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disetujui Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pinjams as $pinjam)
                            <tr class="hover:bg-gray-50">
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-medium text-gray-900">{{ $pinjam->barang->nama_barang ?? '-' }}</td>
                                <td>{{ $pinjam->user->name ?? '-' }}</td>
                                <td>{{ $pinjam->jumlah_pinjam }}</td>
                                <td>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $pinjam->status == 'pending' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $pinjam->status == 'approved' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $pinjam->status == 'rejected' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $pinjam->status == 'returned' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ $statuses[$pinjam->status] ?? $pinjam->status }}
                                    </span>
                                </td>
                                <td>{{ $pinjam->jatoh_tempo}}</td>
                                <td>{{ $pinjam->approvedBy->name ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>