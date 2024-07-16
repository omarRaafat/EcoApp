@extends('admin.layouts.master')
@section('title')
    @lang('postHarvestServices.interior_construction_fields.add')
@endsection
@section('css')
    <style>
        #dynamic-inputs {
            display: none;
        }

        .input-container {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
    </style>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.post-harvest-services-departments.fields.store') }}" method="post"
                        class="needs-validation row" autocomplete="on" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="post_harvest_id" value="{{ $postHarvestDepartment->id }}" />
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">@lang('admin.categories.name')
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="type">@lang('postHarvestServices.interior_construction_fields.type')</label>
                                <select class="form-control" name="type" id="type" required
                                    onchange="handleChange(this)">
                                    <option value="text-area">
                                        {{ trans('postHarvestServices.interior_construction_fields.text-area') }}
                                    </option>
                                    <option value="checkbox">
                                        {{ trans('postHarvestServices.interior_construction_fields.checkbox') }}
                                    </option>
                                    <option value="dropdown-list">
                                        {{ trans('postHarvestServices.interior_construction_fields.dropdown-list') }}
                                    </option>
                                    <option value="integer">
                                        {{ trans('postHarvestServices.interior_construction_fields.integer') }}
                                    </option>
                                    <option value="from-to">
                                        {{ trans('postHarvestServices.interior_construction_fields.from-to') }}
                                    </option>
                                </select>
                                <div id="new-section"></div>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="is_required">@lang('postHarvestServices.interior_construction_fields.is_required')</label>
                                <select class="form-control" name="is_required" id="is_required" required>
                                    <option value="1">
                                        {{ trans('postHarvestServices.interior_construction_fields.yes') }}</option>
                                    <option value="0">
                                        {{ trans('postHarvestServices.interior_construction_fields.no') }}</option>
                                </select>
                                @error('is_required')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="depends_on_price">@lang('postHarvestServices.interior_construction_fields.depends_on_price')</label>
                                <select class="form-control" name="depends_on_price" id="depends_on_price" required>
                                    <option value="1">
                                        {{ trans('postHarvestServices.interior_construction_fields.yes') }}</option>
                                    <option value="0">
                                        {{ trans('postHarvestServices.interior_construction_fields.no') }}</option>
                                </select>
                                @error('depends_on_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="status">@lang('admin.categories.is_active')</label>
                                <div class="form-check form-switch form-switch-lg" dir="ltr">
                                    <input type="checkbox" name="status" class="form-check-input" id="is_active"
                                        value="active" @if (old('status') == 'active') checked @endif>
                                </div>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="dynamic-inputs" class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5>أدخل عناصر التحديد</h5>
                                    <button class="btn btn-success" type="button" onclick="addInput()">إضافة</button>
                                </div>

                                <div id="inputs-container">
                                    {{--  <div class="input-container" id="input-container-0">
                                        <input type="text" class="form-control me-4" name="values[]"
                                            placeholder="أدخل الاسم">
                                            @error('values')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        <button class="btn btn-success delete-button" type="button"
                                            onclick="deleteInput(this)" id="delete-button-0">حذف</button>
                                    </div>  --}}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab">
                                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                @lang('admin.create')
                            </button>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const handleChange = (e) => {
            const dynamicInputs = document.getElementById('dynamic-inputs')
            if (e.value == 'checkbox' || e.value == 'dropdown-list') {
                dynamicInputs.style.display = 'block'
                addInput()
            } else {
                dynamicInputs.style.display = 'none'
                const inputsContainer = document.getElementById('inputs-container')
                if (inputsContainer) inputsContainer.innerHTML = ""
            }
        }
        const addInput = () => {
            const idNumber = Math.floor(Math.random() * 1000000000000000000)
            const dynamicInputs = document.getElementById('inputs-container')
            const newDiv = document.createElement('div');
            newDiv.className = 'input-container'
            newDiv.id = `input-container-${idNumber}`

            const newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.placeholder = 'أدخل الاسم';
            newInput.className = 'form-control me-4'
            newInput.name = 'values[]'
            newInput.required = 'required'

            var newButton = document.createElement('button');
            newButton.textContent = 'حذف';
            newButton.type = 'button';
            newButton.className = 'btn btn-success delete-button';
            newButton.id = `delete-button-${idNumber}`;
            {{--  newButton.onclick = deleteInput;  --}}

            newDiv.appendChild(newInput);
            newDiv.appendChild(newButton);
            dynamicInputs.appendChild(newDiv);
            handleDeleteButtons()
        }

        const deleteInput = (e) => {
            const deleteButtons = document.querySelectorAll('.delete-button');
            if (deleteButtons && deleteButtons.length > 1) {
                const id = e.id ? e.id.slice(14) : e.target.id.slice(14)
                const element = document.getElementById(`input-container-${id}`)
                if (element) element.remove();
            }
        }

        const handleDeleteButtons = () => {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', deleteInput);
            });
        }
        handleDeleteButtons()
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
