<?php

namespace App\Http\Controllers\DataTables;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
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
                                    ' . Blade::render('<x-icons.chevron-down class="h-[0.9rem] w-[0.9rem]" />') . '
                                </div>
                            </div>
                            <div tabindex="0" class="menu dropdown-content z-10 w-52 rounded-box border bg-base-100 p-2 shadow">
                                <ul>
                                    <li>
                                        <a href="' . $showUrl . '" class="text-gray-600 hover:text-gray-900">
                                            ' . Blade::render('<x-icons.user-search class="h-[1rem] w-[1rem]" />') . '
                                            Show
                                        </a>
                                    </li>
                                    <li>
                                        <a href="' . $editUrl . '" class="text-gray-600 hover:text-indigo-900">
                                            ' . Blade::render('<x-icons.user-edit class="h-[1rem] w-[1rem]" />') . '
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        ' . ( $user->deleted_at 
                                            ? '<button class="text-green-600 hover:text-green-900 restore-user" data-id="' . $user->id . '" data-name="' . $user->name . '" onclick="confirmRestore.showModal()">
                                                ' . Blade::render('<x-icons.restore class="h-[1rem] w-[1rem]" />') . '
                                                Restore
                                            </button>' 
                                            : '<button class="text-red-600 hover:text-red-900 delete-user" data-id="' . $user->id . '" data-name="' . $user->name . '" onclick="confirmDelete.showModal()">
                                                ' . Blade::render('<x-icons.trash class="h-[1rem] w-[1rem]" />') . '
                                                Delete
                                            </button>' 
                                        ) . '
                                    </li>
                                </ul>
                            </div>
                        </div>
                    ';
                })

                ->orderColumn('roles', function ($query, $order) {
                    return $query->with('roles')->orderBy('name', $order);
                })

                ->rawColumns(['action', 'roles']) // Menandakan kolom action akan mengandung HTML
                ->make(true); // Return dalam format DataTables
        } else {
            throw new \Exception("Request harus dari AJAX");
        }
    }
}
