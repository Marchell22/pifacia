<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Trail: Komentar') }}
            </h2>
            <a href="{{ route('tasks.show', $comment->task) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Detail Komentar</h3>
                    
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID:</p>
                            <p class="font-medium">{{ $comment->id }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">UUID:</p>
                            <p class="font-medium">{{ $comment->uuid }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tugas:</p>
                            <p class="font-medium">
                                <a href="{{ route('tasks.show', $comment->task) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $comment->task->judul }}
                                </a>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Penulis:</p>
                            <p class="font-medium">{{ $comment->user->name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Internal:</p>
                            <p class="font-medium">{{ $comment->internal ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Dibuat:</p>
                            <p class="font-medium">{{ $comment->created_at->format('d M Y H:i:s') }}</p>
                        </div>
                        
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600">Isi:</p>
                            <div class="mt-1 p-3 bg-gray-50 rounded-md">
                                {!! nl2br(e($comment->isi)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-4 mt-8">Riwayat Audit</h3>
                    
                    <x-audit-trail :audits="$audits" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>