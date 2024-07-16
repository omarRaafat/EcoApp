@extends('admin.layouts.master')
@section('title') @lang('admin.customer_details') @endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.customer_details')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label">@lang('admin.customer_name')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer['name'] }}">
                        </div>
                        <div class="col-md-6">
{{--                            <label for="email" class="form-label">@lang('admin.customer_email')</label>--}}
{{--                            <input disabled="disabled" readonly type="email" class="form-control" value="{{ $customer['email'] ?? null }}">--}}
                        </div>
                        <div class="col-md-4">
                            <label  class="form-label">@lang('admin.customer_identity')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer['identity'] }}">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">@lang('admin.customer_phone')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer['phone'] }}">
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress2" class="form-label">@lang('admin.customer_registration_date')</label>
                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ date('d-m-Y h:i', strtotime($customer['created_at'])) }}">
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <label for="inputAddress2" class="form-label">@lang('admin.customer_finances.payment_methods.wallet')</label>--}}
{{--                            <input disabled="disabled" readonly type="text" class="form-control" value="{{ $customer?->ownWallet?->amount_with_sar  . '  ' . __('translation.sar')}}">--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">@lang('admin.transactions')</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">@lang('admin.transaction_id')</th>
                                <th scope="col">@lang('admin.total_sub')</th>
                                <th scope="col">@lang('admin.transaction_status')</th>
                                <th scope="col">@lang('admin.transaction_date')</th>
                                <th scope="col">@lang('admin.transaction_show')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $key => $transaction)
                                <tr data-id="" >
                                    <th scope="row">{{ $transaction->id }}</th>
                                    <td>{{ $transaction->total .'  '. __('translation.sar') }}</td>
                                    <td>{{ App\Enums\OrderStatus::getStatus($transaction->status) }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($transaction->created_at)) }}</td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            @if ($transaction->type == 'order')
                                                <a class="btn btn-primary" href="{{ route('admin.transactions.show', ['transaction' => $transaction->id])  }}" >
                                                    @lang('admin.view_order')
                                                </a>
                                            @else
                                                <a class="btn btn-primary" href="{{ route('admin.service_transactions.show', ['transaction' => $transaction->id])  }}" >
                                                    @lang('admin.view_order')
                                                </a>
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$transactions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
