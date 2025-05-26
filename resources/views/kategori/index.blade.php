<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <i class="fa-solid fa-tag text-blue-600 mr-3"></i>
                    Management Kategori
                </h1>
                <div class="flex items-center space-x-4">
                    <input type="text" id="Search" placeholder="Search" class="py-2 px-4 rounded-lg border border-gray-300 shadow-sm" onkeyup="searchKategori()">
                    <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition duration-200 flex items-center shadow-md">
                        <i class="fa-solid fa-plus mr-2"></i>Tambah Kategori
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
                <h3 class="text-lg font-medium text-gray-700">Data Kategori</h3>
            </div>

            <!-- List Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($kategoris as $kategori)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop-> iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">{{ strtoupper(substr($kategori->nama_kategori, 0, 2)) }}</span>
                                    </div>
                                    <div class="ml-4 font-medium text-gray-900">{{ $kategori->nama_kategori }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Edit Button -->
                                <button onclick="editKategori({{ $kategori->id }})" class="bg-amber-500 hover:bg-amber-600 text-white py-1.5 px-3 rounded-md mr-2 transition duration-200 inline-flex items-center">
                                    <i class="fas fa-edit mr-1.5"></i>Edit
                                </button>
                                <!-- Delete Button -->
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="bg-red-500 hover:bg-red-600 text-white py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center">
                                        <i class="fas fa-trash-alt mr-1.5"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        @if(count($kategoris) == 0)
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                                    <p>No categories found.</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800" id="modal-title">Add New Kategori</h2>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="kategori-form" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="id" id="kategori-id" value="">

                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input type="text" name="nama_kategori" id="nama_kategori"
                                class="block.\ w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter category name" required>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6 border-t border-gray-200 pt-4">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md border border-gray-300 transition duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md shadow-sm transition duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i><span id="modal-action">Add Kategori</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('kategori-form').reset();
        }

        function editKategori(id) {
            fetch(`/kategori/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('kategori-id').value = data.id;
                    document.getElementById('nama_kategori').value = data.nama_kategori;
                    document.getElementById('modal-title').innerText = 'Edit Kategori';
                    document.getElementById('modal-action').innerText = 'Update Kategori';
                    openModal();
                })
                .catch(error => console.error('Error fetching kategori:', error));
        }

        function searchKategori() {
            const input = document.getElementById('Search').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nameCell.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function sortAble(columIndex) {
            const table = document.getElementById('kategoriTable');
            const rows = Array.from(table.rows).slice(1);
            const sortedRow = rows.sort((a, b) => {
                const CellA = a.cels[columIndex].textContent.trim().toLowerCase();
                const CellB = b.cels[columIndex].textContent.trim().toLowerCase();

                if (cellA < cellB) return -1;
                if (cellA > cellB) return 1;
                return 0;
            })

            sortedRows.forEach(row => table.appendChild(row));
        }
    </script>
</body>

</html>