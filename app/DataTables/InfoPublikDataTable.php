<?php

namespace App\DataTables;

use App\Models\InfoPublik;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class InfoPublikDataTable extends DataTable
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
   
            $btn = '<button class="btn btn-sm btn-success my-1 mx-1 open_modal_info" value="'.route('info-publik.get',$row).'" data-pdf="'.asset('/laraview/#../storage/'.$row->lampiran).'"> Lihat</button>';
            $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" onclick="change(this)" href="'.route("info-publik.status",$row).'">'.($row->is_show?"Sembunyikan":"Tampilkan").'</a></li>
                  <li><a class="dropdown-item" href="'.route('info-publik.delete',$row).'" onclick="del(this)">Hapus</a></li>
                  
                </ul>
              </div>';

             return $btn;
             
        })
            ->addColumn('status', function($row){
                return   $row->is_show?'ditampilkan':'disembunyikan';
            })
            ->addIndexColumn() 
            ->rawColumns(['action'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InfoPublik $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('infopublik-table')
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
            Column::make('judul'),
            Column::make('kategori'),
            Column::make('tahun'),
            Column::make('penguasaan')->title('perjabat penguasa'),
            Column::make('penanggung_jawab')->title('penanggung jawab'),
            Column::make('retensi'),
            Column::make('waktu')->title('waktu pembuatan'),
            Column::computed('status'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'InfoPublik_' . date('YmdHis');
    }
}
