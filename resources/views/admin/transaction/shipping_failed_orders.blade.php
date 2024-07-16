@extends('admin.layouts.master')
@section('title')
    @lang('admin.shipping_failed')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #modalContent {
            max-width: 500px; 
            word-wrap: break-word;
        }
    </style>
@endsection
@section('content')
    @include("components.session-alert")
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="orderList">
                <div class="card-header border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.shipping_failed')</h5>
                    </div>
                </div>
                <div class="card-body border border-dashed border-end-0 border-start-0">
                    
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                <tr class="text-uppercase">
                                    <th>#</th>
                                    <th>ايدي الطلب</th>
                                    <th>شركة الشحن</th>
                                    <th>Request</th>
                                    <th>Response</th>
                                    <th>تاريخ تجهيز الطلب</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                @foreach($fails as $fail)
                                    <tr>
                                        <td>{{$fail->id}} </td>
                                        <td>{{$fail->order_id}} </td>
                                        <td>
                                            @if($fail->shipping == 'aramex')
                                                <span class="badge badge-info">أرامكس</span>
                                            @elseif($fail->shipping == 'spl')
                                                <span class="badge badge-info">سبل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm bg-warning btnshowreq"> عرض </button> 
                                            <div class="divshowreq d-none">
                                             {{ $fail->req }}
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm bg-warning btnshowres"> عرض </button> 
                                            <div class="divshowres d-none">
                                             {{ $fail->res }}
                                            </div>
                                        </td>
                                        <td>{{ date('Y-m-d H:i',strtotime($fail->created_at)) }}</td>
                                        <td>
                                            <form action="{{ route('admin.transactions.shipping_failed_orders.resend',$fail->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">إعادة الإرسال</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $fails->appends(request()->query())->links()  }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">عرض تفاصيل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent" style="direction: ltr">
                <!-- Content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $( ".btnshowreq").on("click", function() {
            $('#modalContent').html($(this).next('.divshowreq').html());
            $('#myModal').modal('show');
        });
        $( ".btnshowres").on("click", function() {
            $('#modalContent').html($(this).next('.divshowres').html());
            $('#myModal').modal('show');

        });
    </script>
	
@endsection
