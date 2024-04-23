<?php

namespace App\DataTables;

use App\Models\Aspirasi;
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

class AspirasiWargaDataTable extends DataTable
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
                $btn = '<a href='.route("pengajuan.warga.aspirasi.show",$row).' class="btn btn-sm btn-success my-1"> Lihat</a>';
                return $btn;
            })
            ->addColumn('updated', function($row){
                return   $row->updated_at->diffForHumans();
            })
            ->editColumn('status', function($row){
                return   $row->is_open?'open':'closed';
            })
            ->filterColumn('status', function($query, $keyword) {
                if($keyword=='open'){
                    $k = 1;
                }
                else{
                    $k=0;
                }
                $sql = "aspirasi.is_open  like ?";
                $query->whereRaw($sql, ["%{$k}%"]);
            })
            
            ->addIndexColumn() 
            ->rawColumns(['action','updated'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Aspirasi $model): QueryBuilder
    {
        return $model->newQuery()->with('user','balas_aspirasi')->where('user_id',auth()->user()->id);
        
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('aspirasi-table')
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
                            var r = $('#aspirasi-table tfoot tr');
                            $('#aspirasi-table thead').append(r);
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
            Column::computed('updated')
                ->exportable(false)
                  ->printable(false),
            Column::make('judul'),
            Column::make('kategori'),
            Column::make('tingkat'),
            Column::computed('status')
            ->searchable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Aspirasi_' . date('YmdHis');
    }
}
