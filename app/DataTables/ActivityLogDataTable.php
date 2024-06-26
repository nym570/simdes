<?php

namespace App\DataTables;

use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class ActivityLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('objek', function($row){
            $class = $row->log_name;
            if(is_null($row->subject)){
                return '';
            }
            else{
                if($class == 'Warga'){
                    return $row->subject->nik;
                }
                else if ($class == 'Admin' || $class == 'User'|| $class == 'Role'){
                     return $row->subject->username;
                }
                else {
                     return $row->subject->name;
                }
            }
            
           
        })
        
        ->addColumn('tanggal', function($row){
           
            return $row->created_at->toDateString();
        })

        
        ->addColumn('waktu', function($row){
           
            return $row->created_at->toTimeString();
        })
        ->addColumn('user', function($row){
            if(is_null($row->causer)){
                return '';
            }
            return $row->causer->username;
        })
        ->addColumn('properti', function($row){
            
            if(is_null($row->changes)){
                return '';
            }
            else{
                $prop = '';
                if($row->changes->has('attributes')){
                    $prop = $prop. 'Data : '.  json_encode($row->changes->get("attributes"),JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
                else if($row->changes->has('old')){
                    $prop = $prop. 'Data Lama : '.  json_encode($row->changes->get("old"),JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
                
                return $prop;
            }
            
           
            
        })
        ->rawColumns(['objek','subjek','tanggal']) 
        ->addIndexColumn() ;
        // ->setRowId('nik');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Activity $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('activity_log-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->selectStyleSingle()
                    ->paging(true)
                    ->parameters([
                        'lengthMenu' => [
                            [ 10, 25, 50 ],
                            [  '10','25', '50'  ]
                    ],    
                        'dom'          => 'Blrtip',
                        'buttons'      => ['excel', 'print', 'reload'],
                       
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
            Column::make('log_name')->title('log'),
            Column::computed('objek'),
            Column::computed('user'),
            
            Column::make('description')->title('deskripsi'),
            Column::computed('properti'),
            Column::computed('tanggal'),
            Column::computed('waktu'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ActivityLog_' . date('YmdHis');
    }
}
