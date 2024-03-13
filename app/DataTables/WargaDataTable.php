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
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

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
            $role = auth()->user()->getRoleNames()->toArray();
            $btn = ' <a href='.route("warga.show",$row).' class="btn btn-sm btn-success my-1"> Lihat</a>';
            if(!($row->status == 'meninggal' || $row->status == 'pindah')){
                $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if($row->user){
                    $btn = $btn.'<li><a class="dropdown-item open_modal_message" data-link="'.route('warga.message',$row).'">Kirim Pesan ke Warga</a></li>';
                }
                
                
                if(!in_array('ketua rt',$role)){
                    $btn = $btn.'<li><a class="dropdown-item open_modal_message" data-link="'.route('warga.message.rt',$row).'">Kirim Pesan ke RT</a></li>';
                }
                if(is_null($row->rt_id)&&in_array('kependudukan',$role)){
                    $btn = $btn.'<li><a class="dropdown-item open_modal_domisili" data-link="'.route('warga.domisili',$row).'">Atur Domisili</a></li>';
                }
                if(in_array('ketua rt',$role)){
                    $btn = $btn. '<li><a class="dropdown-item open_modal_update" data-get="'.route('warga.get',$row).'"data-link="'.route('warga.update',$row).'">Update Data</a></li>';
                }
                if(!empty(array_intersect(['ketua rt','kependudukan'],$role))){
                    $btn = $btn. '<li><a class="dropdown-item open_modal_dokumen" data-dokumen="'.$row->nik.'"data-link="'.route('warga.dokumen',$row).'">Upload Dokumen</a></li>';
                }
               
                if(auth()->user()->nik != $row->nik&&!empty(array_intersect(['ketua rt','kependudukan'],$role))){
                    $btn = $btn.'<li><a class="dropdown-item" onclick="change(this)" href="'.route("warga.status",$row).'">'.($row->status=='warga'?"Pergi Sementara":"Kembali Tinggal").'</a></li>';
                }
                    
                $btn = $btn.'</ul></div>';
            }
          
           
             return $btn;
             
        })
        ->addColumn('updated', function($row){
            
            $formatted_dt2=Carbon::parse(now());
            $formatted_dt1=Date::createFromFormat('d M Y', $row->tanggal_lahir);
            $usia =  $formatted_dt1->diffInYears($formatted_dt2);
            if(in_array($usia,[7,13,16,19])&&($row->status=='warga'||$row->status=='sementara tidak berdomisili')){
                return '<span class="badge bg-warning">'.Carbon::parse($row->updated_at)->translatedFormat('d F Y').'</span>';
            }
            else{
                return Carbon::parse($row->updated_at)->translatedFormat('d F Y');
            }
            
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
            ->rawColumns(['action','updated'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Warga $model): QueryBuilder
    {
        $cakupan = auth()->user()->getRoleNames()->toArray(); 
        if(!empty(array_intersect(['kependudukan','kepala desa'],$cakupan))){
            return $model->newQuery()->with('rt');
        }
            else if(in_array('kepala dusun',$cakupan)){
                   return $model->newQuery()->with('rt')->whereHas("rt.rw.dusun", function(Builder $builder) {
                     $builder->where('pemimpin', '=', auth()->user()->id);
                 });
                
            }
            else if(in_array('ketua rw',$cakupan)){
                return $model->newQuery()->with('rt')->whereHas("rt.rw", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                });
                
            }
            else if(in_array('ketua rt',$cakupan)){
                return $model->newQuery()->with('rt')->whereHas("rt", function(Builder $builder) {
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
                    ->setTableId('warga-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2,'desc')
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
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index <= 3) return;
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
            Column::computed('updated')
                ->exportable(false)
                  ->printable(false),
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
