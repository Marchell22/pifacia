<?php
namespace App\Jobs;

use App\Imports\TasksImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $projectId;
    protected $userId;

    public function __construct($filePath, $projectId, $userId)
    {
        $this->filePath = $filePath;
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    public function handle()
    {
        Excel::import(new TasksImport($this->projectId), storage_path('app/' . $this->filePath));
        
        // Notifikasi bisa ditambahkan di sini
    }
}
