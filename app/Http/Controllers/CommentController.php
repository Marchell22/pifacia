<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CommentsExport;
use App\Imports\CommentsImport;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'isi' => 'required|string',
            'internal' => 'boolean',
        ]);
        
        Comment::create([
            'isi' => $request->isi,
            'internal' => $request->has('internal'),
            'task_id' => $task->id,
            'user_id' => Auth::id(),
        ]);
        
        return redirect()->route('tasks.show', $task)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }
    
    public function edit(Comment $comment)
    {
        // Only the author can edit their comment
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }
        
        return view('comments.edit', compact('comment'));
    }
    
    public function update(Request $request, Comment $comment)
    {
        // Only the author can update their comment
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah komentar ini.');
        }
        
        $request->validate([
            'isi' => 'required|string',
            'internal' => 'boolean',
        ]);
        
        $comment->update([
            'isi' => $request->isi,
            'internal' => $request->has('internal'),
        ]);
        
        return redirect()->route('tasks.show', $comment->task)
            ->with('success', 'Komentar berhasil diperbarui.');
    }
    
    public function destroy(Comment $comment)
    {
        // Only the author or admin can delete the comment
        if ($comment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }
        
        $task = $comment->task;
        $comment->delete();
        
        return redirect()->route('tasks.show', $task)
            ->with('success', 'Komentar berhasil dihapus.');
    }
    
    public function audit(Comment $comment)
    {
        $audits = $comment->audits()->with('user')->latest()->get();
        return view('comments.audit', compact('comment', 'audits'));
    }
    
    public function export(Request $request, Task $task) 
    {
        // Dispatch job ke queue
        ExportComments::dispatch($task->id, auth()->id());

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Ekspor komentar sedang diproses di latar belakang.');
    }
    
    public function import(Request $request, Task $task) 
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);
        
        // Simpan file
        $path = $request->file('file')->store('imports');
        
        // Dispatch job ke queue
        ImportComments::dispatch($path, $task->id, auth()->id());
        
        return redirect()->route('tasks.show', $task)
            ->with('success', 'Impor komentar sedang diproses di latar belakang.');
    }
}