<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use App\Models\JenisInsiden as JenisInsidenModel;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class JenisInsiden extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn("action", function ($jenisInsiden) {
                // Menggunakan URL route untuk Show, Edit, dan Delete
                $showUrl = route('jenis-insiden.show', $jenisInsiden->id);
                $editUrl = route('jenis-insiden.edit', $jenisInsiden->id);

                $html = '<div class="flex items-center justify-end gap-3">';

                $html .= '
                    <a href="' . $showUrl . '" class="hover:text-indigo-900" title="Show ' . $jenisInsiden->nama_jenis_insiden . '">
                        ' . Blade::render('<x-icons.search class="h-[1rem] w-[1rem]" />') . '
                    </a>
                ';

                if (Gate::allows('edit_jenis_insiden')) {
                    $html .= '
                        <a href="' . $editUrl . '" class="hover:text-indigo-900" title="Edit ' . $jenisInsiden->nama_jenis_insiden . '">
                            ' . Blade::render('<x-icons.edit-circle class="h-[1rem] w-[1rem]" />') . '
                        </a>
                    ';
                }

                if (Gate::allows('hapus_jenis_insiden')) {
                    if ($jenisInsiden->deleted_at) {
                        $html .= '
                            <button class="text-green-600 hover:text-green-900 restore-jenis-insiden" data-id="' . $jenisInsiden->id . '" data-jenis_insiden="' . $jenisInsiden->nama_jenis_insiden . '" onclick="confirmRestore.showModal()" title="Restore ' . $jenisInsiden->nama_jenis_insiden . '">
                                ' . Blade::render('<x-icons.restore class="h-[1rem] w-[1rem]" />') . '
                            </button>
                        ';
                    } else {
                        $html .= '
                            <button class="text-red-600 hover:text-red-900 delete-jenis-insiden" data-id="' . $jenisInsiden->id . '" data-jenis_insiden="' . $jenisInsiden->nama_jenis_insiden . '" onclick="confirmDelete.showModal()" title="Delete ' . $jenisInsiden->nama_jenis_insiden . '">
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
    public function query(JenisInsidenModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('jenisinsiden-table')
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
            Column::make('nama_jenis_insiden'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'JenisInsiden_' . date('YmdHis');
    }
}
