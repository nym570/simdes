<?php

namespace App\DataTables;

use App\Models\Kepindahan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class KepindahanDataTable extends DataTable
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
            $btn = '<button class="btn btn-sm btn-success mx-1 my-1 verif_modal" onclick="verif(this)" href="'.route('dinamika.kepindahan.verifikasi',$row).'"> Lihat</button>';
            if(!$row->verifikasi){
                $btn = $btn. '<button class="btn btn-sm btn-warning mx-1 my-1 verif_modal" onclick="verif(this)" href="'.route('dinamika.kepindahan.verifikasi',$row).'"> Verif</button>';
            }
            

            // $btn = $btn.'<button class="btn btn-sm btn-dark my-1 open_modal" value="'.$row->kepala_dusun.'"> Kepala Dusun</button>';

             return $btn;
             
        })
        ->addColumn('jumlah orang', function($row){
            return count($row->dinamika);
        })
            ->addColumn('identitas', function($row){
                $identitas = "<ul>";
                foreach ($row->dinamika as $item){
                    $identitas = $identitas.'<li>'.$item->warga->nama.' ['.$item->nik.']</li>';
                    
                }
                $identitas = $identitas."</ul>";
                return $identitas;
            })
            ->addIndexColumn() 
            ->rawColumns(['action','identitas'])    
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Kepindahan $model): QueryBuilder
    {
        return $model->newQuery()->with(['dinamika.warga'])->select('kepindahan.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kepindahan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->paging(true)
                    ->parameters([
                        'dom'          => 'Blfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
                        'initComplete' => "function () {
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index == 0 || index == 1 ||index == 6) return;
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
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('waktu'),
            Column::make('penyebab'),
            Column::make('jenis'),
            Column::computed('jumlah orang'),
            Column::computed('identitas'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kepindahan_' . date('YmdHis');
    }
}
