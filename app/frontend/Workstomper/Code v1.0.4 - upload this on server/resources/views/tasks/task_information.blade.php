@extends('layout')

@section('title')
<?= get_label('task_details', 'Task details') ?>
@endsection

@section('content')
<div class="container-fluid">
    <div class="align-items-center d-flex justify-content-between m-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{url('/tasks')}}"><?= get_label('tasks', 'Tasks') ?></a>
                    </li>
                    <li class="breadcrumb-item">{{ $task->title }}</li>
                    <li class="breadcrumb-item active"><?= get_label('view', 'View') ?></li>
                </ol>
            </nav>
        </div>
        <div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">


                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-2">

                        <h2 class="card-header fw-bold">{{ $task->title }}</h2>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">


                    <div class="row">

                        <div class="mb-3 col-md-6">

                            <label class="form-label" for="start_date"><?= get_label('users', 'Users') ?></label>
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <?php
                                $users = $task->users;
                                $clients = $task->project->clients;
                                if (count($users) > 0) { ?>
                                    @foreach($users as $user)

                                    <li class="avatar avatar-sm pull-up" title="{{$user->first_name}} {{$user->last_name}}"><a href="/users/profile/{{$user->id}}" target="_blank">
                                            <img src="{{$user->photo ? asset('storage/' . $user->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$user->first_name}} {{$user->last_name}}">
                                        </a></li>
                                    @endforeach
                                <?php } else { ?>
                                    <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>

                                <?php }
                                ?>
                            </ul>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="end_date"><?= get_label('clients', 'Clients') ?></label>
                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <?php
                                if ($clients->count() > 0) { ?>

                                    @foreach($clients as $client)

                                    <li class="avatar avatar-sm pull-up" title="{{$client->first_name}} {{$client->last_name}}"><a href="/clients/profile/{{$client->id}}" target="_blank">
                                            <img src="{{$client->photo ? asset('storage/' . $client->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$client->first_name}} {{$client->last_name}}">
                                        </a></li>
                                    @endforeach
                                <?php } else { ?>
                                    <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>

                                <?php }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="project"><?= get_label('project', 'Project') ?></label>
                            <div class="input-group input-group-merge">
                                @php
                                $project = $task->project;
                                @endphp
                                <input class="form-control px-2" type="text" id="project" value="{{$project->title}}" readonly="">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="mb-3">
                            <label class="form-label" for="description"><?= get_label('description', 'Description') ?></label>
                            <div class="input-group input-group-merge">
                                <textarea class="form-control" id="description" name="description" rows="5" readonly>{{ $task->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="start_date"><?= get_label('starts_at', 'Starts at') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="text" name="start_date" class="form-control" placeholder="" value="{{ format_date($task->start_date)}}" readonly />
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="due-date"><?= get_label('ends_at', 'Ends at') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" name="due_date" placeholder="" value="{{ format_date($task->due_date)}}" readonly="">
                            </div>
                        </div>



                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="status"><?= get_label('status', 'Status') ?></label>
                            <div class="input-group input-group-merge">
                                <span class='badge bg-label-{{$task->status->color}} me-1'> {{$task->status->title}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="media_type_id" value="{{$task->id}}">
            <div class="card mb-4">
                <div class="card-body">
                    <form class="form-horizontal" id="media-upload" action="{{url('/tasks/upload-media')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <h4 class="mb-3"><?= get_label('task_media', 'Task media') ?></h4>
                            <div class="alert alert-primary alert-dismissible" role="alert"><?= $media_storage_settings['media_storage_type'] == 's3' ? get_label('storage_type_set_as_aws_s3', 'Storage type is set as AWS S3 storage') : get_label('storage_type_set_as_local', 'Storage type is set as local storage') ?>, <a href="/settings/media-storage" target="_blank"><?= get_label('click_here_to_change', 'Click here to change') ?></a>.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
                            <div class="dropzone dz-clickable" id="media-upload-dropzone">

                            </div>
                            <div class="form-group mt-4 text-center">
                                <button class="btn btn-primary" id="upload_media_btn"><?= get_label('upload', 'Upload') ?></button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="form-group" id="error_box">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <input type="hidden" id="data_type" value="task-media">
                    <table id="table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/tasks/get-media/{{$task->id}}" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParamsTaskMedia">
                        <thead>
                            <tr>
                                <th data-checkbox="true"></th>
                                <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th>
                                <th data-sortable="true" data-field="file"><?= get_label('file', 'File') ?></th>
                                <th data-sortable="true" data-field="file_name" data-visible="false"><?= get_label('file_name', 'File name') ?></th>
                                <th data-sortable="true" data-field="file_size"><?= get_label('file_size', 'File size') ?></th>
                                <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                                <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                                <th data-sortable="false" data-field="actions"><?= get_label('actions', 'Actions') ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="mb-5"><?= get_label('task_activity_log', 'Task activity log') ?></h4>
                    <div class="table-responsive text-nowrap">

                        <div class="row mt-4 mx-2">
                            <div class="mb-3 col-md-3">
                                <div class="input-group input-group-merge">
                                    <input type="text" id="activity_log_between_date" class="form-control" placeholder="<?= get_label('date_between', 'Date between') ?>" autocomplete="off">
                                </div>
                            </div>

                            @if(isAdminOrHasAllDataAccess())
                            <div class="col-md-3">
                                <select class="form-select" id="user_filter" aria-label="Default select example">
                                    <option value=""><?= get_label('select_user', 'Select user') ?></option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select class="form-select" id="client_filter" aria-label="Default select example">
                                    <option value=""><?= get_label('select_client', 'Select client') ?></option>
                                    @foreach ($clients as $client)
                                    <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="col-md-3">
                                <select class="form-select" id="activity_filter" aria-label="Default select example">
                                    <option value=""><?= get_label('select_activity', 'Select activity') ?></option>
                                    <option value="created"><?= get_label('created', 'Created') ?></option>
                                    <option value="updated"><?= get_label('updated', 'Updated') ?></option>
                                    <option value="duplicated"><?= get_label('duplicated', 'Duplicated') ?></option>
                                    <option value="deleted"><?= get_label('deleted', 'Deleted') ?></option>
                                </select>
                            </div>

                        </div>

                        <input type="hidden" id="activity_log_between_date_from">
                        <input type="hidden" id="activity_log_between_date_to">

                        <input type="hidden" id="data_type" value="activity-log">
                        <input type="hidden" id="type_id" value="{{$task->id}}">

                        <div class="mx-2 mb-2">
                            <table id="activity_log_table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/activity-log/list" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-checkbox="true"></th>
                                        <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th>
                                        <th data-sortable="true" data-visible="false" data-field="actor_id"><?= get_label('actor_id', 'Actor ID') ?></th>
                                        <th data-sortable="true" data-field="actor_name"><?= get_label('actor_name', 'Actor name') ?></th>
                                        <th data-sortable="true" data-visible="false" data-field="actor_type"><?= get_label('actor_type', 'Actor type') ?></th>
                                        <th data-sortable="true" data-visible="false" data-field="type_id"><?= get_label('type_id', 'Type ID') ?></th>
                                        <th data-sortable="true" data-visible="false" data-field="parent_type_id"><?= get_label('parent_type_id', 'Parent type ID') ?></th>
                                        <th data-sortable="true" data-field="activity"><?= get_label('activity', 'Activity') ?></th>
                                        <th data-sortable="true" data-field="type"><?= get_label('type', 'Type') ?></th>
                                        <th data-sortable="true" data-field="parent_type" data-visible="false"><?= get_label('parent_type', 'Parent type') ?></th>
                                        <th data-sortable="true" data-field="type_title"><?= get_label('type_title', 'Type title') ?></th>
                                        <th data-sortable="true" data-field="parent_type_title" data-visible="false"><?= get_label('parent_type_title', 'Parent type title') ?></th>
                                        <th data-sortable="true" data-visible="false" data-field="message"><?= get_label('message', 'Message') ?></th>
                                        <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                                        <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                                        <th data-formatter="actionsFormatter"><?= get_label('actions', 'Actions') ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var label_delete = '<?= get_label('delete', 'Delete') ?>';
    </script>
    <script src="{{asset('assets/js/pages/task-information.js')}}"></script>
    @endsection