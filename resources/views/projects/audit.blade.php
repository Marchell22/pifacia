<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Audit Trail: ') }} {{ $project->nama }}
            </h2>
            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Detail Proyek</h3>
                    
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <p class="font-medium">{{ $project->aktif ? 'Aktif' : 'Non-aktif' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Dibuat Pada:</p>
                            <p class="font-medium">{{ $project->created_at->format('d M Y H:i:s') }}</p>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-semibold mb-4 mt-8">Riwayat Audit</h3>
                    
                    <x-audit-trail :audits="$audits" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>