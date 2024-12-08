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
                                        ' . Blade::render('<x-icons.search class="h-[1rem] w-[1rem]" />') . '
                                        Show
                                    </a>
                                </li>
                                <li>
                                    <a href="' . $editUrl . '" class="text-gray-600 hover:text-indigo-900">
                                        ' . Blade::render('<x-icons.edit-circle class="h-[1rem] w-[1rem]" />') . '
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    ' . ($insiden->deleted_at
                                        ? '<button class="text-green-600 hover:text-green-900 restore-insiden" data-id="' . $insiden->id . '" data-insiden="' . $insiden->nama_insiden . '" onclick="confirmRestore.showModal()">
                                            ' . Blade::render('<x-icons.restore class="h-[1rem] w-[1rem]" />') . '
                                            Restore
                                        </button>'
                                        : '<button class="text-red-600 hover:text-red-900 delete-insiden" data-id="' . $insiden->id . '" data-insiden="' . $insiden->nama_insiden . '" onclick="confirmDelete.showModal()">
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
            

            ->rawColumns(['waktu__insiden', 'grading', 'action'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InsidenModel $model): QueryBuilder
    {
        $model = $model->newQuery();

        $model->with(['jenisInsiden']);

        return $model;
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
