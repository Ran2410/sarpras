<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Barang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex">

    <!-- Sidebar Include -->
    @include ('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 min-h-screen">
        <div class="max-w-7xl mx-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                    <i class="fa-solid fa-box text-blue-600 mr-3"></i>
                    Management Pengembalian Barang
                </h1>
                <div class="flex items-center space-x-4">
                    <input type="text" id="Search" placeholder="Search" class="py-2 px-4 rounded-lg border border-gray-300 shadow-sm" onkeyup="searchPinjam()">
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="font-bold">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Table Card -->
            <div class="rounded-lg shadow-sm overflow-hidden">
                @php
                $options = [];
                for ($i = 5; $i < $totalRows; $i +=5) {
                    $options[]=$i;
                    }
                    if (!in_array($totalRows, $options)) {
                    $options[]=$totalRows;
                    }
                    @endphp
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center mb-4">
                        <label for="rows_per_page" class="text-sm">Show rows:</label>
                        <select id="rows_per_page" class="form-select rounded-md border-gray-300 text-sm" onchange="changeRowsPerPage()">
                            @foreach ($options as $option)
                            <option value="{{ $option }}" {{ request('rows') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <h3 class="text-lg font-medium text-gray-700">Data Pengembalian Barang</h3>
            </div>

            <!-- List Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kembali</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Di Konfirmasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kembalis as $kembali)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->pinjam->barang->nama_barang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kembali->jumlah_kembali }}</td>
                            <td class="px-6 py-4 whitespace nowrap">
                                @if($kembali->gambar_barang)
                                <img src="{{ asset('storage/' . $kembali->gambar_barang) }}" alt="Image" class="w-12 h-12 object-cover rounded-md">
                                @else
                                <span class="text-gray-500">No Image</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($kembali->handledBy)
                                {{ $kembali->handledBy->name }}
                                @else
                                <span class="text-gray-500">Not Confirmed</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $kembali->pinjam->user->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($kembali->status)
                                <span class="text-green-500">Disetujui</span>
                                @else
                                <span class="text-yellow-500">Menunggu Persetujuan</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(!$kembali->status)
                                <form action="{{ route('kembali.approve', $kembali->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md mr-2 transition duration-200">Approve</button>
                                </form>
                                @else
                                <span class="text-gray-500">Approved</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if(count($kembalis) == 0)
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-box-open text-gray-300 text-5xl mb-3"></i>
                                    <p>No return requests found.</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="w-full flex justify-between mt-4">
            {{ $kembalis->links('vendor.pagination.custom') }}
        </div>

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

        function changeRowsPerPage() {
            let rowsPerPage = document.getElementById('rows_per_page').value;
            let url = new URL(window.location.href);
            url.searchParams.set('rows', rowsPerPage);
            window.location.href = url.toString();
        }
    </script>
</body>

</html>