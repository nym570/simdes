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
            ->addColumn('action', 'pengajuaninfopublik.action')
            ->addColumn('identitas', function($row){
                return   $row->nama.'<br>('.$row->nik_pengaju.')';
            })
            ->addColumn('kontak', function($row){
                return   'Email:'.$row->email.'<br>Telp: '.$row->no_telp;
            })
            ->addColumn('pembiayaan', function($row){
                if($row->biaya&&$row->cara_bayar){
                    return   $row->biaya.'<br>('.$row->cara_bayar.')';
                }
                
            })
            ->addColumn('waktu permohonan', function($row){
                if($row->biaya&&$row->cara_bayar){
                    return   $row->biaya.'<br>('.$row->cara_bayar.')';
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
                    ->orderBy(1)
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
            Column::computed('identitas'),
            Column::make('alamat')->title('alamat'),
            Column::computed('kontak'),
            Column::make('tujuan'),
            Column::make('rincian'),
            Column::make('cara_perolehan')->title('Cara Perolehan'),
            Column::make('media_perolehan')->title('Bentuk Salinan'),
            Column::make('kuasa')->title('Penguasaan'),
            Column::make('keterangan'),
            Column::computed('pembiayaan'),
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
