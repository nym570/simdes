<?php

namespace App\DataTables;

use App\Models\Kelahiran;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder;

class KelahiranDataTable extends DataTable
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
            $btn = "";
            $btn = '<button class="btn btn-sm btn-success mb-1 me-1 open_modal_lihat" value="'.route('kelahiran.get',$row).'"> Lihat</button>';
            if($row->verifikasi){
                $btn = $btn.'<a class="btn btn-sm me-1 mb-1 btn-dark" href="'.route('warga.show',$row->dinamika->warga).'" >Warga</a>';
            }
            $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                
            if(!$row->verifikasi&&in_array('ketua rt',auth()->user()->getRoleNames()->toArray())){
                
                
                $btn = $btn.'<li><a class="dropdown-item" href="'.route('dinamika.kelahiran.verifikasi',$row).'" onclick="verif(this)">Verif</a></li>';
                $btn = $btn.'<li><a class="dropdown-item open_modal_tolak" data-link="'.route('dinamika.kelahiran.tolak',$row).'">Tolak</a></li>';
                  
            }
            $btn = $btn.'</ul></div>';

             return $btn;
             
        })
            ->addColumn('identitas bayi', function($row){
                return $row->dinamika->warga->nama.' ['.$row->dinamika->nik.']';
            })
            ->addIndexColumn() 
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Kelahiran $model): QueryBuilder
    {
        $cakupan = auth()->user()->getRoleNames()->toArray(); 
        if(!empty(array_intersect(['kependudukan','kepala desa'],$cakupan))){
            return $model->newQuery()->with(['dinamika.warga']);
        }
            else if(in_array('kepala dusun',$cakupan)){
                   return $model->newQuery()->with(['dinamika.warga'])->whereHas("dinamika.warga.rt.rw.dusun", function(Builder $builder) {
                     $builder->where('pemimpin', '=', auth()->user()->id);
                 });
                
            }
            else if(in_array('ketua rw',$cakupan)){
                return $model->newQuery()->with(['dinamika.warga'])->whereHas("dinamika.warga.rt.rw", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                });
                
            }
            else if(in_array('ketua rt',$cakupan)){
                
                return $model->newQuery()->with(['dinamika.warga'])->whereHas("dinamika.warga.rt", function(Builder $builder) {
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
                    ->setTableId('kelahiran-table')
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
            Column::make('DT_RowIndex')
            ->title('#')
            ->orderable(false)
            ->searchable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('waktu'),
            Column::make('tempat'),
            Column::computed('identitas bayi'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kelahiran_' . date('YmdHis');
    }
}
