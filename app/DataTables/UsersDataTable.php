<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Vinkla\Hashids\Facades\Hashids;

class UsersDataTable extends DataTable
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
   
            $btn = ' <a href='.route("users.show",$row).' class="btn btn-sm btn-success my-1"> Lihat</a>';

            $btn = $btn.' <button href='.route("users.status",$row).' class="btn btn-sm btn-'.($row->is_active?"dark":"primary").' my-1" onclick="change(this)">'.($row->is_active?"nonaktifkan":"aktifkan").' </button>';
            
            // $btn = $btn.'<form method="POST" action="'.route("password.email").'"  id="reset-form"><input type="hidden" name="_token" value="' . csrf_token() . '"> <input type="hidden" name="email" id="email"  value="'.$row->email.'" > <button type="submit" class="btn btn-sm btn-danger my-1"> Reset Password </button></form>';
             return $btn;
             
        })
        ->addColumn('status', function($row){
            return $row->is_active==true?'<span class="badge bg-info">Aktif</span>':'<span class="badge bg-secondary">Nonaktif</span>';
    })
        ->rawColumns(['action','status'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with(['warga'])->select('users.*')->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
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
            Column::make('username'),
            Column::make('nik'),
            Column::make('warga.nama')->title('nama')->data('warga.nama'),
            Column::make('email'),
            Column::computed('status'),
            
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
