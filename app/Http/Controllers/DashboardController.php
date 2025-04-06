<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userCount = User::count();
        $roleCount = Role::count();
        
        // Tambahkan statistik lain sesuai dengan kebutuhan
        
        return view('dashboard', compact('userCount', 'roleCount'));
    }
}