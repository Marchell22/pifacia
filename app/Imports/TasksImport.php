<?php
namespace App\Imports;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class TasksImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable;
    
    protected $projectId;
    
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }
    
    public function model(array $row)
    {
        // Find user by name or leave null
        $user = null;
        if (isset($row['pic']) && !empty($row['pic'])) {
            $user = User::where('name', $row['pic'])->first();
        }
        
        // Map status string back to enum value
        $statusMap = [
            'Belum dimulai' => 'belum_dimulai',
            'Dalam proses' => 'dalam_proses',
            'Selesai' => 'selesai'
        ];
        
        $status = strtolower($row['status'] ?? '');
        $mappedStatus = $statusMap[$row['status']] ?? 'belum_dimulai';
        
        // Map priority string back to enum value
        $priorityMap = [
            'Rendah' => 'rendah',
            'Sedang' => 'sedang',
            'Tinggi' => 'tinggi'
        ];
        
        $priority = strtolower($row['prioritas'] ?? '');
        $mappedPriority = $priorityMap[$row['prioritas']] ?? 'sedang';
        
        return new Task([
            'judul' => $row['judul'],
            'deskripsi' => $row['deskripsi'] ?? null,
            'prioritas' => $mappedPriority,
            'status' => $mappedStatus,
            'deadline' => isset($row['deadline']) ? $this->transformDate($row['deadline']) : null,
            'selesai' => ($row['selesai'] ?? '') === 'Ya',
            'project_id' => $this->projectId,
            'user_id' => $user ? $user->id : null,
        ]);
    }
    
    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
        ];
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
    
    private function transformDate($value)
    {
        if (!$value) return null;
        
        try {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return Carbon::parse($value)->format('Y-m-d');
        }
    }
}