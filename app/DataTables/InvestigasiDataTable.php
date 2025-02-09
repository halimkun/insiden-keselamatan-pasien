<?php

namespace App\DataTables;

use App\Models\Investigasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvestigasiDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('tanggal_mulai', function($investigasi) {
                return \Carbon\Carbon::parse($investigasi->tanggal_mulai)->translatedFormat('d M Y');
            })
            
            ->addColumn('tanggal_selesai', function($investigasi) {
                return \Carbon\Carbon::parse($investigasi->tanggal_selesai)->translatedFormat('d M Y');
            })
            
            ->addColumn('tanggal_pengesahan', function($investigasi) {
                return \Carbon\Carbon::parse($investigasi->tanggal_pengesahan)->translatedFormat('d M Y');
            })

            ->addColumn('info', function($investigasi) {
                $html = view('components.badges.investigasi-status', [
                    'investigasi' => $investigasi
                ])->render();

                return $html;
            })

            ->addColumn('action', function($investigasi) {
                $html = view('components.actions.investigasi', [
                    'investigasi' => $investigasi
                ])->render();

                return $html;
            })

            ->rawColumns(['info', 'action'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Investigasi $model): QueryBuilder
    {
        $user = auth()->user()->load('detail');
        
        $model = $model->newQuery();
        return $model->with('insiden', 'rekomendasi', 'grading')
            ->whereHas('insiden', function ($query) use ($user) {
                if ($user->can('lihat_semua_investigasi')) {
                    return $query;
                }
                
                if ($user->can('lihat_investigasi')) {
                    return $query->where('unit_id', $user->detail?->unit_id)
                        ->orWhere('created_by', $user->id);
                }

                return $query->where('created_by', $user->id);
            })->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('investigasi-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Investigasi_' . date('YmdHis');
    }
}
