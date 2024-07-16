<div>
    <!-- Modal -->
    @if ($modalOpen)
        <div class="base-modal-bg">
            <div class="modal fade" wire:ignore.self data-bs-backdrop="false" id="questionnaireModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow modal-question-content">
                        <div class="modal-header">
                            <h5 class="modal-title">الرجاء تحديث البيانات</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    @lang('admin.name_in_bank')
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="username" wire:model='name_in_bank'>
                            </div>

                            @error('name_in_bank')
                                <div class="mt-1">
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" wire:click="store">حفظ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
        window.onload = () => {
            const myModal = new bootstrap.Modal(document.getElementById('questionnaireModal'))
            myModal.show();
        }
    </script>
    <style>
        .base-modal-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999999999999;
        }
    </style>
</div>
