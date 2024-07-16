<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function(User $user){
                return '<ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="'.route('vendor.users.edit',$user->id).'" class="text-success d-inline-block">
                                    <i class="ri-edit-box-fill fs-16"></i>
                                </a>
                            </li>
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="#" data-id='.$user->id.' data-bs-toggle="modal" data-bs-target="#removeItemModal" onclick="showDeleteModal('.$user->id.')" class="text-danger d-inline-block">
                                    <i class="ri-delete-bin-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->addColumn('created_at', function(User $user) {
                return '<td class="date">' . $user->created_at->toFormattedDateString() .' <small class="text-muted">'.$user->created_at->format('g:i A').'</small></td>';
            })
            ->rawColumns(['created_at','action'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('vendor_id',auth()->user()->vendor_id)->where('type','sub-vendor')->whereNotIn('id',[auth()->user()->id])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                    ])
                    ->language(['url'=>'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json']);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make(['title'=>__('translation.name'),'data'=>"name"]),
            Column::make(['title'=>__('translation.email'),'data'=>"email"]),
            Column::make(['title'=>__('translation.phone'),'data'=>"phone"]),
            Column::make(['title'=>__('translation.user_created_at'),'data'=>"created_at"]),
            Column::make(['title'=>__('translation.action'),'data'=>"action"])
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
