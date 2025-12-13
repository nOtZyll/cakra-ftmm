<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'ormawa'])
            ->where('user_id', '!=', value: Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $roles = Role::where('role_name', '!=', 'admin')->get();
        $ormawas = Ormawa::all();

        return view('admin.users.index', compact('users', 'roles', 'ormawas'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $stafOrmawaId = 2; 
        $request->validate([
            'role_id' => 'required|exists:roles,role_id',
            'ormawa_id' => $request->role_id == $stafOrmawaId ? 'required|exists:ormawa,ormawa_id' : 'nullable',
        ]);

        $user->role_id = $request->role_id;
        if ($request->role_id == $stafOrmawaId) {
            $user->ormawa_id = $request->ormawa_id;
        } else {
            $user->ormawa_id = null;
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }
}