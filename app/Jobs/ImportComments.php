<?php
namespace App\Jobs;

use App\Imports\CommentsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportComments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $taskId;
    protected $userId;

    public function __construct($filePath, $taskId, $userId)
    {
        $this->filePath = $filePath;
        $this->taskId = $taskId;
        $this->userId = $userId;
    }

    public function handle()
    {
        Excel::import(new CommentsImport($this->taskId), storage_path('app/' . $this->filePath));
        
        // Notifikasi bisa ditambahkan di sini
    }
}