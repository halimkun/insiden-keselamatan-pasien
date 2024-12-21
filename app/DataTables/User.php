<?php

namespace App\DataTables;

use App\Models\User as UserModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class User extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
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
                        case 'tim-ikp':
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

                return view('components.actions.user-action', [
                    'showUrl' => $showUrl,
                    'editUrl' => $editUrl,
                    'user' => $user
                ]);
            })

            ->orderColumn('roles', function ($query, $order) {
                return $query->with('roles')->orderBy('name', $order);
            })

            ->rawColumns(['action', 'roles'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserModel $model): QueryBuilder
    {
        $model = $model->newQuery();

        // add relation to roles
        $model->with('roles');

        if ($this->request->has("show_deleted") && $this->request->show_deleted) {
            return $model->onlyTrashed(); // Hanya menampilkan data yang sudah dihapus
        }

        return $model;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
