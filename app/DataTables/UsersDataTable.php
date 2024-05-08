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
   
            $btn = ' <a href='.route("users.show",$row).' class="btn btn-sm btn-success my-1 mx-1"> Lihat</a>';

            $btn = $btn.'<div class="btn-group me-3">
            <button class="btn btn-sm btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Aksi
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">';        
            $btn = $btn.' <li><a class="dropdown-item open_modal_edit" data-user="'.route('users.get',$row).'"data-link="'.route('users.update',$row).'">Update</a></li>';
        $btn = $btn.'<li><a class="dropdown-item" data-email="'.$row->email.'" data-username="'.$row->username.'" href="'.route('password.email',$row).'" onclick="send(this)">Kirim Reset Password</a></li>';
        $btn = $btn.'<li><a class="dropdown-item" onclick="change(this)" href="'.route("users.status",$row).'">'.($row->is_active?"Nonaktifkan":"Aktifkan").'</a></li>';
            $btn = $btn.'</ul></div>';
            return $btn;
             
        })
        ->editColumn('status', function($row){
            return $row->is_active==true?'<span class="badge bg-info">Aktif</span>':'<span class="badge bg-secondary">Nonaktif</span>';
    })
    ->filterColumn('status', function($query, $keyword) {
        if(stripos('Aktif',$keyword)!==false){
            $k = 1;
        }
        else{
            $k=0;
        }
        $sql = "users.is_active  like ?";
        $query->whereRaw($sql, ["%{$k}%"]);
    })
    ->addColumn('roles', function($row){
        $role = $row->getRoleNames();
        $data = '';
        foreach($role as $item){
            $data .= '<small><span class="badge bg-primary">'.$item.'</span></small>';
        }
        return $data;
})
->filterColumn('roles', function($query, $keyword) {
    $query->whereHas('roles', function($q) use ($keyword) {
        $q->where('roles.name','LIKE','%'.$keyword.'%');
    })->get();
})
        ->rawColumns(['action','status','roles'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with(['warga']);
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
                            var r = $('#users-table tfoot tr');
                            $('#users-table thead').append(r);
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index <= 2) return;
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
                  Column::computed('roles')
                  ->exportable(true)
                  ->printable(true)
                  ->searchable(true),
            Column::make('username'),
            Column::make('nik'),
            Column::make('warga.nama')->title('nama')->data('warga.nama'),
            Column::make('email'),
            Column::make('status'),
            
            
            
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
