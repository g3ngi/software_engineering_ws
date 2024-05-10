@if (Request::is('projects/*') || Request::is('tasks/*') || Request::is('status/*'))
<div class="modal fade" id="create_status_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/status/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_status', 'Create status') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="nameBasic" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="color" name="color">
                            <option class="badge bg-label-primary" value="primary" {{ old('color') == "primary" ? "selected" : "" }}>
                                <?= get_label('primary', 'Primary') ?>
                            </option>
                            <option class="badge bg-label-secondary" value="secondary" {{ old('color') == "secondary" ? "selected" : "" }}><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge bg-label-success" value="success" {{ old('color') == "success" ? "selected" : "" }}><?= get_label('success', 'Success') ?></option>
                            <option class="badge bg-label-danger" value="danger" {{ old('color') == "danger" ? "selected" : "" }}><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge bg-label-warning" value="warning" {{ old('color') == "warning" ? "selected" : "" }}><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge bg-label-info" value="info" {{ old('color') == "info" ? "selected" : "" }}><?= get_label('info', 'Info') ?></option>
                            <option class="badge bg-label-dark" value="dark" {{ old('color') == "dark" ? "selected" : "" }}><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_status_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('/status/update')}}" class="modal-content form-submit-event" method="POST">
            <input type="hidden" name="id" id="status_id">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_status', 'Update status') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="status_title" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="status_color" name="color" required>
                            <option class="badge bg-label-primary" value="primary">
                                <?= get_label('primary', 'Primary') ?>
                            </option>
                            <option class="badge bg-label-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge bg-label-success" value="success"><?= get_label('success', 'Success') ?></option>
                            <option class="badge bg-label-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge bg-label-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge bg-label-info" value="info"><?= get_label('info', 'Info') ?></option>
                            <option class="badge bg-label-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></label></button>
            </div>
        </form>
    </div>
</div>
@endif
@if (Request::is('projects/*') || Request::is('tags/*'))
<div class="modal fade" id="create_tag_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/tags/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_tag', 'Create tag') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="nameBasic" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="color" name="color">
                            <option class="badge bg-label-primary" value="primary" {{ old('color') == "primary" ? "selected" : "" }}>
                                <?= get_label('primary', 'Primary') ?>
                            </option>
                            <option class="badge bg-label-secondary" value="secondary" {{ old('color') == "secondary" ? "selected" : "" }}><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge bg-label-success" value="success" {{ old('color') == "success" ? "selected" : "" }}><?= get_label('success', 'Success') ?></option>
                            <option class="badge bg-label-danger" value="danger" {{ old('color') == "danger" ? "selected" : "" }}><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge bg-label-warning" value="warning" {{ old('color') == "warning" ? "selected" : "" }}><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge bg-label-info" value="info" {{ old('color') == "info" ? "selected" : "" }}><?= get_label('info', 'Info') ?></option>
                            <option class="badge bg-label-dark" value="dark" {{ old('color') == "dark" ? "selected" : "" }}><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_tag_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="/tags/update" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="id" id="tag_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_tag', 'Update tag') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="tag_title" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="tag_color" name="color">
                            <option class="badge bg-label-primary" value="primary">
                                <?= get_label('primary', 'Primary') ?>
                            </option>
                            <option class="badge bg-label-secondary" value="secondary"><?= get_label('secondary', 'Secondary') ?></option>
                            <option class="badge bg-label-success" value="success"><?= get_label('success', 'Success') ?></option>
                            <option class="badge bg-label-danger" value="danger"><?= get_label('danger', 'Danger') ?></option>
                            <option class="badge bg-label-warning" value="warning"><?= get_label('warning', 'Warning') ?></option>
                            <option class="badge bg-label-info" value="info"><?= get_label('info', 'Info') ?></option>
                            <option class="badge bg-label-dark" value="dark"><?= get_label('dark', 'Dark') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></label></button>
            </div>
        </form>
    </div>
</div>
@endif
@if (Request::is('home') || Request::is('todos'))
<div class="modal fade" id="create_todo_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/todos/store')}}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_todo', 'Create todo') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('priority', 'Priority') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" name="priority">
                            <option value="low" {{ old('priority') == "low" ? "selected" : "" }}><?= get_label('low', 'Low') ?></option>
                            <option value="medium" {{ old('priority') == "medium" ? "selected" : "" }}><?= get_label('medium', 'Medium') ?></option>
                            <option value="high" {{ old('priority') == "high" ? "selected" : "" }}><?= get_label('high', 'High') ?></option>
                        </select>
                    </div>
                </div>
                <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_todo_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('/todos/update')}}" class="modal-content form-submit-event" method="POST">
            <input type="hidden" name="id" id="todo_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_todo', 'Update todo') ?></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="todo_title" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('priority', 'Priority') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="todo_priority" name="priority">
                            <option value="low"><?= get_label('low', 'Low') ?></option>
                            <option value="medium"><?= get_label('medium', 'Medium') ?></option>
                            <option value="high"><?= get_label('high', 'High') ?></option>
                        </select>
                    </div>
                </div>
                <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                <textarea class="form-control" id="todo_description" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></span></button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="modal fade" id="default_language_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2"><?= get_label('confirm', 'Confirm!') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= get_label('set_primary_lang_alert', 'Are you want to set as your primary language?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-primary" id="confirm"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="leaveWorkspaceModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= get_label('confirm_leave_workspace', 'Are you sure you want leave this workspace?') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-danger" id="confirm"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create_language_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/settings/languages/store')}}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_language', 'Create language') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="For Example: English" />
                        @error('name')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('code', 'Code') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="code" placeholder="For Example: en" />
                        @error('code')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>
@if (Request::is('leave-requests') || Request::is('leave-requests/*'))
<div class="modal fade" id="create_leave_request_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/leave-requests/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="table" value="lr_table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_leave_requet', 'Create leave request') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    @if (is_admin_or_leave_editor())
                    <label class="form-label" for="user_id"><?= get_label('select_user', 'Select user') ?> <span class="asterisk">*</span></label>
                    <div class="col-12 mb-3">
                        <select class="form-select" name="user_id">
                            <option value=""><?= get_label('select_user', 'Select user') ?></option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}" <?= $user->id == getAuthenticatedUser()->id ? 'selected' : '' ?>>{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-5 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('leave_from_date', 'Leave from date') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="start_date" name="from_date" class="form-control" placeholder="" autocomplete="off">
                    </div>
                    <div class="col-5 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('leave_to_date', 'Leave to date') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="end_date" name="to_date" class="form-control" placeholder="" autocomplete="off">
                    </div>
                    <div class="col-2 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('days', 'Days') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="total_days" class="form-control" value="1" placeholder="" disabled>
                    </div>
                </div>
                <label for="description" class="form-label"><?= get_label('leave_reason', 'Leave reason') ?> <span class="asterisk">*</span></label>
                <textarea class="form-control" name="reason" placeholder="<?= get_label('please_enter_leave_reason', 'Please enter leave reason') ?>"></textarea>
                @if (is_admin_or_leave_editor())
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="status" id="create_lr_pending" value="pending" checked>
                            <label class="btn btn-outline-primary" for="create_lr_pending"><?= get_label('pending', 'Pending') ?></label>

                            <input type="radio" class="btn-check" name="status" id="create_lr_approved" value="approved">
                            <label class="btn btn-outline-primary" for="create_lr_approved"><?= get_label('approved', 'Approved') ?></label>

                            <input type="radio" class="btn-check" name="status" id="create_lr_rejected" value="rejected">
                            <label class="btn btn-outline-primary" for="create_lr_rejected"><?= get_label('rejected', 'Rejected') ?></label>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="edit_leave_request_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/leave-requests/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="table" value="lr_table">
            <input type="hidden" name="id" id="lr_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_leave_request', 'Update leave request') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="status" id="update_lr_pending" value="pending" checked>
                            <label class="btn btn-outline-primary" for="update_lr_pending"><?= get_label('pending', 'Pending') ?></label>

                            <input type="radio" class="btn-check" name="status" id="update_lr_approved" value="approved">
                            <label class="btn btn-outline-primary" for="update_lr_approved"><?= get_label('approved', 'Approved') ?></label>

                            <input type="radio" class="btn-check" name="status" id="update_lr_rejected" value="rejected">
                            <label class="btn btn-outline-primary" for="update_lr_rejected"><?= get_label('rejected', 'Rejected') ?></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></label></button>
            </div>
        </form>
    </div>
</div>
@endif
@if (Request::is('contracts'))

<div class="modal fade" id="create_contract_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/contracts/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="table" value="contracts_table">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_contract', 'Create contract') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>">
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('value', 'Value') ?> <span class="asterisk">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                                <input type="text" name="value" class="form-control" placeholder="<?= get_label('please_enter_value', 'Please enter value') ?>">
                            </div>
                            <p class="text-danger text-xs mt-1 error-message"></p>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('starts_at', 'Starts at') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="start_date" name="start_date" class="form-control" placeholder="" autocomplete="off">
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('ends_at', 'Ends at') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="end_date" name="end_date" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        @if(!isClient())
                        <label class="form-label" for=""><?= get_label('select_client', 'Select client') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" name="client_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <label class="form-label" for=""><?= get_label('select_project', 'Select project') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" name="project_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="form-label" for=""><?= get_label('select_contract_type', 'Select contract type') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" name="contract_type_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($contract_types as $type)
                                <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_contract_type_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_contract_type', 'Create contract type') ?>"><i class="bx bx-plus"></i></button></a>
                                <a href="/contracts/contract-types"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?= get_label('manage_contract_types', 'Manage contract types') ?>"><i class="bx bx-list-ul"></i></button></a>
                            </div>
                        </div>
                    </div>
                    <label for="description" class="form-label"><?= get_label('description', 'Description') ?> <span class="asterisk">*</span></label>
                    <textarea class="form-control" name="description" id="contract_description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_contract_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/contracts/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="table" value="contracts_table">
            <input type="hidden" id="contract_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_contract', 'Update contract') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>">
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('value', 'Value') ?> <span class="asterisk">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                                <input type="text" id="value" name="value" class="form-control" placeholder="<?= get_label('please_enter_value', 'Please enter value') ?>">
                            </div>
                            <p class="text-danger text-xs mt-1 error-message"></p>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('starts_at', 'Starts at') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="update_start_date" name="start_date" class="form-control" placeholder="" autocomplete="off">
                        </div>

                        <div class="col-6 mb-3">
                            <label for="nameBasic" class="form-label"><?= get_label('ends_at', 'Ends at') ?> <span class="asterisk">*</span></label>
                            <input type="text" id="update_end_date" name="end_date" class="form-control" placeholder="" autocomplete="off">
                        </div>

                        <label class="form-label" for=""><?= get_label('select_client', 'Select client') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" id="client_id" name="client_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($clients as $client)
                                <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="form-label" for=""><?= get_label('select_project', 'Select project') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" id="project_id" name="project_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="form-label" for=""><?= get_label('select_contract_type', 'Select contract type') ?> <span class="asterisk">*</span></label>
                        <div class="col-12 mb-3">
                            <select class="form-select" id="contract_type_id" name="contract_type_id">
                                <option value=""><?= get_label('please_select', 'Please select') ?></option>
                                @foreach ($contract_types as $type)
                                <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_contract_type_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title=" <?= get_label('create_contract_type', 'Create contract type') ?>"><i class="bx bx-plus"></i></button></a>
                                <a href="/contracts/contract-types"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="<?= get_label('manage_contract_types', 'Manage contract types') ?>"><i class="bx bx-list-ul"></i></button></a>
                            </div>
                        </div>
                    </div>
                    <label for="description" class="form-label"><?= get_label('description', 'Description') ?> <span class="asterisk">*</span></label>
                    <textarea class="form-control" name="description" id="update_contract_description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="modal fade" id="create_contract_type_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/contracts/store-contract-type')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_contract_type', 'Create contract type') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="type" placeholder="<?= get_label('please_enter_contract_type', 'Please enter contract type') ?>" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_contract_type_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/contracts/update-contract-type')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="update_contract_type_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_contract_type', 'Update contract type') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="type" id="contract_type" placeholder="<?= get_label('please_enter_contract_type', 'Please enter contract type') ?>" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>

@if (Request::is('payslips/create') || Request::is('payment-methods'))
<div class="modal fade" id="create_pm_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form class="modal-content form-submit-event" action="{{url('/payment-methods/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_payment_method', 'Create payment method') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_pm_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form class="modal-content form-submit-event" action="{{url('/payment-methods/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="pm_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_payment_method', 'Update payment method') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" id="pm_title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif

@if (Request::is('payslips/create') || Request::is('allowances'))
<div class="modal fade" id="create_allowance_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/allowances/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_allowance', 'Create allowance') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_allowance_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/allowances/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" name="id" id="allowance_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_allowance', 'Update allowance') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="allowance_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" id="allowance_amount" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif



@if (Request::is('payslips/create') || Request::is('deductions'))
<div class="modal fade" id="create_deduction_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/deductions/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_deduction', 'Create deduction') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <select id="deduction_type" name="type" class="form-select">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            <option value="amount"><?= get_label('amount', 'Amount') ?></option>
                            <option value="percentage"><?= get_label('percentage', 'Percentage') ?></option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3 d-none" id="amount_div">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                    <div class="col-md-12 mb-3 d-none" id="percentage_div">
                        <label class="form-label" for=""><?= get_label('percentage', 'Percentage') ?> <span class="asterisk">*</span></label>
                        <input class="form-control" type="number" name="percentage" placeholder="<?= get_label('please_enter_percentage', 'Please enter percentage') ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_deduction_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/deductions/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="deduction_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_deduction', 'Update deduction') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="deduction_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <select id="update_deduction_type" name="type" class="form-select">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            <option value="amount"><?= get_label('amount', 'Amount') ?></option>
                            <option value="percentage"><?= get_label('percentage', 'Percentage') ?></option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3" id="update_amount_div">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" id="deduction_amount" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                    <div class="col-md-12 mb-3" id="update_percentage_div">
                        <label class="form-label" for=""><?= get_label('percentage', 'Percentage') ?> <span class="asterisk">*</span></label>
                        <input class="form-control" type="number" id="deduction_percentage" name="percentage" placeholder="<?= get_label('please_enter_percentage', 'Please enter percentage') ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif



@if (Request::is('estimates-invoices/create') || Request::is('taxes') || Request::is('units') || Request::is('items'))
<div class="modal fade" id="create_tax_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/taxes/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_tax', 'Create tax') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <select id="deduction_type" name="type" class="form-select">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            <option value="amount"><?= get_label('amount', 'Amount') ?></option>
                            <option value="percentage"><?= get_label('percentage', 'Percentage') ?></option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3 d-none" id="amount_div">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                    <div class="col-md-12 mb-3 d-none" id="percentage_div">
                        <label class="form-label" for=""><?= get_label('percentage', 'Percentage') ?> <span class="asterisk">*</span></label>
                        <input class="form-control" type="number" name="percentage" placeholder="<?= get_label('please_enter_percentage', 'Please enter percentage') ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_tax_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/taxes/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="tax_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_tax', 'Update tax') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="tax_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('type', 'Type') ?> <span class="asterisk">*</span></label>
                        <select id="update_tax_type" name="type" class="form-select" disabled>
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            <option value="amount"><?= get_label('amount', 'Amount') ?></option>
                            <option value="percentage"><?= get_label('percentage', 'Percentage') ?></option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3" id="update_amount_div">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" id="tax_amount" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>" disabled>
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                    <div class="col-md-12 mb-3" id="update_percentage_div">
                        <label class="form-label" for=""><?= get_label('percentage', 'Percentage') ?> <span class="asterisk">*</span></label>
                        <input class="form-control" type="number" id="tax_percentage" name="percentage" placeholder="<?= get_label('please_enter_percentage', 'Please enter percentage') ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="create_unit_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/units/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_unit', 'Create unit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>


                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_unit_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/units/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="unit_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_unit', 'Update unit') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="unit_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" id="unit_description" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>



<div class="modal fade" id="create_item_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/items/store')}}" method="POST">
            @if (Request::is('items'))
            <input type="hidden" name="dnr">
            @else
            <input type="hidden" name="reload">
            @endif
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_item', 'Create item') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('price', 'Price') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="price" placeholder="<?= get_label('please_enter_price', 'Please enter price') ?>" />
                    </div>
                    @if(isset($units) && is_iterable($units))
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('unit', 'Unit') ?></label>
                        <select class="form-select" name="unit_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($units as $unit)
                            <option value="{{$unit->id}}">{{$unit->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif


                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="edit_item_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form class="modal-content form-submit-event" action="{{url('/items/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="item_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_item', 'Update item') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="item_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('price', 'Price') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="item_price" name="price" placeholder="<?= get_label('please_enter_price', 'Please enter price') ?>" />
                    </div>
                    @if(isset($units) && is_iterable($units))
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('unit', 'Unit') ?></label>
                        <select class="form-select" id="item_unit_id" name="unit_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($units as $unit)
                            <option value="{{$unit->id}}">{{$unit->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif


                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" id="item_description" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>


@endif


@if (Request::is('notes'))
<div class="modal fade" id="create_note_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/notes/store')}}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_note', 'Create note') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="nameBasic" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" name="color">
                            <option class="badge bg-label-success" value="info" {{ old('color') == "info" ? "selected" : "" }}><?= get_label('green', 'Green') ?></option>
                            <option class="badge bg-label-warning" value="warning" {{ old('color') == "warning" ? "selected" : "" }}><?= get_label('yellow', 'Yellow') ?></option>
                            <option class="badge bg-label-danger" value="danger" {{ old('color') == "danger" ? "selected" : "" }}><?= get_label('red', 'Red') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('create', 'Create') ?></label></button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="edit_note_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/notes/update')}}" method="POST">
            <input type="hidden" name="id" id="note_id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_note', 'Update note') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="note_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" id="note_description" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('color', 'Color') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="note_color" name="color">
                            <option class="badge bg-label-info" value="info" {{ old('color') == "info" ? "selected" : "" }}><?= get_label('green', 'Green') ?></option>
                            <option class="badge bg-label-warning" value="warning" {{ old('color') == "warning" ? "selected" : "" }}><?= get_label('yellow', 'Yellow') ?></option>
                            <option class="badge bg-label-danger" value="danger" {{ old('color') == "danger" ? "selected" : "" }}><?= get_label('red', 'Red') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?></label>
                </button>
                <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('update', 'Update') ?></label></button>
            </div>
        </form>
    </div>
</div>



@endif


<div class="modal fade" id="deleteAccountModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= get_label('delete_account_alert', 'Are you sure you want to delete your account?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <form id="formAccountDeactivation" action="/account/destroy/{{getAuthenticatedUser()->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><?= get_label('yes', 'Yes') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> '</button>
            </div>
            <div class="modal-body">
                <p><?= get_label('delete_alert', 'Are you sure you want to delete?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-danger" id="confirmDelete"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteSelectedModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> '</button>
            </div>
            <div class="modal-body">
                <p><?= get_label('delete_selected_alert', 'Are you sure you want to delete selected record(s)?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-danger" id="confirmDeleteSelections"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="duplicateModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= get_label('duplicate_warning', 'Are you sure you want to duplicate?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>

                <button type="submit" class="btn btn-primary" id="confirmDuplicate"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="timerModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel2"><?= get_label('time_tracker', 'Time tracker') ?></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <div class="stopwatch">
                        <div class="stopwatch_time">
                            <input type="text" name="hour" id="hour" value="00" class="form-control stopwatch_time_input" readonly>
                            <div class="stopwatch_time_lable"><?= get_label('hours', 'Hours') ?></div>
                        </div>
                        <div class="stopwatch_time">
                            <input type="text" name="minute" id="minute" value="00" class="form-control stopwatch_time_input" readonly>
                            <div class="stopwatch_time_lable"><?= get_label('minutes', 'Minutes') ?></div>
                        </div>
                        <div class="stopwatch_time">
                            <input type="text" name="second" id="second" value="00" class="form-control stopwatch_time_input" readonly>
                            <div class="stopwatch_time_lable"><?= get_label('second', 'Second') ?></div>
                        </div>
                    </div>
                    <div class="selectgroup selectgroup-pills d-flex justify-content-around mt-3">
                        <label class="selectgroup-item">
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('start', 'Start') ?>" id="start" onclick="startTimer()"><i class="bx bx-play"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('stop', 'Stop') ?>" id="end" onclick="stopTimer()"><i class="bx bx-stop"></i></span>
                        </label>
                        <label class="selectgroup-item">
                            <span class="selectgroup-button selectgroup-button-icon" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('pause', 'Pause') ?>" id="pause" onclick="pauseTimer()"><i class="bx bx-pause"></i></span>
                        </label>
                    </div>
                    <div class="form-group mb-0 mt-3">
                        <label class="label"><?= get_label('message', 'Message') ?>:</label>
                        <textarea class="form-control" id="time_tracker_message" placeholder="<?= get_label('please_enter_your_message', 'Please enter your message') ?>" name="message"></textarea>
                    </div>
                </div>
                @if (getAuthenticatedUser()->can('manage_timesheet'))
                <div class="modal-footer justify-content-center">
                    <a href="/time-tracker" class="btn btn-primary"><i class="bx bxs-time"></i> <?= get_label('view_timesheet', 'View timesheet') ?></a>

                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stopTimerModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2"><?= get_label('warning', 'Warning!') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> '</button>
            </div>
            <div class="modal-body">
                <p><?= get_label('stop_timer_alert', 'Are you sure you want to stop the timer?') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" class="btn btn-danger" id="confirmStop"><?= get_label('yes', 'Yes') ?></button>
            </div>
        </div>
    </div>
</div>
@if (Request::is('estimates-invoices/create') || preg_match('/^estimates-invoices\/edit\/\d+$/', Request::path()))
<div class="modal fade" id="edit-billing-address" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_billing_details', 'Update billing details') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> '</button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('name', 'Name') ?> <span class="asterisk">*</span></label>
                        <input name="update_name" id="update_name" class="form-control" placeholder="<?= get_label('please_enter_name', 'Please enter name') ?>" value="{{$estimate_invoice->name??''}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('contact', 'Contact') ?> <span class="asterisk">*</span></label>
                        <input name="update_contact" id="update_contact" class="form-control" placeholder="<?= get_label('please_enter_contact', 'Please enter contact') ?>" value="{{$estimate_invoice->phone??''}}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('address', 'Address') ?> <span class="asterisk">*</span></label>
                        <textarea class="form-control" placeholder="<?= get_label('please_enter_address', 'Please enter address') ?>" name="update_address" id="update_address">{{$estimate_invoice->address??''}}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('city', 'City') ?> <span class="asterisk">*</span></label>
                        <input name="update_city" id="update_city" class="form-control" placeholder="<?= get_label('please_enter_city', 'Please enter city') ?>" value="{{$estimate_invoice->city??''}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('state', 'State') ?> <span class="asterisk">*</span></label>
                        <input name="update_contact" id="update_state" class="form-control" placeholder="<?= get_label('please_enter_state', 'Please enter state') ?>" value="{{$estimate_invoice->city??''}}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('country', 'Country') ?> <span class="asterisk">*</span></label>
                        <input name="update_country" id="update_country" class="form-control" placeholder="<?= get_label('please_enter_country', 'Please enter country') ?>" value="{{$estimate_invoice->country??''}}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('zip_code', 'Zip code') ?> <span class="asterisk">*</span></label>
                        <input name="update_zip_code" id="update_zip_code" class="form-control" placeholder="<?= get_label('please_enter_zip_code', 'Please enter zip code') ?>" value="{{$estimate_invoice->zip_code??''}}">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="button" class="btn btn-primary" id="apply_billing_details"><?= get_label('apply', 'Apply') ?></button>
            </div>
        </div>
    </div>
</div>
@endif

@if (Request::is('expenses') || Request::is('expenses/*'))
<div class="modal fade" id="create_expense_type_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/expenses/store-expense-type')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_expense_type', 'Create expense type') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col mb-3">
                        <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_expense_type_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content form-submit-event" action="{{url('/expenses/update-expense-type')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="update_expense_type_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_expense_type', 'Update expense type') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" id="expense_type_title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col mb-3">
                        <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                        <textarea class="form-control" name="description" id="expense_type_description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@if (Request::is('expenses'))
<div class="modal fade" id="create_expense_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/expenses/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_expense', 'Create expense') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('expense_type', 'Expense type') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" name="expense_type_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($expense_types as $type)
                            <option value="{{$type->id}}">{{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('user', 'User') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" name="user_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('expense_date', 'Expense date') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="expense_date" name="expense_date" class="form-control" placeholder="" autocomplete="off">
                    </div>
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('note', 'Note') ?></label>
                        <textarea class="form-control" name="note" placeholder="<?= get_label('please_enter_note_if_any', 'Please enter note if any') ?>"></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="edit_expense_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/expenses/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="update_expense_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_expense', 'Update expense') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                        <input type="text" class="form-control" id="expense_title" name="title" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>" />
                    </div>
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('expense_type', 'Expense type') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="expense_type_id" name="expense_type_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($expense_types as $type)
                            <option value="{{$type->id}}">{{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('user', 'User') ?> <span class="asterisk">*</span></label>
                        <select class="form-select" id="expense_user_id" name="user_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" id="expense_amount" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('expense_date', 'Expense date') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="update_expense_date" name="expense_date" class="form-control" placeholder="" autocomplete="off">
                    </div>
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('note', 'Note') ?></label>
                        <textarea class="form-control" id="expense_note" name="note" placeholder="<?= get_label('please_enter_note_if_any', 'Please enter note if any') ?>"></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif
@endif

@if (Request::is('payments'))
<div class="modal fade" id="create_payment_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/payments/store')}}" method="POST">
            <input type="hidden" name="dnr">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_payment', 'Create payment') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('user', 'User') ?></label>
                        <select class="form-select" name="user_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('invoice', 'Invoice') ?></label>
                        <select class="form-select" name="invoice_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($invoices as $invoice)
                            <option value="{{$invoice->id}}">{{get_label('invoice_id_prefix', 'INVC-') . $invoice->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('payment_method', 'Payment method') ?></label>
                        <select class="form-select" name="payment_method_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($payment_methods as $pm)
                            <option value="{{$pm->id}}">{{$pm->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('payment_date', 'Payment date') ?> <span class="asterisk">*</span></label>
                        <input type="text" id="payment_date" name="payment_date" class="form-control" placeholder="" autocomplete="off">
                    </div>
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('note', 'Note') ?></label>
                        <textarea class="form-control" name="note" placeholder="<?= get_label('please_enter_note_if_any', 'Please enter note if any') ?>"></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('create', 'Create') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit_payment_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content form-submit-event" action="{{url('/payments/update')}}" method="POST">
            <input type="hidden" name="dnr">
            <input type="hidden" id="update_payment_id" name="id">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_payment', 'Update payment') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('user', 'User') ?></label>
                        <select class="form-select" name="user_id" id="payment_user_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('invoice', 'Invoice') ?></label>
                        <select class="form-select" name="invoice_id" id="payment_invoice_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($invoices as $invoice)
                            <option value="{{$invoice->id}}">{{get_label('invoice_id_prefix', 'INVC-') . $invoice->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col mb-3">
                        <label class="form-label"><?= get_label('payment_method', 'Payment method') ?></label>
                        <select class="form-select" name="payment_method_id" id="payment_pm_id">
                            <option value=""><?= get_label('please_select', 'Please select') ?></option>
                            @foreach ($payment_methods as $pm)
                            <option value="{{$pm->id}}">{{$pm->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label" for=""><?= get_label('amount', 'Amount') ?> <span class="asterisk">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                            <input class="form-control" type="text" name="amount" id="payment_amount" placeholder="<?= get_label('please_enter_amount', 'Please enter amount') ?>">
                        </div>
                        <p class="text-danger text-xs mt-1 error-message"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('payment_date', 'Payment date') ?> <span class="asterisk">*</span></label>
                        <input type="text" name="payment_date" class="form-control" id="update_payment_date" placeholder="" autocomplete="off">
                    </div>
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label"><?= get_label('note', 'Note') ?></label>
                        <textarea class="form-control" name="note" id="payment_note" placeholder="<?= get_label('please_enter_note_if_any', 'Please enter note if any') ?>"></textarea>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <?= get_label('close', 'Close') ?>
                </button>
                <button type="submit" id="submit_btn" class="btn btn-primary"><?= get_label('update', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>
@endif