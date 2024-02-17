<?php

namespace App\DataTables;

use App\Models\Ruta;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class RutaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'ruta.action')
            ->addColumn('kepala keluarga', function($row){
                return $row->anggota_ruta->warga->nama;
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Ruta $model): QueryBuilder
    {
        return $model->newQuery()->with(['anggota_ruta.warga'])->select('ruta.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('ruta-table')
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
            Column::make('DT_RowIndex')
                ->title('#')
                ->orderable(false)
                ->searchable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('alamat_domisili')->title('Alamat Domisili'),
            Column::make('jumlah_art')->title('Jumlah Anggota'),
            Column::computed('kepala keluarga'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Ruta_' . date('YmdHis');
    }
}
