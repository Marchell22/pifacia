<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Middleware\Authenticate;


{
    // Kode Anda
}
class DashboardController extends Controller
{
#[Authenticate]

    public function index()
    {
        $userCount = User::count();
        $roleCount = Role::count();
        
        // Tambahkan statistik lain sesuai dengan kebutuhan
        
        return view('dashboard', compact('userCount', 'roleCount'));
    }
}