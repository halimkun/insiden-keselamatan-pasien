<?php

namespace App\Http\Controllers\DataTables;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Jika request datang dari DataTables AJAX
        if ($request->ajax()) {
            $users = User::query(); // Query ke tabel User
            
            $users->with('roles'); // Include roles relationship
            if ($request->has("show_deleted") && $request->show_deleted) {
                $users->onlyTrashed(); // Hanya menampilkan data yang sudah dihapus
            }

            return DataTables::of($users)
                ->addColumn('roles', function($user) {
                    // Create a badge for each role with color
                    $roles = $user->roles->pluck('name'); // Get the list of roles
    
                    $badges = $roles->map(function($role) {
                        // Assign a color to each role
                        switch($role) {
                            case 'administrator':
                                return '<span class="badge badge-primary lowercase font-semibold text-white">' . ucfirst($role) . '</span>';
                            case 'komite-mutu':
                                return '<span class="badge badge-secondary lowercase font-semibold text-white">' . ucfirst($role) . '</span>';
                            case 'direksi':
                                return '<span class="badge badge-accent lowercase font-semibold text-white">' . ucfirst($role) . '</span>';
                            case 'pelapor':
                                return '<span class="badge badge-info lowercase font-semibold text-white">' . ucfirst($role) . '</span>';
                            default:
                                return '<span class="badge badge-ghost lowercase font-semibold">' . ucfirst($role) . '</span>';
                        }
                    })->join(''); // Join roles with space for multiple roles
    
                    return $badges;
                })

                ->addColumn("action", function ($user) {
                    // Menggunakan URL route untuk Show, Edit, dan Delete
                    $showUrl = route('users.show', $user->id);
                    $editUrl = route('users.edit', $user->id);

                    return '
                        <div class="dropdown dropdown-left">
                            <div tabindex="0" role="button" class="inline-flex items-center rounded-lg border px-2 py-1 text-right transition duration-150 ease-in-out hover:bg-indigo-600 hover:text-white">
                                Aksi
                                <div class="ms-1">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div tabindex="0" class="menu dropdown-content z-10 w-52 rounded-box border bg-base-100 p-2 shadow">
                                <ul>
                                    <li>
                                        <a href="' . $showUrl . '" class="text-gray-600 hover:text-gray-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h1.5m3.5 3a3 3 0 1 0 6 0a3 3 0 1 0-6 0m5.2 2.2L22 22"/></svg>
                                            Show
                                        </a>
                                    </li>
                                    <li>
                                        <a href="' . $editUrl . '" class="text-gray-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h3.5m4.92.61a2.1 2.1 0 0 1 2.97 2.97L18 22h-3v-3z"/></svg>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        ' . ( $user->deleted_at 
                                            ? '<button class="text-green-600 hover:text-green-900 restore-user" data-id="' . $user->id . '" data-name="' . $user->name . '" onclick="confirmRestore.showModal()">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h3m3 7l5-5m0 4.5V17h-4.5"/></svg>
                                                Restore
                                            </button>' 
                                            : '<button class="text-red-600 hover:text-red-900 delete-user" data-id="' . $user->id . '" data-name="' . $user->name . '" onclick="confirmDelete.showModal()">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                                                Delete
                                            </button>' 
                                        ) . '
                                    </li>
                                </ul>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['action', 'roles']) // Menandakan kolom action akan mengandung HTML
                ->make(true); // Return dalam format DataTables
        } else {
            throw new \Exception("Request harus dari AJAX");
        }
    }
}
