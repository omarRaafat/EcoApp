<?php

namespace App\DataTables;

use App\Models\Review;
use App\Models\ServiceReview;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceReviewDataTable extends DataTable
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
            ->addColumn('user_name',function(ServiceReview $review){
                if(!empty($review->client)){

                $user='<div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-light rounded p-1"><img src=" '.url($review->client->name).'" alt="" class="img-fluid d-block">
                        </div>
                    </div>
                <div class="flex-grow-1">
                <h5 class="fs-14 mb-1"><a href="#" class="text-dark">'.$review->client->name.'</a></h5> </div>
                </div>';
                }else{
                    $user='<div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-sm bg-light rounded p-1"><img src="#" alt="" class="img-fluid d-block">
                        </div>
                    </div>
                <div class="flex-grow-1">
                <h5 class="fs-14 mb-1"><a href="#" class="text-dark">'.''.'</a></h5> </div>
                </div>';
                }
                return $user;
            })
            ->addColumn('service',function(ServiceReview $review){
                $reviewService=$review->service;
                if ($reviewService != null) {
                    $category_name=($reviewService->category )? $reviewService->category->name:'';
                    $service=
                    '<div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm bg-light rounded p-1"><img src="'.url($reviewService->image).'" alt="" class="img-fluid d-block">
                            </div>
                        </div>
                    <div class="flex-grow-1">
                    <h5 class="fs-14 mb-1"><a href="#" class="text-dark">'.$reviewService->getTranslation('name','ar').'</a></h5><p class="text-muted mb-0"> <span class="fw-medium">' .$category_name. '</span></p> </div>
                    </div>';
                    return $service;
                }
                return '';

            })
            ->addColumn('rate',function(ServiceReview $review){

                $non_avg=5-$review->rate;
                $rating='<div class="text-warning fs-15">';
                    for($i= 0; $i < $review->rate ; $i++){
                        $rating.='<i class="ri-star-fill"></i>';
                    }
                    for($i= 0; $i < $non_avg ; $i++){
                        $rating.='<i class="ri-star-line"></i>';
                    }
                $rating.='</div>';
                return $rating;
            })
            ->addColumn('created_at', function(ServiceReview $review) {
                return '<td class="date">' . $review->created_at->toFormattedDateString() .' <small class="text-muted">'.$review->created_at->format('g:i A').'</small></td>';
            })
            ->rawColumns(['created_at','service','rate','user_name'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ServiceReview $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Request $request,ServiceReview $model): QueryBuilder
    {
        $model=$model->whereHas('service.vendor', function($q) {
                        return $q->where('id',auth()->user()->vendor_id);
                    });
        if (isset($request->date_from) && isset($request->date_to)) {
            $model=$model->whereDate('created_at','>=',Carbon::parse($request->date_from))->whereDate('created_at','<=',Carbon::parse($request->date_to));
        }
        if (isset($request->service_id) && $request->service_id != 'all') {
            $model=$model->where('service_id',$request->service_id);
        }
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
                    ->setTableId('review-table')
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
            Column::make(['title'=>__('translation.user_name'),'data'=>"user_name"]),
            Column::make(['title'=>__('translation.service'),'data'=>"service"]),
            Column::make(['title'=>__('translation.rate'),'data'=>"rate"]),
            Column::make(['title'=>__('translation.comment'),'data'=>"comment"]),
            Column::make(['title'=>__('translation.created_at'),'data'=>"created_at"]),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Review_' . date('YmdHis');
    }
}
