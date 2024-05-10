@extends('layout')

@section('title')
<?= get_label('create_role', 'Create role') ?>
@endsection
<?php

use Spatie\Permission\Models\Permission;
?>

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
                        <?= get_label('settings', 'Settings') ?>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{url('/settings/permission')}}"><?= get_label('permissions', 'Permissions') ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                        <?= get_label('create_role', 'Create role') ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-body">
            <form action="{{url('/roles/store')}}" class="form-submit-event" method="POST">
                <input type="hidden" name="redirect_url" value="/settings/permission">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label"><?= get_label('name', 'Name') ?> <span class="asterisk">*</span></label>
                        <input class="form-control" type="text" placeholder="<?= get_label('please_enter_role_name', 'Please enter role name') ?>" id="name" name="name">
                        @error('name')
                        <p class="text-danger text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for=""><?= get_label('data_access', 'Data Access') ?> (<small class="text-muted mt-2">If all data access is selected, user under this roles will have unrestricted access to all data, irrespective of any specific assignments or restrictions</small>)</label>
                        <div class="btn-group btn-group d-flex justify-content-center" role="group" aria-label="Basic radio toggle button group">

                            <input type="radio" class="btn-check" name="permissions[]" id="access_all_data" value="<?= Permission::where('name', 'access_all_data')->where('guard_name', 'web')->first()->id ?>">
                            <label class="btn btn-outline-primary" for="access_all_data"><?= get_label('all_data_access', 'All Data Access') ?></label>

                            <input type="radio" class="btn-check" name="permissions[]" id="access_allocated_data" value="0" checked>
                            <label class="btn btn-outline-primary" for="access_allocated_data"><?= get_label('allocated_data_access', 'Allocated Data Access') ?></label>

                        </div>
                    </div>
                </div>
                <hr class="mb-2" />

                <div class="table-responsive text-nowrap">
                    <table class="table my-2">
                        <thead>
                            <tr>

                                <th>
                                    <div class="form-check">
                                        <input type="checkbox" id="selectAllColumnPermissions" class="form-check-input">
                                        <label class="form-check-label" for="selectAllColumnPermissions"><?= get_label('select_all', 'Select all') ?></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop for modules -->
                            @foreach(config("taskhub.permissions") as $module => $permissions)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" id="selectRow{{$module}}" class="form-check-input row-permission-checkbox" data-module="{{$module}}">
                                        <label class="form-check-label" for="selectRow{{$module}}">{{$module}}</label>
                                    </div>
                                </td>
                                <!-- Loop for permissions under each module -->
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        @foreach($permissions as $permission)
                                        <div class="form-check mx-4">
                                            <input type="checkbox" name="permissions[]" value="<?php print_r(Permission::findByName($permission)->id); ?>" class="form-check-input permission-checkbox" data-module="{{$module}}">
                                            <label class="form-check-label text-capitalize"><?php print_r(substr($permission, 0, strpos($permission, "_"))); ?></label>
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>




                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2" id="submit_btn"><?= get_label('create', 'Create') ?></button>
                    <button type="reset" class="btn btn-outline-secondary"><?= get_label('cancel', 'Cancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection