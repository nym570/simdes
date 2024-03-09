<?php

namespace App\DataTables;

use App\Models\RW;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class RWDataTable extends DataTable
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
            $btn = '<button class="btn btn-sm btn-dark my-1 mx-1 open_modal" data-kode="3"  data-name="'.$row->name.'" data-link="'.route('m.lkd.rw.get',$row).'"> Ketua RW</button>';

            
             return $btn;
             
        })
        ->rawColumns(['action'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RW $model): QueryBuilder
    {
        return $model->newQuery()->with(['dusun'])->select('rw.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('rw-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('m.lkd.getRW'))
                    ->selectStyleSingle()
                    ->parameters([
  
                        'dom'          => 'Bfrtip',
                        'responsive' => true,
                        'autoWidth' => false
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
            ->width(50)
            ->orderable(false)
            ->searchable(false),
       Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(150),     
            Column::make('name')
                  ->title('nama'),
            Column::make('dusun.name')->title('dusun')->data('dusun.name'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'RW_' . date('YmdHis');
    }
}
