<?php
// app/Jobs/ExportProjects.php
namespace App\Jobs;

use App\Exports\ProjectsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExportProjects implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $fileName = 'projects_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        Excel::store(new ProjectsExport, 'exports/' . $fileName, 'public');
        
        // Notifikasi bisa ditambahkan di sini (misalnya: email, database, dll)
    }
}

// app/Jobs/ImportProjects.php
namespace App\Jobs;

use App\Imports\ProjectsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjects implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;

    public function __construct($filePath, $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    public function handle()
    {
        Excel::import(new ProjectsImport, storage_path('app/' . $this->filePath));
        
        // Notifikasi bisa ditambahkan di sini
    }
}
