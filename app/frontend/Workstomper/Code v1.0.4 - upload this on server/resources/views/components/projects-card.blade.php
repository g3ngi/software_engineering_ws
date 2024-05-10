<!-- projects card -->
@php
$flag = (Request::segment(1) == 'home' || Request::segment(1) == 'users' || Request::segment(1) == 'clients') ? 0 : 1;
@endphp
<div class="<?= $flag == 1 ? 'card ' : '' ?>mt-4">
    @if($flag == 1)
    <div class="card-body">
        @endif
        <div class="table-responsive text-nowrap">
            {{$slot}}
            @if (is_countable($projects) && count($projects) > 0)
            <div class="row mt-4 mx-2">
                <div class="mb-3 col-md-3">
                    <div class="input-group input-group-merge">
                        <input type="text" id="project_start_date_between" name="start_date_between" class="form-control" placeholder="<?= get_label('start_date_between', 'Start date between') ?>" autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 col-md-3">
                    <div class="input-group input-group-merge">
                        <input type="text" id="project_end_date_between" name="project_end_date_between" class="form-control" placeholder="<?= get_label('end_date_between', 'End date between') ?>" autocomplete="off">
                    </div>
                </div>
                @if(isAdminOrHasAllDataAccess())
                @if(!isset($id) || (explode('_',$id)[0] !='client' && explode('_',$id)[0] !='user'))
                <div class="col-md-3">
                    <select class="form-select" id="projects_user_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_user', 'Select user') ?></option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select class="form-select" id="projects_client_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_client', 'Select client') ?></option>
                        @foreach ($clients as $client)
                        <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @endif
                <div class="col-md-3">
                    <select class="form-select" id="status_filter" aria-label="Default select example">
                        <option value=""><?= get_label('select_status', 'Select status') ?></option>
                        @foreach ($statuses as $status)
                        <option value="{{$status->id}}" @if(request()->has('status') && request()->status == $status->id) selected @endif>{{$status->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input type="hidden" name="project_start_date_from" id="project_start_date_from">
            <input type="hidden" name="project_start_date_to" id="project_start_date_to">

            <input type="hidden" name="project_end_date_from" id="project_end_date_from">
            <input type="hidden" name="project_end_date_to" id="project_end_date_to">

            <input type="hidden" id="is_favorites" value="{{$favorites??''}}">

            <input type="hidden" id="data_type" value="projects">
            <input type="hidden" id="data_table" value="projects_table">
            <div class="mx-2 mb-2">
                <table id="projects_table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/projects/listing/{{$id??''}}" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParamsProjects">
                    <thead>
                        <tr>
                            <th data-checkbox="true"></th>
                            <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th>
                            <th data-sortable="true" data-field="title"><?= get_label('title', 'Title') ?></th>
                            <th data-field="users" data-formatter="ProjectUserFormatter"><?= get_label('users', 'Users') ?></th>
                            <th data-field="clients" data-formatter="ProjectClientFormatter"><?= get_label('clients', 'Clients') ?></th>
                            <th data-sortable="true" data-field="start_date"><?= get_label('starts_at', 'Starts at') ?></th>
                            <th data-sortable="true" data-field="end_date"><?= get_label('ends_at', 'Ends at') ?></th>
                            <th data-sortable="true" data-field="end_date"><?= get_label('ends_at', 'Ends at') ?></th>
                            <th data-sortable="true" data-field="budget"><?= get_label('budget', 'Budget')?></th>
                            <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                            <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                            <th data-formatter="actionsFormatter"><?= get_label('actions', 'Actions') ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
            @else
            <?php
            $type = 'Projects'; ?>
            <x-empty-state-card :type="$type" />
            @endif
        </div>
        @if($flag == 1)
    </div>
    @endif
</div>

<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_not_assigned = '<?= get_label('not_assigned', 'Not assigned') ?>';
    var add_favorite = '<?= get_label('add_favorite', 'Click to mark as favorite') ?>';
    var remove_favorite = '<?= get_label('remove_favorite', 'Click to remove from favorite') ?>';
    var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
</script>
<script src="{{asset('assets/js/pages/project-list.js')}}"></script>