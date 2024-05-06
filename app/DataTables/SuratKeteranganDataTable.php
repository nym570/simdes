<?php

namespace App\DataTables;

use App\Models\SuratKeterangan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Support\Str;

class SuratKeteranganDataTable extends DataTable
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
   
            $btn = '<button class="btn btn-sm btn-success open_modal_lihat m-1" data-dokumen="'.$row->nik.'" data-suket="'.($row->file==null?null:asset('/laraview/#../storage/'.$row->file)).'"> Lihat</button>';
            if($row->status!='ditolak'&&$row->status!='selesai'&&!auth()->user()->hasRole('kepala desa')){
                if((auth()->user()->hasRole('layanan')&&!Str::contains($row->tracking,['rt','rw']))||(auth()->user()->hasRole('ketua rw')&&!Str::contains($row->tracking,['rt']))){

               
            $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if($row->status==='diajukan'){
                $btn = $btn.'<li><a class="dropdown-item open_modal_message" data-link="'.route('suket.tolak',$row).'">Tolak</a></li>';
                if($row->jenis=='umum'&&$row->verifikasi==1){
                    $btn = $btn.'<li><a class="dropdown-item open_modal_umum" data-link="'.route('suket.verifikasi',$row).'" data-keterangan="'.$row->keterangan.'">Verifikasi</a></li>';
                }
                else{
                    $btn = $btn.'<li><a class="dropdown-item" onclick="change(this)" href="'.route('suket.verifikasi',$row).'">Verifikasi</a></li>';
                }
               
            }
           
            if($row->status==='diproses'){
                $btn = $btn.'<li><a class="dropdown-item open_modal_message" data-link="'.route('suket.setuju',$row).'">Dapat Diambil</a></li>';
            }
            if($row->status==='dapat diambil'){
                $btn = $btn.'<li><a class="dropdown-item" onclick="selesai(this)" href="'.route('suket.selesai',$row).'">Selesai</a></li>';
            }
                  
             $btn = $btn.'</ul></div>';
        } }
             return $btn;
             
        })
        ->editColumn('status', function($row){
            return ($row->status=='diajukan'?'<span class="badge bg-dark">':($row->status=='diproses'?'<span class="badge bg-primary">':($row->status=='dapat diambil'?'<span class="badge bg-success">':($row->status=='selesai'?'<span class="badge bg-secondary">':'<span class="badge bg-danger">')))).$row->status.'</span>';
    })
            ->addIndexColumn() 
            ->rawColumns(['action','status','verifikasi'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SuratKeterangan $model): QueryBuilder
    {
        $cakupan = auth()->user()->getRoleNames()->toArray(); 
        if(in_array('layanan',$cakupan)){
            return $model->newQuery()->with('warga')->where('tingkat','desa')->orWhere('tracking','menunggu verifikasi desa');
        }
        if(in_array('kepala desa',$cakupan)){
            return $model->newQuery()->with('warga');
        }
            else if(in_array('ketua rw',$cakupan)){
                return $model->newQuery()->with('warga')->where('tingkat','rw')->orWhere('tracking','menunggu verifikasi rw')->whereHas("warga.rt.rw", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                });
                
            }
            else if(in_array('ketua rt',$cakupan)){
                return $model->newQuery()->with('warga')->where('tingkat','rt')->orWhere('tracking','menunggu verifikasi rt')->whereHas("warga.rt", function(Builder $builder) {
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
                    ->setTableId('suratketerangan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
                    ->selectStyleSingle()
                    ->paging(true)
                    ->parameters([
                        'lengthMenu' => [
                            [ -1, 10, 25, 50 ],
                            [ 'all', '10','25', '50'  ]
                    ],    
                        'dom'          => 'Blfrtip',
                        'buttons'      => ['excel', 'print', 'reload'],
                        'initComplete' => "function () {
                            var r = $('#suratketerangan-table tfoot tr');
                            $('#suratketerangan-table thead').append(r);
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index < 2) return;
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
                                        if(d!=null){
                                            select.add(new Option(d.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/g, '')));
                                        }
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
                    Column::make('created_at')->title('tanggal pengajuan'),
                  Column::make('status'),
            Column::make('warga.nik')->title('pengaju'),
            Column::make('no_surat')->title('no'),
            Column::make('jenis'),
            Column::make('tingkat'),
            Column::make('keperluan'),
            Column::make('penanggung_jawab')->title('wilayah'),
            
            
            Column::make('tracking'),
            Column::make('updated_at') ->title('last update')
                  ->exportable(false)
                    ->printable(false),
                  
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SuratKeterangan_' . date('YmdHis');
    }
}
