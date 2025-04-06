<?php
namespace App\Jobs;

use App\Exports\CommentsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExportComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;
    protected $userId;

    public function __construct($taskId, $userId)
    {
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $fileName = 'comments_task_' . $this->taskId . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';
        Excel::store(new CommentsExport($this->taskId), 'exports/' . $fileName, 'public');
        
        // Notifikasi bisa ditambahkan di sini
    }
}
