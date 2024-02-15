<?php

namespace App\DataTables;

use App\Models\Warga;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class WargaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'warga.action')
            ->addColumn('ktp', function($row){
                return $row->ktp_desa == 1 ? 'desa' : 'luar desa';
            })
            ->addColumn('ttl', function($row){
                return $row->tempat_lahir.', '.$row->tanggal_lahir;
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Warga $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('warga-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
            ->title('#')
            ->orderable(false)
            ->searchable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            Column::make('nik'),
            Column::make('no_kk')->title('No KK'),
            Column::make('nama'),
            Column::make('status'),
            Column::computed('ktp'),
            Column::make('alamat_ktp')->title('alamat ktp'),
            Column::make('no_telp')->title('no hp'),
            Column::make('jenis_kelamin')->title('jenis kelamin'),
            Column::computed('ttl'),
            Column::make('agama'),
            Column::make('gol_darah'),
            Column::make('pendidikan'),
            Column::make('pekerjaan'),
            
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Warga_' . date('YmdHis');
    }
}
