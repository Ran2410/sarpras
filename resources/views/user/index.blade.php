<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8fafc;
        }
        .sidebar {
            background-color: #1f2937;
        }
        .avatar-bg {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .role-badge-admin {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .role-badge-user {
            background-color: #e5e7eb;
            color: #4b5563;
        }
        .pagination-link {
            color: #4b5563;
            border-color: #e5e7eb;
        }
        .pagination-link:hover {
            background-color: #e5e7eb;
        }
        .pagination-link-active {
            background-color: #4b5563;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar Include -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-medium text-gray-800">
                        <i class="fas fa-users mr-3 text-gray-600"></i>User Management
                    </h1>
                    <div class="flex items-center space-x-3">
                        <!-- Search Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" placeholder="Search users..." 
                                   class="pl-10 py-2 w-64 rounded-lg border border-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-300 shadow-sm" 
                                   onkeyup="searchUsers()">
                        </div>
                        <!-- Add User Button -->
                        <button onclick="openModal()" class="bg-gray-800 hover:bg-gray-700 text-white py-2 px-4 rounded-lg transition duration-200 flex items-center shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Add User
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

                <!-- User List Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-gray-100">
                    @php
                    $options = [];
                    for ($i = 5; $i < $totalRows; $i +=5) {
                        $options[]=$i;
                        }
                        if (!in_array($totalRows, $options)) {
                        $options[]=$totalRows;
                        }
                        @endphp
                        <div class="flex justify-between items-center p-4 border-b border-gray-100">
                        <label for="rows_per_page" class="text-sm text-gray-600">Rows per page:</label>
                        <select id="rows_per_page" class="form-select rounded-md border-gray-200 text-sm text-gray-600" onchange="changeRowsPerPage()">
                            @foreach ($options as $option)
                            <option value="{{ $option }}" {{ request('rows') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="min-w-full divide-y divide-gray-100" id="userTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Role</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center avatar-bg">
                                            <span class="font-medium">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4 font-medium text-gray-700">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full 
                                    {{ $user->role == 'admin' ? 'role-badge-admin' : 'role-badge-user' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <!-- Edit Button -->
                                    <button onclick="editUser({{ $user->id }})" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1 px-3 rounded-md transition duration-200 border border-gray-200">
                                        <i class="fas fa-edit mr-1"></i>
                                    </button>
                                    <!-- Delete Button -->
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                       <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-md transition duration-200">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="w-full flex justify-between mt-4">
                    {{ $users->appends([request('rows')])->links('vendor.pagination.custom') }}
                </div>

                <!-- Modal for Adding or Editing User -->
                <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden z-50">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 border border-gray-100">
                        <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                            <h2 class="text-xl font-medium text-gray-800" id="modal-title">Add New User</h2>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500 transition duration-150">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form id="user-form" action="{{ route('user.store') }}" method="POST" class="px-6 py-4">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" id="method" value="POST">
                            <input type="hidden" name="user_id" id="user_id">

                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input type="text" name="name" id="name"
                                            class="pl-10 block w-full border border-gray-200 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" id="email"
                                            class="pl-10 block w-full border border-gray-200 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            class="pl-10 block w-full border border-gray-200 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300"
                                            required>
                                    </div>
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-600 mb-1">Role</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user-tag text-gray-400"></i>
                                        </div>
                                        <select name="role" id="role"
                                            class="pl-10 block w-full border border-gray-200 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-gray-300 bg-white"
                                            required>
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between mt-6 border-t border-gray-100 pt-4">
                                <button type="button" onclick="closeModal()"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg border border-gray-200 transition duration-200">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition duration-200">
                                    <i class="fas fa-plus mr-2"></i><span id="modal-action">Add User</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    let currentPage = 1;
                    const rowsPerPage = 10;
                    const rows = document.querySelectorAll('#userTable tbody tr');
                    const totalPages = Math.ceil(rows.length / rowsPerPage);

                    function showPage(page) {
                        currentPage = page;
                        const start = (currentPage - 1) * rowsPerPage;
                        const end = start + rowsPerPage;

                        rows.forEach((row, index) => {
                            if (index >= start && index < end) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });

                        updatePagination();
                    }


                    window.onload = () => {
                        showPage(currentPage);
                    };

                    function openModal() {
                        document.getElementById('modal').classList.remove('hidden');
                    }

                    function closeModal() {
                        document.getElementById('modal').classList.add('hidden');
                        document.getElementById('user-form').reset();
                    }

                    function editUser(id) {
                        fetch(`/user/${id}/edit`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('name').value = data.name;
                                document.getElementById('email').value = data.email;
                                document.getElementById('role').value = data.role;
                                document.getElementById('password').value = '';

                                const form = document.getElementById('user-form');
                                form.action = `/user/${id}`;

                                document.getElementById('method').value = 'PUT';
                                document.getElementById('user_id').value = id;

                                document.getElementById('modal-title').textContent = 'Edit User';
                                document.getElementById('modal-action').textContent = 'Update User';

                                openModal();
                            })
                            .catch(error => console.error('Error fetching user data:', error));
                    }

                    function searchUsers() {
                        const searchTerm = document.getElementById('search').value.toLowerCase();
                        const rows = document.querySelectorAll('#userTable tbody tr');

                        rows.forEach(row => {
                            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                            if (name.includes(searchTerm) || email.includes(searchTerm)) {
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