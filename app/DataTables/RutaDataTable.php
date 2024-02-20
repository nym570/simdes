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
            ->addColumn('action', function($row){
                $btn = ' <a href='.route("ruta.show",$row).' class="btn btn-sm btn-success my-1 mx-1"> Lihat</a>';
                $btn = $btn.'<button class="btn btn-sm btn-dark mx-1 my-1 open_modal" value="'.route('ruta.edit',$row).'"> Update</button>';
                $btn = $btn.'<button class="btn btn-sm btn-danger mx-1 my-1 delete_modal" onclick="del(this)" href="'.route('ruta.delete',$row).'"> Hapus</button>';
                return $btn;
            })
            ->addColumn('kepala keluarga', function($row){
                return $row->anggota_ruta->where('hubungan','Kepala Keluarga')->value('warga.nama');
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Ruta $model): QueryBuilder
    {
        return $model->newQuery()->with(['anggota_ruta.warga','rt'])->select('ruta.*');
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
            Column::make('rt.name')->title('RT')->data('rt.name'),
            Column::make('alamat_domisili')->title('Alamat Domisili'),
            Column::computed('kepala keluarga'),
            Column::make('jumlah_art')->title('Jumlah Anggota'),
            
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
