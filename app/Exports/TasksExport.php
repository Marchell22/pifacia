<?php
namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TasksExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $projectId;
    
    public function __construct($projectId = null)
    {
        $this->projectId = $projectId;
    }
    
    public function query()
    {
        $query = Task::with(['project', 'user']);
        
        if ($this->projectId) {
            $query->where('project_id', $this->projectId);
        }
        
        return $query;
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Proyek',
            'Judul',
            'Deskripsi',
            'Prioritas',
            'Status',
            'Deadline',
            'Selesai',
            'PIC',
            'Dibuat Pada'
        ];
    }
    
    public function map($task): array
    {
        return [
            $task->id,
            $task->uuid,
            $task->project->nama,
            $task->judul,
            $task->deskripsi,
            ucfirst($task->prioritas),
            str_replace('_', ' ', ucfirst($task->status)),
            $task->deadline ? $task->deadline->format('d/m/Y') : 'Belum ditentukan',
            $task->selesai ? 'Ya' : 'Tidak',
            $task->user ? $task->user->name : 'Belum ditugaskan',
            $task->created_at->format('d/m/Y H:i:s')
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}