<?php

namespace App\DataTables;

use App\Models\AnggotaRuta;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class AnggotaRutaDataTable extends DataTable
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
                $btn = ' <a href='.route("warga.show",$row->warga).' class="btn btn-sm btn-success my-1"> Lihat</a>';
                if(in_array('rt',auth()->user()->roles->pluck('status')->toArray())){
                    $btn = $btn.'<button class="btn btn-sm btn-danger mx-1 my-1 delete_modal" onclick="del(this)" href="'.route('ruta.anggota.delete',$row).'">Hapus</button>';
                }
                return $btn;
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AnggotaRuta $model): QueryBuilder
    {
        return $model->newQuery()->where('ruta_id',$this->ruta_id)->with(['warga']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('anggotaruta-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'lengthMenu' => [
                            [ -1, 10, 25, 50 ],
                            [ 'all', '10','25', '50'  ]
                    ],    
                        'dom'          => 'Blfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
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
            Column::make('hubungan'),
            Column::make('anggota_nik')->title('nik')->data('anggota_nik'),
            Column::make('warga.nama')->title('nama')->data('warga.nama'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AnggotaRuta_' . date('YmdHis');
    }
}
