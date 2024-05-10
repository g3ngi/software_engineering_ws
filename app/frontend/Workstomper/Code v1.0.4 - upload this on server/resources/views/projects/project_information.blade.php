@extends('layout')

@section('title')
<?= get_label('project_details', 'Project details') ?>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between m-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{url('/home')}}"><?= get_label('home', 'Home') ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{url('/projects')}}"><?= get_label('projects', 'Projects') ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{url('/projects/information/'.$project->id)}}">{{$project->title}}</a>
                    </li>
                    <li class="breadcrumb-item active"><?= get_label('view', 'View') ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{url('/projects/tasks/create/' . $project->id)}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('create_task', 'Create task') ?>"><i class="bx bx-plus"></i></button></a>
            <a href="{{url('/projects/tasks/draggable/' . $project->id)}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('tasks', 'Tasks') ?>"><i class="bx bx-task"></i></button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="demo-inline-spacing">
                                @foreach ($tags as $tag)
                                <span class="badge bg-{{$tag->color}}">{{$tag->title}}</span>
                                @endforeach
                            </div>
                            <h2 class="fw-bold mt-4 mb-4">{{ $project->title }} <a href="javascript:void(0);" class="mx-2">
                                    <i class='bx {{$project->is_favorite ? "bxs" : "bx"}}-star favorite-icon text-warning' data-id="{{$project->id}}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="{{$project->is_favorite ? get_label('add_favorite', 'Click to remove from favorite') : get_label('remove_favorite', 'Click to mark as favorite')}}" data-favorite="{{$project->is_favorite ? 1 : 0}}"></i>
                                </a></h2>
                            <span class='badge bg-label-{{$project->status->color}} me-1'> {{$project->status->title}}</span>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="mb-3 text-center">
                                <label class="form-label" for="start_date"><?= get_label('users', 'Users') ?></label>
                                <?php
                                $users = $project->users;
                                if (count($users) > 0) { ?>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center flex-wrap justify-content-center">
                                        @foreach($users as $user)
                                        <li class="avatar avatar-sm pull-up" title="{{$user->first_name}} {{$user->last_name}}"><a href="/users/profile/{{$user->id}}" target="_blank">
                                                <img src="{{$user->photo ? asset('storage/' . $user->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$user->first_name}} {{$user->last_name}}">
                                            </a></li>
                                        @endforeach
                                    </ul>
                                <?php } else { ?>
                                    <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="mb-3 text-center">
                                <label class="form-label" for="end_date"><?= get_label('clients', 'Clients') ?></label>
                                <?php
                                $clients = $project->clients;
                                if (count($clients) > 0) { ?>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center flex-wrap justify-content-center">
                                        @foreach($clients as $client)
                                        <li class="avatar avatar-sm pull-up" title="{{$client->first_name}} {{$client->last_name}}"><a href="/clients/profile/{{$client->id}}" target="_blank">
                                                <img src="{{$client->photo ? asset('storage/' . $client->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$client->first_name}} {{$client->last_name}}">
                                            </a></li>
                                        @endforeach
                                    </ul>
                                <?php } else { ?>
                                    <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                            <div class="card h-100">
                                <span class="badge bg-label-info m-2"><?= get_label('reload_page_to_change_chart_colors', 'Reload the page to change chart colors') ?></span>
                                <div class="card-header d-flex align-items-center justify-content-between pt-3 pb-1">
                                    <div class="card-title mb-0">
                                        <h5 class="m-0 me-2"><?= get_label('task_statistics', 'Task statistics') ?></h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div id="taskStatisticsChart"></div>
                                    </div>
                                    <?php $total_tasks_count = 0; ?>
                                    <ul class="p-0 m-0">
                                        @foreach ($statuses as $status)
                                        <li class="d-flex mb-4 pb-1">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-{{$status->color}}"><i class="bx bx-task"></i></span>
                                            </div>
                                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <a href="/tasks?project={{$project->id}}&status={{ $status->id }}">
                                                        <h6 class="mb-0">{{ $status->title }}</h6>
                                                    </a>
                                                </div>
                                                <div class="user-progress">
                                                    <?php
                                                    $statusCount = $project->tasks->where('status_id', $status->id)->count();
                                                    $total_tasks_count += $statusCount;
                                                    ?>
                                                    <div class="status-count">
                                                        <small class="fw-semibold">{{$statusCount}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>

                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-menu"></i></span>
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h5 class="mb-0"><?= get_label('total', 'Total') ?></h5>
                                            </div>
                                            <div class="user-progress">
                                                <div class="status-count">
                                                    <h5 class="mb-0">{{$total_tasks_count}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <!-- "Starts at" card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="menu-icon tf-iconsbx bx bx-calendar-check bx-md text-success"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1"><?= get_label('starts_at', 'Starts at') ?></span>
                                    <h3 class="card-title mb-2">{{ format_date($project->start_date) }}</h3>
                                </div>
                            </div>
                            @php
                            use Carbon\Carbon;
                            $fromDate = Carbon::parse($project->from_date);
                            $toDate = Carbon::parse($project->to_date);
                            $duration = $fromDate->diffInDays($toDate) + 1;
                            @endphp
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="menu-icon tf-iconsbx bx bx-time bx-md text-primary"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1"><?= get_label('duration', 'Duration') ?></span>
                                    <h3 class="card-title mb-2">{{ $duration . ' day' . ($duration > 1 ? 's' : '') }}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 col-6 mb-4">
                            <!-- "Ends at" card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="menu-icon tf-icons bx bx-calendar-x bx-md text-danger"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1"><?= get_label('ends_at', 'Ends at') ?></span>
                                    <h3 class="card-title mb-2">{{ format_date($project->end_date) }}</h3>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class="menu-icon tf-icons bx bx-purchase-tag-alt bx-md text-warning"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1"><?= get_label('budget', 'Budget') ?></span>
                                    <h3 class="card-title mb-2">{{ !empty($project->budget) ? format_currency($project->budget) : '-' }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h5><?= get_label('description', 'Description') ?></h5>
                                    </div>
                                    <p>
                                        <!-- Add your project description here -->
                                        {{ ($project->description !== null && $project->description !== '') ? $project->description : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <input type="hidden" id="media_type_id" value="{{$project->id}}">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form class="form-horizontal" id="media-upload" action="{{url('/projects/upload-media')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <h4 class="mb-5"><?= get_label('project_media', 'Project media') ?></h4>
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
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <input type="hidden" id="data_type" value="project-media">
                    <table id="table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/projects/get-media/{{$project->id}}" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParamsProjectMedia">
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
        </div>
        @if ($auth_user->can('manage_milestones'))
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between m-4">
                        <h4 class="mb-5"><?= get_label('project_milestones', 'Project milestones') ?></h4>
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_milestone_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('create_milestone', 'Create milestone') ?>"><i class="bx bx-plus"></i></button></a>
                    </div>

                    <div class="row mt-4 mx-2">
                        <div class="mb-3 col-md-4">
                            <div class="input-group input-group-merge">
                                <input type="text" id="start_date_between" name="start_date_between" class="form-control" placeholder="<?= get_label('start_date_between', 'Start date between') ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <div class="input-group input-group-merge">
                                <input type="text" id="end_date_between" name="end_date_between" class="form-control" placeholder="<?= get_label('end_date_between', 'End date between') ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="status_filter" aria-label="Default select example">
                                <option value=""><?= get_label('select_status', 'Select status') ?></option>
                                <option value="incomplete"><?= get_label('incomplete', 'Incomplete') ?></option>
                                <option value="complete"><?= get_label('complete', 'Complete') ?></option>

                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="start_date_from" id="start_date_from">
                    <input type="hidden" name="start_date_to" id="start_date_to">

                    <input type="hidden" name="end_date_from" id="end_date_from">
                    <input type="hidden" name="end_date_to" id="end_date_to">


                    <input type="hidden" id="data_type" value="milestone">
                    <input type="hidden" id="data_table" value="project_milestones_table">
                    <table id="project_milestones_table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/projects/get-milestones/{{$project->id}}" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParamsProjectMilestones">
                        <thead>
                            <tr>
                                <th data-checkbox="true"></th>
                                <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th>
                                <th data-sortable="true" data-field="title"><?= get_label('title', 'Title') ?></th>
                                <th data-sortable="true" data-field="start_date"><?= get_label('start_date', 'Start date') ?></th>
                                <th data-sortable="true" data-field="end_date"><?= get_label('end_date', 'End date') ?></th>
                                <th data-sortable="true" data-field="cost"><?= get_label('cost', 'Cost') ?></th>
                                <th data-sortable="true" data-field="progress"><?= get_label('progress', 'Progress') ?></th>
                                <th data-sortable="true" data-field="status"><?= get_label('status', 'Status') ?></th>
                                <th data-sortable="true" data-field="description" data-visible="false"><?= get_label('description', 'Description') ?></th>
                                <th data-sortable="true" data-field="created_by" data-visible="false"><?= get_label('created_by', 'Created by') ?></th>
                                <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                                <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                                <th data-formatter="actionsFormatterProjectMilestones"><?= get_label('actions', 'Actions') ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @if ($auth_user->can('manage_activity_log'))
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-body">
                    <h4 class="mb-5"><?= get_label('project_activity_log', 'Project activity log') ?></h4>
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
                        <input type="hidden" id="type_id" value="{{$project->id}}">

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
        @endif
        <div class="modal fade" id="create_milestone_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form class="modal-content form-submit-event" action="{{url('/projects/store-milestone')}}" method="POST">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="dnr">
                    <input type="hidden" name="table" value="project_milestones_table">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('create_milestone', 'Create milestone') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-12 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('starts_at', 'Starts at') ?> <span class="asterisk">*</span></label>
                                    <input type="text" id="start_date" name="start_date" class="form-control" placeholder="" autocomplete="off">
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('ends_at', 'Ends at') ?> <span class="asterisk">*</span></label>
                                    <input type="text" id="end_date" name="end_date" class="form-control" placeholder="" autocomplete="off">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('status', 'Status') ?> <span class="asterisk">*</span></label>
                                    <select class="form-select" name="status">
                                        <option value="incomplete"><?= get_label('incomplete', 'Incomplete') ?></option>
                                        <option value="complete"><?= get_label('complete', 'Complete') ?></option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('cost', 'Cost') ?> <span class="asterisk">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                                        <input type="text" name="cost" class="form-control" placeholder="<?= get_label('please_enter_cost', 'Please enter cost') ?>">
                                    </div>
                                    <p class="text-danger text-xs mt-1 error-message"></p>
                                </div>

                            </div>
                            <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                            <textarea class="form-control" name="description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
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

        <div class="modal fade" id="edit_milestone_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form class="modal-content form-submit-event" action="{{url('/projects/update-milestone')}}" method="POST">
                    <input type="hidden" name="id" id="milestone_id">
                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="dnr">
                    <input type="hidden" name="table" value="project_milestones_table">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1"><?= get_label('update_milestone', 'Update milestone') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-12 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('title', 'Title') ?> <span class="asterisk">*</span></label>
                                    <input type="text" name="title" id="milestone_title" class="form-control" placeholder="<?= get_label('please_enter_title', 'Please enter title') ?>">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('starts_at', 'Starts at') ?> <span class="asterisk">*</span></label>
                                    <input type="text" id="update_milestone_start_date" name="start_date" class="form-control" placeholder="" autocomplete="off">
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('ends_at', 'Ends at') ?> <span class="asterisk">*</span></label>
                                    <input type="text" id="update_milestone_end_date" name="end_date" class="form-control" placeholder="" autocomplete="off">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('status', 'Status') ?> <span class="asterisk">*</span></label>
                                    <select class="form-select" id="milestone_status" name="status">
                                        <option value="incomplete"><?= get_label('incomplete', 'Incomplete') ?></option>
                                        <option value="complete"><?= get_label('complete', 'Complete') ?></option>
                                    </select>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('cost', 'Cost') ?> <span class="asterisk">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{$general_settings['currency_symbol']}}</span>
                                        <input type="text" name="cost" id="milestone_cost" class="form-control" placeholder="<?= get_label('please_enter_cost', 'Please enter cost') ?>">
                                    </div>
                                    <p class="text-danger text-xs mt-1 error-message"></p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="nameBasic" class="form-label"><?= get_label('progress', 'Progress') ?></label>
                                    <input type="range" name="progress" id="milestone_progress" class="form-range">
                                    <h6 class="mt-2 milestone-progress"></h6>
                                    <p class="text-danger text-xs mt-1 error-message"></p>
                                </div>

                            </div>
                            <label for="description" class="form-label"><?= get_label('description', 'Description') ?></label>
                            <textarea class="form-control" name="description" id="milestone_description" placeholder="<?= get_label('please_enter_description', 'Please enter description') ?>"></textarea>
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
    </div>
</div>
<?php

$titles = [];
$task_counts = [];
$bg_colors = [];
$total_tasks = 0;

$ran = array('#63ed7a', '#ffa426', '#fc544b', '#6777ef', '#FF00FF', '#53ff1a', '#ff3300', '#0000ff', '#00ffff', '#99ff33', '#003366', '#cc3300', '#ffcc00', '#ff00ff', '#ff9900', '#3333cc', '#ffff00');
$backgroundColor = array_rand($ran);
$d = $ran[$backgroundColor];
foreach ($statuses as $status) {

    $task_count = $project->tasks->where('status_id', $status->id)->count();
    array_push($task_counts, $task_count);

    array_push($titles, "'" . $status->title . "'");

    $k = array_rand($ran);
    $v = $ran[$k];
    array_push($bg_colors, "'" . $v . "'");
    $total_tasks += $task_count;
}
$titles = implode(",", $titles);
$task_counts = implode(",", $task_counts);
$bg_colors = implode(",", $bg_colors);
?>

<script>
    var labels = [<?= $titles ?>];
    var task_data = [<?= $task_counts ?>];
    var bg_colors = [<?= $bg_colors ?>];
    var total_tasks = [<?= $total_tasks ?>];
    //labels
    var total = '<?= get_label('total', 'Total') ?>';
    var add_favorite = '<?= get_label('add_favorite', 'Click to mark as favorite') ?>';
    var remove_favorite = '<?= get_label('remove_favorite', 'Click to remove from favorite') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_download = '<?= get_label('download', 'Download') ?>';
</script>

<script src="{{asset('assets/js/apexcharts.js')}}"></script>
<script src="{{asset('assets/js/pages/project-information.js')}}"></script>
@endsection