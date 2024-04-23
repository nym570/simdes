<?php

namespace App\DataTables;

use App\Models\PengajuanInfoPublik;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class PengajuanInfoPublikDataTable extends DataTable
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
   
            $btn = '<a class="btn btn-sm btn-success my-1 mx-1" href="'.route('pengajuan-info-manajemen.show',$row).'"> Lihat</a>';
            if($row->status!='ditolak'&&$row->status!='selesai'){
            $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if($row->is_verified===null){
                $btn = $btn.'<li><a class="dropdown-item open_modal_tolak" data-link="'.route('pengajuan-info.tolak',$row).'">Tolak</a></li>';
                $btn = $btn.'<li><a class="dropdown-item open_modal_setuju" data-link="'.route('pengajuan-info.setuju',$row).'">Terima & Proses</a></li>';
            }
            if($row->is_verified==1){
                if($row->status=='diproses' && $row->biaya > 0){
                    $btn = $btn.'<li><a class="dropdown-item open_modal_bayar" data-link="'.route('pengajuan-info.bayar',$row).'">Pembayaran</a></li>';
                }
                else{
                    $btn = $btn.'<li><a class="dropdown-item open_modal_verif_selesai" data-link="'.route('pengajuan-info.selesai',$row).'">Selesai</a></li>';
                }
               
            }
                  
             $btn = $btn.'</ul></div>';
        }
             return $btn;
             
        })
            ->addColumn('identitas', function($row){
                return   $row->nama.' ['.$row->nik_pengaju.']';
            })
            ->filterColumn('identitas', function($query, $keyword) {
                $query->whereRaw("CONCAT(pengajuan_info_publik.nama,' [',pengajuan_info_publik.nik_pengaju,']')  like ?", ["%{$keyword}%"]);
            })
            ->addColumn('kontak', function($row){
                return   'Email: '.$row->email.' / Telp: '.$row->no_telp;
            })
            ->filterColumn('kontak', function($query, $keyword) {
                $query->whereRaw("CONCAT('Email: ',pengajuan_info_publik.email,' / Telp: ',pengajuan_info_publik.no_telp)  like ?", ["%{$keyword}%"]);
            })
            ->addColumn('pembiayaan', function($row){
                if($row->biaya&&$row->cara_bayar){
                    return   $row->biaya.'('.$row->cara_bayar.')';
                }
                
            })
            ->addIndexColumn() 
            ->rawColumns(['action','identitas','kontak','pembiayaan'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PengajuanInfoPublik $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengajuaninfopublik-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
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
                            var r = $('#pengajuaninfopublik-table tfoot tr');
                             $('#pengajuaninfopublik-table thead').append(r);
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index < 3) return;
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
            Column::make('created_at')->title('waktu permohonan'),
            Column::make('status'),
            Column::make('no_pendaftaran')->title('nomor'),
            Column::computed('identitas')
            ->searchable(true),
            Column::make('alamat')->title('alamat'),
            Column::computed('kontak')
            ->searchable(true),
            Column::make('tujuan'),
            Column::make('rincian'),
            Column::make('cara_perolehan')->title('Cara Perolehan'),
            Column::make('media_perolehan')->title('Bentuk Salinan'),
            Column::make('kuasa')->title('Penguasaan'),
            Column::make('penolakan')->title('Landasan Penolakan'),
            Column::make('biaya'),
            Column::make('cara_bayar')->title('Cara Pembayaran'),
            Column::make('keterangan'),
            Column::make('waktu')->title('waktu keputusan'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PengajuanInfoPublik_' . date('YmdHis');
    }
}
