<?php

namespace App\DataTables;

use App\Models\Dusun;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class DusunBootDatatable extends DataTable
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
       
                $btn = '<a class="btn btn-sm btn-danger" href="'.route('m.lkd.dusun.destroy',$row).'" onclick="delDusun(this)">Hapus</a>';
             return $btn;
            
            
             
        })
        ->rawColumns(['action'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Dusun $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('dusun-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('admin.boot.getDusun'))
                    ->orderBy(1)
                    ->selectStyleSingle()
                    
                    ->paging(true)
                    ->parameters([
 
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['excel', 'print', 'reload'],
                        'responsive'    => true,
                        'auto-width'    =>false,
                        
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
                  
            Column::make('name')->title('Dusun'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Dusun_' . date('YmdHis');
    }
}
