<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Proyek') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Proyek
                </a>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Tambah Tugas
                </a>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Detail Proyek -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Proyek</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID:</p>
                            <p class="font-medium">{{ $project->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">UUID:</p>
                            <p class="font-medium">{{ $project->uuid }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Nama:</p>
                            <p class="font-medium">{{ $project->nama }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">PIC:</p>
                            <p class="font-medium">{{ $project->user->name ?? 'Tidak ada' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Mulai:</p>
                            <p class="font-medium">{{ $project->tanggal_mulai->format('d M Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Selesai:</p>
                            <p class="font-medium">{{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d M Y') : 'Belum ditentukan' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Status:</p>
                            <p class="font-medium">
                                @if($project->aktif)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Non-aktif
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Dibuat Pada:</p>
                            <p class="font-medium">{{ $project->created_at->format('d M Y H:i:s') }}</p>
                        </div>
                        
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Deskripsi:</p>
                            <p class="font-medium">{{ $project->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                        
                        @if($project->metadata)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Metadata:</p>
                            <pre class="bg-gray-100 p-3 rounded text-sm overflow-x-auto">{{ json_encode($project->metadata, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Daftar Tugas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Tugas</h3>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambah Tugas
                            </a>
                            
                            <button onclick="document.getElementById('task-export-import-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Export/Import
                            </button>
                        </div>
                    </div>
                    
                    <!-- Task Export/Import Modal -->
                    <div id="task-export-import-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 md:flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Export/Import Data Tugas Proyek</h3>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Export Data</h4>
                                    <p class="text-sm text-gray-500 mb-2">Download data tugas proyek dalam format Excel</p>
                                    <a href="{{ route('tasks.export', ['project_id' => $project->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 transition ease-in-out duration-150">
                                        Export Excel
                                    </a>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Import Data</h4>
                                    <p class="text-sm text-gray-500 mb-2">Upload data tugas proyek dari file Excel</p>
                                    <form action="{{ route('tasks.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
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
                                <button type="button" onclick="document.getElementById('task-export-import-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioritas</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deadline</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PIC</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Komentar</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($project->tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $task->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $task->judul }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        @if($task->prioritas === 'tinggi')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Tinggi
                                            </span>
                                        @elseif($task->prioritas === 'sedang')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Sedang
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Rendah
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        @if($task->status === 'selesai')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @elseif($task->status === 'dalam_proses')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Dalam Proses
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Belum Dimulai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        {{ $task->deadline ? $task->deadline->format('d M Y') : 'Belum ditentukan' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        {{ $task->user ? $task->user->name : 'Belum ditugaskan' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        {{ $task->comments_count ?? $task->comments->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center text-gray-500">
                                        Tidak ada tugas yang tersedia untuk proyek ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>