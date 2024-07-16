@extends('admin.layouts.master')
@section('title')
    @lang('admin.settings.manage_settings')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="productClasses">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.settings.manage_settings')</h5>

                    </div>
                    <hr>
                </div>
                <div class="card-body pt-0 container">
                    <div>
                        <div class="table-responsive table-card mb-1 row">
                            <table class="table table-nowrap align-middle" id="recipesTable">


                                    @if ($settings->count() > 0)
                                    <form action="{{route('admin.settings.update-all')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @php $type= $settings[0]->type; @endphp
                                        @foreach($settings as $setting)
                                        @if ($type != $setting->type)
                                            @php
                                            $type = $setting->type

                                            @endphp
                                            <hr>
                                        @endif
                                        @switch($setting->input_type)
                                        @case('text')

                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="useremail" class="form-label">@lang('translation.phone') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ old('phone') }}" id="userphone"
                                                placeholder="@lang('translation.phone_placeholder')" required>
                                            @error('phone')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="text-danger">
                                                Please enter email
                                            </div>
                                        </div> --}}

                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                class="text-danger">*</span></label>
                                            <textarea id="editor" rows="6" id="{{$setting->key}}" class="form-control @error('{{$setting->key}}') is-invalid @enderror"
                                            name="{{$setting->key}}"  >{!! $setting->value !!}</textarea>
                                            @error($setting->key)
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                            @break
                                        @case('date')




                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                class="text-danger">*</span></label>
                                            <input  id="{{$setting->key}}" type="date" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >

                                            @error($setting->key)
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>



                                            @break
                                        @case('image')

                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} </label>
                                            <input  id="{{$setting->key}}" type="file" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >
                                            @if($setting->value && $setting->input_type == 'image')
                                                        <a target="_blank" href="{{ ossStorageUrl($setting->value) }}">
                                                            Show
                                                        </a>
                                            @endif
                                            @error($setting->key)
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                            @break
                                        @case('pdf')
                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} </label>
                                            <input  id="{{$setting->key}}" type="file" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >
                                            @if($setting->value && $setting->input_type == 'pdf')
                                                        <a target="_blank" href="{{ url($setting->value) }}">
                                                            Show
                                                        </a>
                                            @endif
                                            @error($setting->key)
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                            @break
                                        @case('email')
                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                class="text-danger">*</span></label>
                                            <input  id="{{$setting->key}}" type="email" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >
                                            @error($setting->key)
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                            @break
                                        @case('phone')

                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                class="text-danger">*</span></label>
                                            <input  id="{{$setting->key}}" type="phone" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >

                                            @error($setting->key)
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                            @break
                                        @case('whatsapp')

                                            <div class="col-md-6 mb-3">
                                                <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                    class="text-danger">*</span></label>
                                                <input  id="{{$setting->key}}" type="phone" class="form-control" class="form-control @error('{{$setting->key}}') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >

                                                @error($setting->key)
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                                @break
                                        @default
                                        <div class="col-md-6 mb-3">
                                            <label for="{{$setting->key}}" class="form-label">{{$setting->desc}} <span
                                                class="text-danger">*</span></label>
                                            <input  id="{{$setting->key}}" type="text" class="form-control" class="form-control @error('') is-invalid @enderror" value="{{$setting->value}}" name="{{$setting->key}}" >

                                            @error($setting->key)
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    @endswitch



                                        @endforeach

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">@lang('translation.submit')</button>
                                        </div>
                                    </form>

                                    @endif
                            </table>
                        </div>
                    </div>
                    <div>
                        @if($errors->any())
                        <div id="validationsModal" class="modal show" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header p-5">

                                    </div>
                                    <div class="modal-body p-5 text-center">
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 20px;">
                                            <div>
                                                <i class="fa fa-times" style="
                                                    padding: 15px;
                                                    font-size: 25px;
                                                    background: #da534d;
                                                    border: 4px solid #b24950;
                                                    border-radius: 50px;
                                                    width: 60px;
                                                    height: 60px;
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    color: #fff;
                                                    "></i>
                                            </div>
                                            <div>
                                                <h3>حدث خطاء </h3>
                                                @error('value')
                                                    <p>{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-link link-primary fw-medium text-decoration-none"
                                        data-bs-dismiss="modal" id="validationErrors-close" onClick="displayModal()">
                                        <i class="ri-close-line me-1 align-middle"></i>
                                            @lang('admin.close')
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                               colors="primary:#25a0e2,secondary:#0ab39c"
                                               style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">@lang('admin.productClasses.no_result_found')</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/libs/list.js/list.js.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.js.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ URL::asset('assets/js/pages/ecommerce-order.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        @if($errors->any)
            $("#validationsModal").modal("toggle")
        @endif
        function submitEditForm(e) {
            e.preventDefault()
            console.log(e.)
        }
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

@endsection
