<?php

namespace App\DataTables;

use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Blade;
use App\Models\Insiden as InsidenModel;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class Insiden extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('waktu__insiden', function ($insiden) {
                return '
                    <p class="font-medium">' . $insiden->tanggal_insiden->translatedFormat("D, d M Y") . '</p>
                    <p class="text-xs">' . $insiden->waktu_insiden . '</p>
                ';
            })

            ->addColumn('grading', function ($insiden) {
                if (!$insiden->grading) {
                    return '-';
                }

                if (Str::lower($insiden->grading->grading_risiko) == 'merah') {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        ' . $insiden->grading->grading_risiko . '
                    </span>';
                }

                if (Str::lower($insiden->grading->grading_risiko) == 'kuning') {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        ' . $insiden->grading->grading_risiko . '
                    </span>';
                }

                if (Str::lower($insiden->grading->grading_risiko) == 'hijau') {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        ' . $insiden->grading->grading_risiko . '
                    </span>';
                }

                if (Str::lower($insiden->grading->grading_risiko) == 'biru') {
                    return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        ' . $insiden->grading->grading_risiko . '
                    </span>';
                }
            })

            ->addColumn("action", function ($insiden) {
                // Menggunakan URL route untuk Show, Edit, dan Delete
                $showUrl = route('insiden.show', $insiden->id);
                $editUrl = route('insiden.edit', $insiden->id);

                $html = view('components.actions.insiden-action', [
                    'showUrl' => $showUrl,
                    'editUrl' => $editUrl,

                    'insiden' => $insiden,
                ])->render();

                return $html;
            })

            ->filterColumn('jenis_insiden.alias', function ($query, $keyword) {
                $query->whereHas('jenisInsiden', function ($query) use ($keyword) {
                    $query->where('alias', 'like', "%$keyword%");
                });
            })

            ->filterColumn('grading', function ($query, $keyword) {
                $query->whereHas('grading', function ($query) use ($keyword) {
                    $query->where('grading_risiko', 'like', "%$keyword%");
                });
            })

            ->filterColumn('waktu__insiden', function ($query, $keyword) {
                $query->where('tanggal_insiden', 'like', "%$keyword%")
                    ->orWhere('waktu_insiden', 'like', "%$keyword%");
            })

            ->rawColumns(['waktu__insiden', 'grading', 'action'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InsidenModel $model): QueryBuilder
    {
        $user = auth()->user()->load('detail');

        $model = $model->newQuery();

        if (!$user->can('lihat_semua_insiden')) {
            if ($user->can('lihat_unit_insiden')) {
                $unitId = $user->detail?->unit_id ?? 0;
                $model->where('unit_id', $unitId)->orWhere('created_by', $user->id);
            } else { // Jika bukan unit, maka hanya bisa melihat insiden yang dibuat oleh dirinya
                $model->where('created_by', $user->id);
            }
        }

        return $model->with(['jenisInsiden', 'unit', 'grading'])->orderBy('tanggal_insiden', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('insiden-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
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
        return 'Insiden_' . date('YmdHis');
    }
}
