<?php

namespace App\DataTables;

use App\Models\Admin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class AdminDataTable extends DataTable
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
            $btn = '<button class="btn btn-sm btn-success my-1 mx-1 open_modal_admin" value="'.$row->id.'"> Lihat</button>';
            $btn = $btn.'<div class="btn-group me-3">
                <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Aksi
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';              
            $btn = $btn.' <li><a class="dropdown-item open_modal_edit" data-admin="'.route('admin-list.get',$row).'"data-link="'.route('admin-list.update',$row).'">Update</a></li>';
            $btn = $btn.' <li><a class="dropdown-item open_modal_pass" data-link="'.route('admin-list.reset-pass',$row).'">Ubah Password</a></li>';
                if($row->id != auth()->guard('admin')->user()->id){
                    $btn = $btn.'<li><a class="dropdown-item" onclick="change(this)" href="'.route("admin-list.status",$row).'">'.($row->is_active?"Nonaktifkan":"Aktifkan").'</a></li>';
             
                }
                $btn = $btn.'</ul></div>';
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
    public function query(Admin $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('admin-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->selectStyleSingle()
                    ->paging(true)
                    ->parameters([
                        'dom'          => 'Blfrtip',
                        'buttons'      => ['pdf','excel', 'print', 'reload'],
                        'initComplete' => "function () {
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index == 0 || index == 1) return;
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
                                            select.add(new Option(d.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/g, '')));
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
            Column::make('username'),
            Column::make('nama'),
            Column::make('email'),
            Column::computed('status'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin_' . date('YmdHis');
    }
}
