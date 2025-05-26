<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <body class="bg-gray-50 flex">
        <!-- Sidebar Include -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 min-h-screen">
            <div class="max-w-7xl mx-auto p-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                        <i class="fa-solid fa-box text-blue-600 mr-3"></i>
                        Management Barang
                    </h1>
                    <div class="flex items-center space-x-2">
                        <input type="text" id="Search" placeholder="Search" class="py-2 px-4 rounded-lg border border-gray-300 shadow-sm" onkeyup="searchBarang()">
                        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200 flex items-center shadow-md">
                            <i class="fa-solid fa-plus mr-2"></i>Tambah Barang
                        </button>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('success'))
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
                <div class="rounded-lg shadow sm-overflow">
                    @php
                    $options = [];
                    for ($i = 5; $i < $totalRows; $i +=5) {
                        $options[]=$i;
                        }
                        if (!in_array($totalRows, $options)) {
                        $options[]=$totalRows;
                        }
                        @endphp

                        <div class="flex justify-between items-center mb-4">
                        <label for="rows_per_page" class="text-sm">Show rows:</label>
                        <select id="rows_per_page" class="form-select rounded-md border-gray-300 text-sm" onchange="changeRowsPerPage()">
                            @foreach ($options as $option)
                            <option value="{{ $option }}" {{ request('rows') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                </div>
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Data Barang</h3>
                </div>

                <!-- List Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($barangs as $barang)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop -> iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-medium">{{ strtoupper(substr($barang->nama_barang, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4 font-medium text-gray-900">{{ $barang->nama_barang }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($barang->stok_barang, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $barang->kategori->nama_kategori }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($barang->image_barang)
                                    <img src="{{ asset('storage/' . $barang->image_barang) }}" alt="{{ $barang->nama_barang }}" class="w-12 h-12 object-cover rounded-md">
                                    @else
                                    <span class="text-gray-500">No image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- Edit Button -->
                                    <button onclick="editBarang({{ $barang->id }})" class="bg-amber-500 hover:bg-amber-600 text-white py-1.5 px-3 rounded-md mr-2 transition duration-200 inline-flex items-center">
                                        <i class="fas fa-edit mr-1.5"></i>Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-600 text-white py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center">
                                            <i class="fas fa-trash-alt mr-1.5"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($barangs) == 0)
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                                        <p>No barang found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="w-full flex justify-beetwenmt-4">
                {{ $barangs->appends([request('rows')])->links('vendor.pagination.custom') }}
            </div>

                <!-- Modal for adding barang -->
                <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
                    <div class="bg-white rounded-lg p-6 w-full sm:w-96">
                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" id="barang-form">
                            @csrf
                            <div class="mb-4">
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" class="block w-full pl-3 pr-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="stok_barang" class="block text-sm font-medium text-gray-700 mb-1">Stok Barang</label>
                                <input type="number" name="stok_barang" id="stok_barang" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="image_barang" class="block text-sm font-medium text-gray-700 mb-1">Image Barang</label>
                                <input type="file" name="image_barang" id="image_barang" class="block w-full py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                            </div>

                            <div class="mb-4">
                                <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori Barang</label>
                                <select name="kategori_id" id="kategori_id" class="block w-full pl-3 pr-10 py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-between mt-6 border-t border-gray-200 pt-4">
                                <button type="button" onclick="closeModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md border border-gray-300 transition duration-200">Cancel</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition duration-200 flex items-center">
                                    <i class="fas fa-plus mr-2"></i><span id="modal-action">Add Barang</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    function openModal() {
                        document.getElementById('modal').classList.remove('hidden');
                    }

                    function closeModal() {
                        document.getElementById('modal').classList.add('hidden');
                        document.getElementById('barang-form').reset();
                    }

                    function editBarang(id) {
                        fetch(`/barang/${id}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('nama_barang').value = data.nama_barang;
                                document.getElementById('stok_barang').value = data.stok_barang;
                                document.getElementById('kategori_id').value = data.kategori_id;
                                document.getElementById('modal-action').innerText = 'Update Barang';
                                document.getElementById('barang-form').action = `/barang/${id}`;
                                document.getElementById('barang-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';
                                openModal();
                            });
                    }

                    function searchBarang() {
                        const input = document.getElementById('Search');
                        const filter = input.value.toLowerCase();
                        const rows = document.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const cells = row.querySelectorAll('td');
                            let found = false;

                            cells.forEach(cell => {
                                if (cell.innerText.toLowerCase().includes(filter)) {
                                    found = true;
                                }
                            });

                            if (found) {
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