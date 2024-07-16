<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\User;
use App\Models\Transaction;
use App\Enums\OrderStatus;
use App\Enums\ChargingTypes;
use App\Services\Eportal\Connection;
use Illuminate\Http\Request;

class OrderDataTable extends DataTable
{

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // dd('www');
        return (new EloquentDataTable($query))
            ->addColumn('action', function(Order $order){
                return '<td><ul class="list-inline hstack gap-2 mb-0">
                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                <a href="'.route('vendor.orders.show',$order->id).'" class="text-primary d-inline-block">
                                    <i class="ri-eye-fill fs-16"></i>
                                </a>
                            </li>
                        </ul></td>';
            })
            ->addColumn('code', function(Order $order) {
                return $order->code;
            })
            ->addColumn('status', function(Order $order) {
                $statusWithClass = OrderStatus::getStatusWithClass($order->status);
                return "<td class='status'><span class='{$statusWithClass['class']}'>{$statusWithClass['name']}</span></td>";
            })
            ->addColumn('payment_method', function(Order $order) {
                return '<td class="status"><span class="badge badge-soft-success text-uppercase">Master</span></td>';
            })
            ->addColumn('name', function(Order $order) {
                // return '<td>'. $this->info.'</td>';
                return '<td>'.  $order->customer_name ?? null .'</td>';
            })
            ->addColumn('type_of_shipping', function(Order $order) {
                return $order->orderVendorShippings()->where('vendor_id' , auth()->user()->vendor_id)->first()?->shippingType?->title;
            })

            ->addColumn('type_of_shipping_method', function(Order $order) {
                return $order->orderVendorShippings()->where('vendor_id' , auth()->user()->vendor_id)->first()?->shippingMethod?->name;
            })
            ->addColumn('order_total_products', function(Order $order) {
                return number_format($order->total, 2).' '.trans('translation.sar');
            })
            ->addColumn('order_shipping', function(Order $order) {
                return number_format($order->orderVendorShippings()->where('vendor_id' , auth()->user()->vendor_id)->sum('total_shipping_fees') , 2).' '.trans('translation.sar');
            })

            ->addColumn('total', function(Order $order) {
                return '<td>'. number_format($order->total + $order->orderVendorShippings()->where('vendor_id' , auth()->user()->vendor_id)->sum('total_shipping_fees') , 2).' '.trans('translation.sar').'</td>';
            })
            ->addColumn('created_at', function(Order $order) {
                return '<td class="date">' . $order->created_at->toFormattedDateString() .' <small class="text-muted">'.$order->created_at->format('g:i A').'</small></td>';
            })
            ->rawColumns(['created_at','action','name','status','total','payment_method'])
            ->filter(function ($query) {
                if (request()->has('search') && request()->search['value'] != null) {
                    $orders = $query->where('customer_name','LIKE','%'.request()->search['value'].'%')->orWhere('code' , request()->search['value']);
                    return $orders;
                }
            })
            ->orderColumn('total', function ($query, $order) {
                $query->orderBy('total', $order);
             })
             ->orderColumn('code', function ($query, $order) {
                $query->orderBy('code', $order);
             })
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', $order);
             })
             ->orderColumn('status', function ($query, $order) {
                $query->orderBy('status', $order);
             })
             ->filterColumn('total', function($query, $keyword) {
                    $query->where('total','>',$keyword);
                })
            ->setRowId('id')
            ->whitelist(['name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Request $request,Order $model): QueryBuilder
    {
        if (isset($request->customer) && $request->customer != 'all') {
            $model =$model->whereHas('transaction' , function($q) use ($request ,$model){
                    $q->where('customer_id' , $request->customer);
                })->orWhere('customer_name','like', '%' . $request->customer . '%');
        }
        if (isset($request->track_id) && $request->track_id != 'all') {
            $model = $model->whereHas('orderShip', function($q) use($request){
                $q->where('gateway_tracking_id' , $request->track_id);
            });
        }
        if (isset($request->code) && $request->code != 'all') {
            $model = $model->where('code' , $request->code);
        }

        if (isset($request->date_from)) {
            $model=$model->whereDate('created_at','>=',$request->date_from);
        }
        if (isset($request->date_to)) {
            $model=$model->whereDate('created_at','<=',$request->date_to);
        }
        if (isset($request->status) && $request->status != 'all') {
            if($request->status ==  OrderStatus::PAID){
                $model = $model->where(function($q){
                    $q->where('status' , OrderStatus::REGISTERD)->orWhere('status' , OrderStatus::PAID);
                });
            }

            $model=$model->where('status',$request->status);
        }

        if (isset($request->shipping_type) && $request->shipping_type != 'all') {
            $model = $model->whereHas('orderVendorShippings', function($q) use($request){
                $q->where('shipping_type_id' , $request->shipping_type);
            });
        }
        if (isset($request->shipping_method) && $request->shipping_method != 'all') {
                $model = $model->whereHas('orderVendorShippings', function($q) use($request){
                    $q->where('shipping_method_id' , $request->shipping_method);
                });
        }


        $model->where('vendor_id',auth()->user()->vendor_id);

        if(auth()->user()->type == 'vendor'){
            // dd('www');
            // $model->where('vendor_id' , auth()->user()->vendor_id);
            $request->count=10;
            return $model->newQuery()->where('vendor_id' , auth()->user()->vendor_id)->orderBy('id', 'desc');
        }else{
            $request->count=10;
            return $model->newQuery()->orderBy('id', 'desc');
        }

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('order-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(3)
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
            Column::make(['title'=>__('translation.code'),'data'=>"code"]),
            Column::make(['title'=>__('translation.name'),'data'=>"name"])->orderable(false),
            Column::make(['title'=>__('translation.order_created_at'),'data'=>"created_at"]),
            Column::make(['title'=>__('translation.type_of_shipping'),'data'=>"type_of_shipping"])->orderable(false),
            Column::make(['title'=>__('translation.type_of_shipping_method'),'data'=>"type_of_shipping_method"])->orderable(false),
            Column::make(['title'=>__('translation.order_total_products'),'data'=>"order_total_products"]),
            Column::make(['title'=>__('translation.order_shipping'),'data'=>"order_shipping"]),
            Column::make(['title'=>__('translation.total'),'data'=>"total"]),
            Column::make(['title'=>__('translation.order_status'),'data'=>"status"]),
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
        return 'Order_' . date('YmdHis');
    }
}
