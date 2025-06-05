<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .empty-state-icon {
            color: #9ca3af;
        }
    </style>
</head>

<body class="bg-gray-50 flex">
    <!-- Sidebar Include -->
    @include ('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 min-h-screen">
        <div class="max-w-7xl mx-auto p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-medium text-gray-800 flex items-center">
                    <i class="fa-solid fa-box-return text-gray-600 mr-3"></i>
                    Management Pengenbalian
                </h1>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="Search" placeholder="Search returns..."
                        class="pl-10 py-2 w-64 rounded-lg border border-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-300 shadow-sm"
                        onkeyup="searchPinjam()">
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Controls -->
                <div class="flex justify-between items-center p-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-700">Pengembalian</h3>
                    <div class="flex items-center space-x-2">
                        <label for="rows_per_page" class="text-sm text-gray-600">Rows:</label>
                        <select id="rows_per_page" class="rounded-md border-gray-200 text-sm text-gray-600" onchange="changeRowsPerPage()">
                            @php
                            $options = [];
                            for ($i = 5; $i < $totalRows; $i +=5) {
                                $options[]=$i;
                                }
                                if (!in_array($totalRows, $options)) {
                                $options[]=$totalRows;
                                }
                                @endphp
                                @foreach ($options as $option)
                                <option value="{{ $option }}" {{ request('rows') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barnag</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($kembalis as $kembali)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->pinjam->barang->nama_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->jumlah_kembali }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($kembali->gambar_barang)
                                    <img src="{{ asset('storage/' . $kembali->gambar_barang) }}" alt="Returned Item" class="w-12 h-12 object-cover rounded-md border border-gray-200">
                                    @else
                                    <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $kembali->pinjam->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('kembali.approve', $kembali->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-md transition duration-200 border border-green-200">
                                            Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($kembalis) == 0)
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-check-circle text-5xl mb-3 text-gray-300"></i>
                                        <p>Tidak ada permintaan</p>
                                        <p class="text-sm text-gray-400 mt-1">Semua permintaan sudah di proses</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                function searchPinjam() {
                    const input = document.getElementById('Search').value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const barangCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        if (barangCell.includes(input)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            </script>
</body>

</html>