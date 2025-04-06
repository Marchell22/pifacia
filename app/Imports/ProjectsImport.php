<?php
namespace App\Imports;

use App\Models\Project;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Carbon\Carbon;

class ProjectsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading
{
    use Importable;
    
    public function model(array $row)
    {
        // Find user by name or use the first admin
        $user = User::where('name', $row['pic'])->first();
        if (!$user) {
            $user = User::whereHas('role', function($query) {
                $query->where('name', 'Administrator');
            })->first();
        }
        
        return new Project([
            'nama' => $row['nama_proyek'],
            'deskripsi' => $row['deskripsi'],
            'tanggal_mulai' => $this->transformDate($row['tanggal_mulai']),
            'tanggal_selesai' => isset($row['tanggal_selesai']) ? $this->transformDate($row['tanggal_selesai']) : null,
            'aktif' => $row['status'] === 'Aktif',
            'user_id' => $user->id,
        ]);
    }
    
    public function rules(): array
    {
        return [
            'nama_proyek' => 'required|string|max:255',
            'tanggal_mulai' => 'required',
        ];
    }
    
    public function chunkSize(): int
    {
        return 100;
    }
    
    private function transformDate($value)
    {
        try {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return Carbon::parse($value)->format('Y-m-d');
        }
    }
}