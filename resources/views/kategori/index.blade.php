<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .avatar-bg {
            background-color: #e5e7eb;
            color: #4b5563;
        }
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
                    <i class="fa-solid fa-tag text-gray-600 mr-3"></i>
                    Category Management
                </h1>
                <div class="flex items-center space-x-3">
                    <!-- Search Input -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="Search" placeholder="Search categories..." 
                               class="pl-10 py-2 w-64 rounded-lg border border-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-300 shadow-sm" 
                               onkeyup="searchKategori()">
                    </div>
                    <!-- Add Button -->
                    <button onclick="openModal()" class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-200 flex items-center shadow-sm">
                        <i class="fa-solid fa-plus mr-2"></i>Add Category
                    </button>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
            <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-gray-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Success</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Controls -->
                <div class="flex justify-between items-center p-4 border-b border-gray-100">
                    <h3 class="text-lg font-medium text-gray-700">Category List</h3>
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($kategoris as $kategori)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center avatar-bg">
                                            <span class="font-medium">{{ strtoupper(substr($kategori->nama_kategori, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4 font-medium text-gray-700">{{ $kategori->nama_kategori }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <!-- Edit Button -->
                                    <button onclick="editKategori({{ $kategori->id }})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center border border-gray-200">
                                        <i class="fas fa-edit mr-1.5"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-md transition duration-200 inline-flex items-center border border-gray-200">
                                            <i class="fas fa-trash-alt mr-1.5"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if(count($kategoris) == 0)
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-folder-open empty-state-icon text-5xl mb-3"></i>
                                        <p>No categories found</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 border border-gray-100">
                <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                    <h2 class="text-xl font-medium text-gray-800" id="modal-title">Add New Category</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition duration-150">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="kategori-form" action="{{ route('kategori.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="id" id="kategori-id" value="">

                        <div class="mb-4">
                            <label for="nama_kategori" class="block text-sm font-medium text-gray-600 mb-1">Category Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_kategori" id="nama_kategori"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300"
                                    placeholder="Enter category name" required>
                            </div>
                        </div>

                        <div class="flex justify-between mt-6 border-t border-gray-100 pt-4">
                            <button type="button" onclick="closeModal()"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 border border-gray-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i><span id="modal-action">Add Category</span>
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
                        document.getElementById('modal-title').innerText = 'Edit Category';
                        document.getElementById('modal-action').innerText = 'Update Category';
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

            function changeRowsPerPage() {
                let rowsPerPage = document.getElementById('rows_per_page').value;
                let url = new URL(window.location.href);
                url.searchParams.set('rows', rowsPerPage);
                window.location.href = url.toString();
            }
        </script>
</body>

</html>