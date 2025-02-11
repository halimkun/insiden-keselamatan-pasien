<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use App\Models\PenanggungBiaya as PenanggungBiayaModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

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

                $html = '<div class="flex items-center justify-end gap-3">';

                $html .= '
                    <a href="' . $showUrl . '" class="hover:text-indigo-900" title="Lihat Detail Penanggung Biaya">
                        ' . Blade::render('<x-icons.search class="h-[1rem] w-[1rem]" />') . '
                    </a>
                ';

                if (Gate::allows('edit_penanggung_biaya')) {
                    $html .= '
                        <a href="' . $editUrl . '" class="hover:text-indigo-900" title="Edit Penanggung Biaya">
                            ' . Blade::render('<x-icons.edit-circle class="h-[1rem] w-[1rem]" />') . '
                        </a>
                    ';
                }

                if (Gate::allows('hapus_penanggung_biaya')) {
                    $html .= '
                        <button class="text-red-600 hover:text-red-900 delete-penanggung-biaya" data-id="' . $penanggungBiaya->id . '" data-penanggung_biaya="' . $penanggungBiaya->jenis_penanggung . '" onclick="confirmDelete.showModal()" title="Hapus Penanggung Biaya">
                            ' . Blade::render('<x-icons.trash class="h-[1rem] w-[1rem]" />') . '
                        </button>
                    ';
                }

                $html .= '</div>';

                return $html;
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
