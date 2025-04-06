<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Tugas') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Tugas
                </a>
                <a href="{{ route('projects.show', $task->project) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Lihat Proyek
                </a>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Detail Tugas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Informasi Tugas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">ID:</p>
                            <p class="font-medium">{{ $task->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">UUID:</p>
                            <p class="font-medium">{{ $task->uuid }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Judul:</p>
                            <p class="font-medium">{{ $task->judul }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Proyek:</p>
                            <p class="font-medium">
                                <a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $task->project->nama }}
                                </a>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">PIC:</p>
                            <p class="font-medium">{{ $task->user ? $task->user->name : 'Belum ditugaskan' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Prioritas:</p>
                            <p class="font-medium">
                                @if($task->prioritas === 'tinggi')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Tinggi
                                    </span>
                                @elseif($task->prioritas === 'sedang')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Sedang
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Rendah
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Status:</p>
                            <p class="font-medium">
                                @if($task->status === 'selesai')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif($task->status === 'dalam_proses')
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Dalam Proses
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Belum Dimulai
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Deadline:</p>
                            <p class="font-medium">{{ $task->deadline ? $task->deadline->format('d M Y') : 'Belum ditentukan' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Lampiran:</p>
                            <p class="font-medium">
                                @if($task->lampiran)
                                    <a href="{{ route('tasks.download', $task) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        Unduh Lampiran
                                    </a>
                                @else
                                    <span class="text-gray-500">Tidak ada lampiran</span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Selesai:</p>
                            <p class="font-medium">{{ $task->selesai ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Dibuat:</p>
                            <p class="font-medium">{{ $task->created_at->format('d M Y H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Deskripsi:</p>
                        <div class="mt-1 p-3 bg-gray-50 rounded-md">
                            {!! nl2br(e($task->deskripsi ?? 'Tidak ada deskripsi')) !!}
                        </div>
                    </div>
                    
                    @if($task->metadata)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Metadata:</p>
                        <pre class="mt-1 bg-gray-100 p-3 rounded text-sm overflow-x-auto">{{ json_encode($task->metadata, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                    
                    <div class="flex space-x-3 mt-6">
                        <a href="{{ route('tasks.audit', $task) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Lihat Audit
                        </a>
                        
                        <button onclick="document.getElementById('comment-export-import-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration 150">
                            Export/Import Komentar
                        </button>
                    </div>
                    
                    <!-- Comment Export/Import Modal -->
                    <div id="comment-export-import-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 md:flex items-center justify-center z-50">
                        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Export/Import Data Komentar</h3>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Export Data</h4>
                                    <p class="text-sm text-gray-500 mb-2">Download data komentar dalam format Excel</p>
                                    <a href="{{ route('comments.export', $task) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 transition ease-in-out duration-150">
                                        Export Excel
                                    </a>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Import Data</h4>
                                    <p class="text-sm text-gray-500 mb-2">Upload data komentar dari file Excel</p>
                                    <form action="{{ route('comments.import', $task) }}" method="POST" enctype="multipart/form-data">
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
                                <button type="button" onclick="document.getElementById('comment-export-import-modal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Komentar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Komentar</h3>
                    
                    <div class="mb-6">
                        <form method="POST" action="{{ route('comments.store', $task) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="isi" class="block text-sm font-medium text-gray-700">Tambahkan Komentar</label>
                                <textarea name="isi" id="isi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Tulis komentar Anda di sini..." required>{{ old('isi') }}</textarea>
                                @error('isi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="internal" id="internal" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="1" {{ old('internal') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="internal" class="font-medium text-gray-700">Komentar Internal</label>
                                        <p class="text-gray-500">Centang jika komentar ini hanya untuk tim internal</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($task->comments->sortByDesc('created_at') as $comment)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center">
                                        <div class="font-semibold text-indigo-700">{{ $comment->user->name }}</div>
                                        @if($comment->internal)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Internal
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <div class="text-gray-700">
                                    {!! nl2br(e($comment->isi)) !!}
                                </div>
                                @if($comment->user_id === auth()->id())
                                <div class="mt-2 flex justify-end space-x-2 text-sm">
                                    <a href="{{ route('comments.edit', $comment) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500">
                                Belum ada komentar untuk tugas ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>