<?php
namespace App\Exports;

use App\Models\Comment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommentsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $taskId;
    
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }
    
    public function query()
    {
        return Comment::with('user')
            ->where('task_id', $this->taskId);
    }
    
    public function headings(): array
    {
        return [
            'ID',
            'UUID',
            'Isi Komentar',
            'Internal',
            'Penulis',
            'Dibuat Pada'
        ];
    }
    
    public function map($comment): array
    {
        return [
            $comment->id,
            $comment->uuid,
            $comment->isi,
            $comment->internal ? 'Ya' : 'Tidak',
            $comment->user->name,
            $comment->created_at->format('d/m/Y H:i:s')
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}