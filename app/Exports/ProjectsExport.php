<?php
// app/Exports/ProjectsExport.php
namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Project::with('user')->get();
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Nama Proyek',
            'Deskripsi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'PIC',
            'Dibuat Pada'
        ];
    }
    
    public function map($project): array
    {
        return [
            $project->id,
            $project->uuid,
            $project->nama,
            $project->deskripsi,
            $project->tanggal_mulai->format('d/m/Y'),
            $project->tanggal_selesai ? $project->tanggal_selesai->format('d/m/Y') : 'Belum ditentukan',
            $project->aktif ? 'Aktif' : 'Non-aktif',
            $project->user ? $project->user->name : 'Tidak ada',
            $project->created_at->format('d/m/Y H:i:s')
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}