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

class WargaAnggotaRutaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row){
                
                $btn = ' <a href='.route("pengajuan.warga.ruta.anggota.warga.show",$row->warga).' class="btn btn-sm btn-success my-1"> Lihat</a>';
                    
                    if($row->hubungan != 'Kepala Keluarga'){
                        $btn = $btn.'<div class="btn-group me-3">
                    <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Aksi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                        $btn = $btn.'<li><a class="dropdown-item open_modal_hubungan" data-link="'.route('pengajuan.warga.ruta.anggota.update',$row).'">Update Hubungan</a></li>';
                        $btn = $btn.'<li><a class="dropdown-item" href="'.route('pengajuan.warga.ruta.anggota.delete',$row).'" onclick="del(this)">Hapus</a></li>';
                        $btn = $btn.'</ul></div>';
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
                        'buttons'      => ['excel', 'print', 'reload'],
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
            Column::make('warga.status')->title('status')->data('warga.status'),

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
