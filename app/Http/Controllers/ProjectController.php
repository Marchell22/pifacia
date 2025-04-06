<?php
// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use App\Imports\ProjectsImport;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Project::with('user');
        
        // Searching
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('aktif', $request->status == 'aktif');
        }
        
        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $projects = $query->paginate(10);
        
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif' => 'boolean',
            'user_id' => 'required|exists:users,id',
            'metadata' => 'nullable|json',
        ]);

        $metadata = $request->has('metadata') ? json_decode($request->metadata, true) : null;

        Project::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => $request->has('aktif'),
            'user_id' => $request->user_id,
            'metadata' => $metadata,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load(['user', 'tasks' => function($query) {
            $query->withCount('comments');
        }]);
        
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'aktif' => 'boolean',
            'user_id' => 'required|exists:users,id',
            'metadata' => 'nullable|json',
        ]);

        $metadata = $request->has('metadata') ? json_decode($request->metadata, true) : null;

        $project->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'aktif' => $request->has('aktif'),
            'user_id' => $request->user_id,
            'metadata' => $metadata,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        // Check if project has tasks
        if ($project->tasks()->count() > 0) {
            return redirect()->route('projects.index')
                ->with('error', 'Proyek tidak dapat dihapus karena masih memiliki tugas terkait.');
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
    
    public function audit(Project $project)
    {
        $audits = $project->audits()->with('user')->latest()->get();
        return view('projects.audit', compact('project', 'audits'));
    }
    
    public function export(Request $request) 
    {
        // Dispatch job ke queue
        ExportProjects::dispatch(auth()->id());

        return redirect()->route('projects.index')
            ->with('success', 'Ekspor proyek sedang diproses di latar belakang.');
    }
    
    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        // Simpan file
        $path = $request->file('file')->store('imports');

        // Dispatch job ke queue
        ImportProjects::dispatch($path, auth()->id());

        return redirect()->route('projects.index')
            ->with('success', 'Impor proyek sedang diproses di latar belakang.');
    }
}
