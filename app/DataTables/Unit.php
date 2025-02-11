<?php

namespace App\DataTables;

use App\Models\Unit as UnitModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class Unit extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn("action", function ($unit) {
                // Menggunakan URL route untuk Show, Edit, dan Delete
                $showUrl = route('unit.show', $unit->id);
                $editUrl = route('unit.edit', $unit->id);

                $html = '<div class="flex items-center justify-end gap-3">';

                $html .= '
                    <a href="' . $showUrl . '" class="hover:text-indigo-900" title="Show ' . $unit->nama_unit . '">
                        ' . Blade::render('<x-icons.search class="h-[1rem] w-[1rem]" />') . '
                    </a>
                ';
                
                if (Gate::allows('edit_unit')) {
                    $html .= '
                        <a href="' . $editUrl . '" class="hover:text-indigo-900" title="Edit ' . $unit->nama_unit . '">
                            ' . Blade::render('<x-icons.edit-circle class="h-[1rem] w-[1rem]" />') . '
                        </a>
                    ';  
                }

                if (Gate::allows('hapus_unit')) {
                    if ($unit->deleted_at) {
                        $html .= '
                            <button class="text-green-600 hover:text-green-900 restore-unit" data-id="' . $unit->id . '" data-unit="' . $unit->nama_unit . '" onclick="confirmRestore.showModal()" title="Restore ' . $unit->nama_unit . '">
                                ' . Blade::render('<x-icons.restore class="h-[1rem] w-[1rem]" />') . '
                            </button>
                        ';
                    } else {
                        $html .= '
                            <button class="text-red-600 hover:text-red-900 delete-unit" data-id="' . $unit->id . '" data-unit="' . $unit->nama_unit . '" onclick="confirmDelete.showModal()" title="Delete ' . $unit->nama_unit . '">
                                ' . Blade::render('<x-icons.trash class="h-[1rem] w-[1rem]" />') . '
                            </button>
                        ';
                    }
                }

                $html .= '</div>';

                return $html;
            })

            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UnitModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('datatableunit-table')
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
            Column::make('nama_unit'),
            Column::make('updated_at')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DataTableUnit_' . date('YmdHis');
    }
}
