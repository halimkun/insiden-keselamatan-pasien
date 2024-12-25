<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Models\Pasien as PasienModel;
use Illuminate\Support\Facades\Blade;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class Pasien extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn("no_rekam_medis", function ($pasien) {
                return '
                    <kbd class="px-1.5 py-0.5 bg-black text-white rounded-md text-xs leading-none tracking-wider">' . $pasien->no_rekam_medis . '</kbd>
                ';
            })
            ->addColumn("nama", function ($pasien) {
                return '
                    <div class="flex lg:items-center gap-2 lg:gap-3 w-full">
                        <div>
                            ' . ($pasien->jenis_kelamin == 'P' 
                                ? Blade::render('<x-icons.gender-female class="h-[1.1rem] w-[1.1rem]" />') 
                                : ($pasien->jenis_kelamin == 'L' 
                                    ? Blade::render('<x-icons.gender-male class="h-[1.1rem] w-[1.1rem]" />') 
                                    : '')) . '
                        </div>
                        <div class="font-medium w-[120px] lg:w-full max-w-md whitespace-normal">
                            ' . $pasien->nama . '
                        </div>
                    </div>
                ';
            })
            ->addColumn("tanggal_lahir", function ($pasien) {
                return '
                    <p class="flex items-center gap-2">
                        ' . $pasien->tanggal_lahir->format('d F Y') . '
                    </p>
                    <p class="text-xs font-semibold">' . $pasien->tanggal_lahir->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan %d Hari') . '</p>
                ';
            })
            ->addColumn("action", function ($pasien) {
                // Menggunakan URL route untuk Show, Edit, dan Delete
                $showUrl = route('pasien.show', $pasien->id);
                $editUrl = route('pasien.edit', $pasien->id);

                return view('components.actions.default', [
                    'showUrl' => $showUrl,
                    'editUrl' => $editUrl,
                    
                    'permission_edit' => 'edit_pasien',
                    'permission_delete' => 'hapus_pasien',

                    'data' => $pasien,

                    'attributeData' => [
                        'nama' => $pasien->nama,
                        'id'   => $pasien->id,
                    ]
                ])->render();
            })

            ->orderColumn('no_rekam_medis', function ($query, $order) {
                $query->orderBy('no_rekam_medis', $order);
            })
            ->orderColumn('nama', function ($query, $order) {
                $query->orderBy('nama', $order);
            })
            ->orderColumn('tanggal_lahir', function ($query, $order) {
                $query->orderBy('tanggal_lahir', $order);
            })

            ->filterColumn('no_rekam_medis', function ($query, $keyword) {
                $query->where('no_rekam_medis', 'like', "%$keyword%");
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('nama', 'like', "%$keyword%");
            })
            ->filterColumn('tanggal_lahir', function ($query, $keyword) {
                $query->where('tanggal_lahir', 'like', "%$keyword%");
            })

            ->rawColumns(['action', 'nama', 'no_rekam_medis', 'tanggal_lahir'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PasienModel $model): QueryBuilder
    {
        $model = $model->newQuery();

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
            ->setTableId('pasien-table')
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
            Column::make('nama'),
            Column::make('no_rekam_medis'),
            Column::make('tanggal_lahir'),
            Column::make('jenis_kelamin'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pasien_' . date('YmdHis');
    }
}
