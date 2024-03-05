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
use Illuminate\Database\Eloquent\Builder;

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
        ->addColumn('action', function($row){
   
            $btn = ' <a href='.route("warga.show",$row).' class="btn btn-sm btn-success my-1"> Lihat</a>';
            if(!($row->status == 'meninggal' || $row->status == 'pindah')){
                $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="javascript:void(0);">Atur Domisili</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Sementara keluar</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Upload Dokumen</a></li>
                </ul>
              </div>';
            }
          
           
             return $btn;
             
        })
        ->addColumn('domisili', function($row){
            return is_null($row->rt) ? '' : $row->rt->name;
        })
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
        $user_role = auth()->user()->roles->pluck('category')->toArray(); 
        if(in_array('kependudukan',$user_role)){
            return $model->newQuery()->with('rt');
        }
        else if(in_array('pemimpin',$user_role)){
            $cakupan = auth()->user()->roles->pluck('status')->toArray();
            if(in_array('desa',$cakupan)){
                return $model->newQuery()->with('rt');
            }
            else if(in_array('dusun',$cakupan)){
                // return $model->newQuery()->whereHas("anggota_ruta.ruta.rt.rw.dusun", function(Builder $builder) {
                //     $builder->where('kepala_dusun', '=', auth()->user()->roles->where('status','dusun')->value('id'));
                // });
                   return $model->newQuery()->with('rt')->whereHas("rt.rw.dusun", function(Builder $builder) {
                     $builder->where('kepala_dusun', '=', auth()->user()->roles->where('status','dusun')->value('id'));
                 });
                
            }
            else if(in_array('rw',$cakupan)){
                // return $model->newQuery()->whereHas("anggota_ruta.ruta.rt.rw", function(Builder $builder) {
                //     $builder->where('ketua_rw', '=', auth()->user()->roles->where('status','rw')->value('id'));
                // });
                return $model->newQuery()->with('rt')->whereHas("rt.rw", function(Builder $builder) {
                    $builder->where('ketua_rw', '=', auth()->user()->roles->where('status','rw')->value('id'));
                });
                
            }
            else if(in_array('rt',$cakupan)){
                // return $model->newQuery()->whereHas("anggota_ruta.ruta.rt", function(Builder $builder) {
                //     $builder->where('ketua_rt', '=', auth()->user()->roles->where('status','rt')->value('id'));
                // });
                return $model->newQuery()->with('rt')->whereHas("rt", function(Builder $builder) {
                    $builder->where('ketua_rt', '=', auth()->user()->roles->where('status','rt')->value('id'));
                });
                
            }
        }
        
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
                    ->orderBy(2,'desc')
                    ->selectStyleSingle()
                    ->paging(true)
                    ->parameters([
                        'dom'          => 'Blfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
                        'initComplete' => "function () {
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index == 0 || index == 1 || index == 2) return;
                                    let column = this;
                     
                                    // Create select element
                                    let select = document.createElement('select');
                                    select.add(new Option(''));
                                    column.footer().replaceChildren(select);
                     
                                    // Apply listener for user change in value
                                    select.addEventListener('change', function () {
                                        column
                                            .search(select.value, {exact: true})
                                            .draw();
                                    });
                     
                                    // Add list of options
                                    column
                                        .data()
                                        .unique()
                                        .sort()
                                        .each(function (d, j) {
                                            select.add(new Option(d));
                                        });
                                });
                        }",
                        
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
            Column::computed('domisili'),
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
