<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TasksExport;
use App\Imports\TasksImport;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $query = Task::with(['project', 'user']);
        
        // Searching
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by project
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        
        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $tasks = $query->paginate(10);
        $projects = Project::where('aktif', true)->get();
        
        return view('tasks.index', compact('tasks', 'projects'));
    }
    
    public function create(Request $request)
    {
        $projects = Project::where('aktif', true)->get();
        $users = User::all();
        $projectId = $request->project_id;
        
        return view('tasks.create', compact('projects', 'users', 'projectId'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:belum_dimulai,dalam_proses,selesai',
            'deadline' => 'nullable|date',
            'selesai' => 'boolean',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'lampiran' => 'nullable|file|mimes:pdf|between:100,500', // 100KB to 500KB
        ]);
        
        $data = $request->except('lampiran');
        $data['selesai'] = $request->has('selesai');
        
        // Handle file upload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/lampiran', $fileName);
            $data['lampiran'] = $fileName;
        }
        
        Task::create($data);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dibuat.');
    }
    
    public function show(Task $task)
    {
        $task->load(['project', 'user', 'comments.user']);
        
        return view('tasks.show', compact('task'));
    }
    
    public function edit(Task $task)
    {
        $projects = Project::where('aktif', true)->get();
        $users = User::all();
        
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }
    
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'status' => 'required|in:belum_dimulai,dalam_proses,selesai',
            'deadline' => 'nullable|date',
            'selesai' => 'boolean',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'lampiran' => 'nullable|file|mimes:pdf|between:100,500', // 100KB to 500KB
        ]);
        
        $data = $request->except('lampiran');
        $data['selesai'] = $request->has('selesai');
        
        // Handle file upload
        if ($request->hasFile('lampiran')) {
            // Delete old file if exists
            if ($task->lampiran) {
                Storage::delete('public/lampiran/' . $task->lampiran);
            }
            
            $file = $request->file('lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/lampiran', $fileName);
            $data['lampiran'] = $fileName;
        }
        
        $task->update($data);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil diperbarui.');
    }
    
    public function destroy(Task $task)
    {
        // Check if task has comments
        if ($task->comments()->count() > 0) {
            return redirect()->route('tasks.index')
                ->with('error', 'Tugas tidak dapat dihapus karena masih memiliki komentar terkait.');
        }
        
        // Delete file if exists
        if ($task->lampiran) {
            Storage::delete('public/lampiran/' . $task->lampiran);
        }
        
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }
    
    public function audit(Task $task)
    {
        $audits = $task->audits()->with('user')->latest()->get();
        return view('tasks.audit', compact('task', 'audits'));
    }
    
    public function downloadLampiran(Task $task)
    {
        if (!$task->lampiran) {
            abort(404, 'Lampiran tidak ditemukan');
        }
        
        return Storage::download('public/lampiran/' . $task->lampiran);
    }
    
    public function export(Request $request) 
    {
        $projectId = $request->project_id;

        // Dispatch job ke queue
        ExportTasks::dispatch($projectId, auth()->id());

        return redirect()->route('tasks.index')
            ->with('success', 'Ekspor tugas sedang diproses di latar belakang.');
    }
    
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
            'project_id' => 'required|exists:projects,id'
        ]);
        
        // Simpan file
        $path = $request->file('file')->store('imports');
        
        // Dispatch job ke queue
        ImportTasks::dispatch($path, $request->project_id, auth()->id());
        
        return redirect()->route('tasks.index')
            ->with('success', 'Impor tugas sedang diproses di latar belakang.');
    }
}