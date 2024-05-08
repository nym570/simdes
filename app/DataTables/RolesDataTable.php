<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
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
        ->addColumn('users', function($row){
            $user = User::role($row->name)->pluck('username');
            if($user){
                $data = '<ul>';
                foreach($user as $item){
                    $data .= '<li>'.$item.'</li>';
                }
                
                $data .= '</ul>';
                return $data;
            }
            
    })
    ->filterColumn('users', function($query, $keyword) {
        $query->whereHas('users', function($q) use ($keyword) {
            $q->where('users.username','LIKE','%'.$keyword.'%');
        })->get();
    })
       
        ->rawColumns(['action','users'])    
        ->addIndexColumn() 
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery()->where('guard_name','web')->whereNotIn('name',['ketua rt','ketua rw','kepala dusun','kepala desa','warga'])->withCount('users')->with('users');
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
                    ->orderBy(3)
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
                            var r = $('#roles-table tfoot tr');
                            $('#roles-table thead').append(r);
                            this.api()
                                .columns()
                                .every(function (index) {
                                    if (index>=0) return;
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
                    Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->addClass('text-center'),
            Column::make('name')
                    ->title('nama'),
            Column::make('users_count')->title('jumlah')->data('users_count')->searchable(false),
            Column::computed('users')
            ->exportable(true)
                  ->printable(true)
                  ->searchable(true),
           
            
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
