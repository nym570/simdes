<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Vinkla\Hashids\Facades\Hashids;

class RolesDataTable extends DataTable
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
   
            $btn = ' <a href='.route("roles.show",Hashids::encode($row->id)).' class="btn btn-sm btn-success my-1"> Lihat</a>';
             return $btn;
             
        })
        ->rawColumns(['action'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('roles-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['pdf','excel', 'print'],
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
            Column::make('name')
                    ->title('nama'),
            Column::make('category')
                    ->title('kategori'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}
