<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Proyek') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Tambah Proyek
                </a>
                
                <button onclick="document.getElementById('export-import-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Export/Import
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Export/Import Modal -->
            <div id="export-import-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 md:flex items-center justify-center z-50">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Export/Import Data Proyek</h3>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Export Data</h4>
                            <p class="text-sm text-gray-500 mb-2">Download data proyek dalam format Excel</p>
                            <a href="{{ route('projects.export') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 transition ease-in-out duration-150">
                                Export Excel
                            </a>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Import Data</h4>
                            <p class="text-sm text-gray-500 mb-2">Upload data proyek dari file Excel</p>
                            <form action="{{ route('projects.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="flex items-end space-x-2">
                                    <div class="flex-grow">
                                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Pilih File Excel</label>
                                        <input type="file" name="file" id="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                                        <small class="text-gray-500">Format: XLSX, XLS (max 2MB)</small>
                                    </div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition ease-in-out duration-150">
                                        Import
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="document.getElementById('export-import-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filters -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('projects.index') }}" class="flex flex-wrap gap-4 items-end">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                                <input type="text" name="search" id="search" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Cari proyek..." value="{{ request('search') }}">
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Semua Status</option>
                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                                <select name="sort" id="sort" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                                    <option value="tanggal_mulai" {{ request('sort') == 'tanggal_mulai' ? 'selected' : '' }}>Tanggal Mulai</option>
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
                                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
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
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PIC</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $project->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $project->nama }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $project->tanggal_mulai->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d M Y') : 'Belum ditentukan' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $project->user->name ?? 'Tidak ada' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        @if($project->aktif)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Non-aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <a href="{{ route('projects.audit', $project) }}" class="text-purple-600 hover:text-purple-900">Audit</a>
                                            
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center text-gray-500">
                                        Tidak ada data proyek yang tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $projects->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>