<?php
namespace App\Jobs;

use App\Exports\TasksExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExportTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $projectId;
    protected $userId;

    public function __construct($projectId, $userId)
    {
        $this->projectId = $projectId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $fileName = 'tasks_' . ($this->projectId ? 'project_' . $this->projectId . '_' : '') . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        Excel::store(new TasksExport($this->projectId), 'exports/' . $fileName, 'public');
        
        // Notifikasi bisa ditambahkan di sini
    }
}
