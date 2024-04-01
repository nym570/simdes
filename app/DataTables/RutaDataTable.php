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
use Illuminate\Database\Eloquent\Builder;

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
                if(in_array('ketua rt',auth()->user()->getRoleNames()->toArray())){
                    $btn = $btn.'<div class="btn-group me-3">
                    <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Aksi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';      
                    $btn = $btn.' <li><a class="dropdown-item open_modal" data-link="'.route('ruta.edit',$row).'">Update</a></li>';
                    $btn = $btn.' <li><a class="dropdown-item" onclick="del(this)" href="'.route('ruta.delete',$row).'">Hapus</a></li>';
                    $btn = $btn.'</ul></div>';
                }
                
                return $btn;
            })
            ->addColumn('kepala ruta', function($row){
                $kepala = $row->anggota_ruta->where('hubungan','Kepala Keluarga')->first()->warga;
                return $kepala->nama.' ['.$kepala->nik.']';
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Ruta $model): QueryBuilder
    {
        $cakupan = auth()->user()->getRoleNames()->toArray(); 
        if(!empty(array_intersect(['kependudukan','kepala desa'],$cakupan))){
            return $model->newQuery()->with(['anggota_ruta.warga','rt']);
        }
            else if(in_array('kepala dusun',$cakupan)){
                   return $model->newQuery()->with(['anggota_ruta.warga','rt'])->whereHas("rt.rw.dusun", function(Builder $builder) {
                     $builder->where('pemimpin', '=', auth()->user()->id);
                 });
                
            }
            else if(in_array('ketua rw',$cakupan)){
                return $model->newQuery()->with(['anggota_ruta.warga','rt'])->whereHas("rt.rw", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                });
                
            }
            else if(in_array('ketua rt',$cakupan)){
                return $model->newQuery()->with(['anggota_ruta.warga','rt'])->whereHas("rt", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                });
                
            }
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
            Column::computed('kepala ruta'),
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
