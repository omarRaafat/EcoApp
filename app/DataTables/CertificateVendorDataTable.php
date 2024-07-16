<?php

namespace App\DataTables;

use App\Models\CertificateVendor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use App\Enums\CertificateVendorApproval;

class CertificateVendorDataTable extends DataTable
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
            ->addColumn('action', function(CertificateVendor $certificateVendor){
                $edit='<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <div class="text-success d-inline-block">
                                    <i class="ri-edit-box-fill fs-16" style="opacity:0.4"></i>
                                </div>
                            </li>';
                if ($certificateVendor->approval!='approved') {
                    $edit='<li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="'.\URL::asset('/vendor/certificates/'.$certificateVendor->id.'/edit').'" class="text-success d-inline-block">
                                    <i class="ri-edit-box-fill fs-16"></i>
                                </a>
                            </li>';
                }
                
                return '<ul class="list-inline hstack gap-2 mb-0">
                            '.$edit.'
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="#" data-id='.$certificateVendor->id.' data-bs-toggle="modal" data-bs-target="#removeItemModal" onclick="showDeleteModal('.$certificateVendor->id.')" class="text-danger d-inline-block">
                                    <i class="ri-delete-bin-fill fs-16"></i>
                                </a>
                            </li>
                        </ul>';
            })
            ->addColumn('approval', function(CertificateVendor $certificateVendor) {
                $approval = CertificateVendorApproval::getStatusWithClass($certificateVendor->approval);
                return '<td class="status"><span class="'.$approval['class'].'">'.$approval['name'].'</span>';
            })
            ->addColumn('certificate_name', function(CertificateVendor $certificateVendor) {
                return $certificateVendor->certificate->title;
            })
            ->addColumn('certificate_file', function(CertificateVendor $certificateVendor) {
                return '<a href="/'.$certificateVendor->certificate_file.'"
                target="_blanck"><i class=" ri-eye-fill"></i></a>';
            })
            ->addColumn('expire_date', function(CertificateVendor $certificateVendor) {
                return '<td class="date">' . Carbon::parse($certificateVendor->expire_date)->toFormattedDateString() .' <small class="text-muted">'.Carbon::parse($certificateVendor->expire_date)->format('g:i A').'</small></td>';
            })
            ->rawColumns(['expire_date','action','approval','certificate_file'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CertificateVendor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CertificateVendor $model): QueryBuilder
    {
        $model = $model->where('vendor_id',auth()->user()->vendor_id);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('certificatevendor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print')
                    ])->language(['url'=>'https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json']);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make(['title'=>__('translation.certificate_name'),'data'=>"certificate_name"]),
            Column::make(['title'=>__('translation.approval'),'data'=>"approval"]),
            Column::make(['title'=>__('translation.certificate_file'),'data'=>"certificate_file"]),
            Column::make(['title'=>__('translation.expire_date'),'data'=>"expire_date"]),
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
        return 'CertificateVendor_' . date('YmdHis');
    }
}
