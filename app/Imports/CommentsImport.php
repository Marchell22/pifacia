<?php
// app/Imports/CommentsImport.php
namespace App\Imports;

use App\Models\Comment;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;

class CommentsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable;
    
    protected $taskId;
    
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }
    
    public function model(array $row)
    {
        // Find user by name or use current user
        $user = null;
        if (isset($row['penulis']) && !empty($row['penulis'])) {
            $user = User::where('name', $row['penulis'])->first();
        }
        
        if (!$user) {
            $user = Auth::user();
        }
        
        return new Comment([
            'isi' => $row['isi_komentar'],
            'internal' => ($row['internal'] ?? '') === 'Ya',
            'task_id' => $this->taskId,
            'user_id' => $user->id,
        ]);
    }
    
    public function rules(): array
    {
        return [
            'isi_komentar' => 'required|string',
        ];
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
}