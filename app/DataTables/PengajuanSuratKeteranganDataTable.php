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

class PengajuanSuratKeteranganDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->editColumn('status', function($row){
            return ($row->status=='diajukan'?'<span class="badge bg-dark">':($row->status=='diproses'?'<span class="badge bg-primary">':($row->status=='dapat diambil'?'<span class="badge bg-success">':($row->status=='selesai'?'<span class="badge bg-secondary">':'<span class="badge bg-danger">')))).$row->status.'</span>';
    })
    ->rawColumns(['status'])  
            ->addIndexColumn()    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SuratKeterangan $model): QueryBuilder
    {
        return $model->newQuery()->where('nik',auth()->user()->nik);
        
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengajuansuratketerangan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
                            var r = $('#pengajuansuratketerangan-table tfoot tr');
                            $('#pengajuansuratketerangan-table thead').append(r);
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
            
            Column::make('updated_at') ->title('last update')
                ->exportable(false)
                  ->printable(false),
                  Column::make('created_at')->title('tanggal pengajuan'),
                  Column::make('status'),
                  Column::make('tracking'),
            
            Column::make('jenis'),
            Column::make('tingkat'),
            Column::make('keperluan'),
            Column::make('no_surat')->title('no surat'),
            
                  
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
