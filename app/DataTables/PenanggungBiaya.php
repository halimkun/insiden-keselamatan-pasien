<?php

namespace App\DataTables;

use App\Models\PenanggungBiaya as PenanggungBiayaModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PenanggungBiaya extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn("action", function ($penanggungBiaya) {
                // Menggunakan URL route untuk Show, Edit, dan Delete
                $showUrl = route('penanggung-biaya.show', $penanggungBiaya->id);
                $editUrl = route('penanggung-biaya.edit', $penanggungBiaya->id);

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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0-14 0m18 11l-6-6"/></svg>
                                        Show
                                    </a>
                                </li>
                                <li>
                                    <a href="' . $editUrl . '" class="text-gray-600 hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5">
                                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                                <path d="m12 15l8.385-8.415a2.1 2.1 0 0 0-2.97-2.97L9 12v3zm4-10l3 3" />
                                                <path d="M9 7.07A7 7 0 0 0 10 21a7 7 0 0 0 6.929-6" />
                                            </g>
                                        </svg>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    ' . ($penanggungBiaya->deleted_at
                                        ? '<button class="text-green-600 hover:text-green-900 restore-penanggung-biaya" data-id="' . $penanggungBiaya->id . '" data-penanggung_biaya="' . $penanggungBiaya->jenis_penanggung . '" onclick="confirmRestore.showModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0-8 0M6 21v-2a4 4 0 0 1 4-4h3m3 7l5-5m0 4.5V17h-4.5"/></svg>
                                            Restore
                                        </button>'
                                        : '<button class="text-red-600 hover:text-red-900 delete-penanggung-biaya" data-id="' . $penanggungBiaya->id . '" data-penanggung_biaya="' . $penanggungBiaya->jenis_penanggung . '" onclick="confirmDelete.showModal()">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" /></svg>
                                            Delete
                                        </button>'
                                    ) . '
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PenanggungBiayaModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('datatablepenanggungbiaya-table')
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
            Column::make('jenis_penanggung'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DataTablePenanggungBiaya_' . date('YmdHis');
    }
}
