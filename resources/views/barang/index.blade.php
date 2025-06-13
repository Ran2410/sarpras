<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar Include -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                            <span class="bg-gray-100 p-2 rounded-lg mr-3">
                                <i class="fa-solid fa-box text-gray-600"></i>
                            </span>
                            Management Barang
                        </h1>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                        <div class="relative">
                            <input type="text" id="Search" placeholder="Search barang..."
                                class="py-2 pl-10 pr-4 w-full sm:w-64 rounded-lg border border-gray-200 focus:border-gray-300 focus:ring-1 focus:ring-gray-200 transition duration-200 text-sm"
                                onkeyup="searchBarang()">
                            <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                        </div>
                        <button onclick="openAddModal()"
                            class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-plus mr-2"></i>Tambah Barang
                        </button>
                    </div>
                </div>

                <!-- Success Alert -->
                @if (session('success'))
                <div class="bg-gray-50 border-l-4 border-gray-500 p-4 mb-6 rounded-md shadow-sm flex items-start" role="alert">
                    <i class="fas fa-check-circle text-gray-500 mt-1 mr-3"></i>
                    <div>
                        <p class="font-medium text-gray-800">Success</p>
                        <p class="text-sm text-gray-600">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- Table Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @php
                    $options = [];
                    for ($i = 5; $i < $totalRows; $i +=5) {
                        $options[]=$i;
                        }
                        if (!in_array($totalRows, $options)) {
                        $options[]=$totalRows;
                        }
                        @endphp
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-gray-700 mb-2 sm:mb-0">Data Barang</h3>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500">Show:</span>
                            <select id="rows_per_page" onchange="changeRowsPerPage()"
                                class="text-sm rounded-lg border-gray-200 focus:border-gray-300 focus:ring-1 focus:ring-gray-200 transition duration-200">
                                @foreach ($options as $option)
                                <option value="{{ $option }}" {{ request('rows') == $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($barangs as $barang)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="avatar h-10 w-10 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-600 font-medium">{{ strtoupper(substr($barang->nama_barang, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $barang->nama_barang }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ number_format($barang->stok_barang, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $barang->kategori->nama_kategori }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($barang->image_barang)
                                    <img src="{{ asset('storage/' . $barang->image_barang) }}" alt="{{ $barang->nama_barang }}"
                                        class="w-10 h-10 object-cover rounded-md border border-gray-200">
                                    @else
                                    <span class="text-gray-400 text-sm">No image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <button onclick="openEditModal({{ $barang->id }})"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center border border-gray-200">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center border border-gray-200">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($barangs) == 0)
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <i class="fas fa-box-open text-4xl mb-3"></i>
                                        <p class="text-sm">No barang found</p>
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
                {{ $barangs->appends([request('rows')])->links('vendor.pagination.custom') }}
            </div>
    </div>
    </main>
    </div>

    <!-- Add Modal -->
    <div id="add-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md modal-enter">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-800">Tambah Barang</h3>
            </div>
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" id="add-barang-form">
                @csrf
                <div class="p-5 space-y-4">
                    <div>
                        <label for="add-nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" id="add-nama_barang"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                    </div>

                    <div>
                        <label for="add-stok_barang" class="block text-sm font-medium text-gray-700 mb-1">Stok Barang</label>
                        <input type="number" name="stok_barang" id="add-stok_barang"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                    </div>

                    <div>
                        <label for="add-image_barang" class="block text-sm font-medium text-gray-700 mb-1">Gambar Barang</label>
                        <input type="file" name="image_barang" id="add-image_barang"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition duration-200">
                    </div>

                    <div>
                        <label for="add-kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_id" id="add-kategori_id"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-100 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md modal-enter">
            <div class="p-5 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-800">Edit Barang</h3>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="edit-barang-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-barang-id">
                <div class="p-5 space-y-4">
                    <div>
                        <label for="edit-nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" id="edit-nama_barang"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                    </div>

                    <div>
                        <label for="edit-stok_barang" class="block text-sm font-medium text-gray-700 mb-1">Stok Barang</label>
                        <input type="number" name="stok_barang" id="edit-stok_barang"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                    </div>

                    <div>
                        <label for="edit-image_barang" class="block text-sm font-medium text-gray-700 mb-1">Gambar   Barang</label>
                        <input type="file" name="image_barang" id="edit-image_barang"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition duration-200">
                        <div class="mt-2" id="current-image-container"></div>
                    </div>

                    <div>
                        <label for="edit-kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori_id" id="edit-kategori_id"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-gray-200 focus:border-gray-300 transition duration-200 text-sm">
                            @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-5 border-t border-gray-100 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('add-modal').classList.remove('hidden');
            document.getElementById('add-barang-form').reset();
        }

        function closeAddModal() {
            document.getElementById('add-modal').classList.add('hidden');
        }

        function openEditModal(id) {
            fetch(`/barang/${id}/edit`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data);

                    document.getElementById('edit-barang-id').value = data.id;
                    document.getElementById('edit-nama_barang').value = data.nama_barang || '';
                    document.getElementById('edit-stok_barang').value = data.stok_barang || 0;
                    document.getElementById('edit-kategori_id').value = data.kategori_id || '';

                    const imageContainer = document.getElementById('current-image-container');
                    imageContainer.innerHTML = data.image_barang ?
                        `<img src="/storage/${data.image_barang}" class="w-20 h-20 object-cover rounded-md">` :
                        '<p class="text-gray-500">No image</p>';

                    document.getElementById('edit-barang-form').action = `/barang/${data.id}`;
                    document.getElementById('edit-modal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data barang');
                });
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function searchBarang() {
            const input = document.getElementById('Search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (row.querySelector('.fa-box-open')) return;

                const cells = row.querySelectorAll('td');
                let found = false;

                for (let i = 0; i < cells.length - 1; i++) {
                    const cell = cells[i];
                    if (cell.innerText.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            });

            const noResultsRow = document.querySelector('tbody tr:first-child');
            if (noResultsRow && noResultsRow.querySelector('.fa-box-open')) {
                const anyVisible = Array.from(rows).some(row => row.style.display !== 'none');
                noResultsRow.style.display = anyVisible ? 'none' : '';
            }
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