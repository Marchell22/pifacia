<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Role') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Role
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filters -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('roles.index') }}" class="flex flex-wrap gap-4 items-end">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" name="search" id="search" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Cari role..." value="{{ request('search') }}">
                            </div>
                            
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <select name="sort" id="sort" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Tanggal Pembuatan</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="direction" class="block text-sm font-medium text-gray-700 mb-1">Arah</label>
                                <select name="direction" id="direction" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Naik</option>
                                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Turun</option>
                                </select>
                            </div>
                            
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Filter
                                </button>
                                <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Pengguna</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Dibuat</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $role->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $role->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $role->description ?? 'Tidak ada deskripsi' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $role->users_count ?? $role->users()->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $role->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('roles.edit', $role) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="{{ route('roles.audit', $role) }}" class="text-blue-600 hover:text-blue-900">Audit</a>
                                            
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center text-gray-500">
                                        Tidak ada data role yang tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $roles->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>