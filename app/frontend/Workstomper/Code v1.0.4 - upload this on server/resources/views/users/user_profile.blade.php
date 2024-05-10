@extends('layout')

@section('title')
<?= get_label('user_profile', 'User profile') ?>
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
                        <a href="{{url('/users')}}"><?= get_label('users', 'Users') ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <?= $user->first_name . ' ' . $user->last_name; ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">

                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{$user->photo ? asset('storage/' . $user->photo) : asset('/photos/1.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <h4 class="card-header fw-bold">{{ $user->first_name }} {{$user->last_name}}</h4> <?= $user->status == 1 ? '<span class="badge bg-success">'.get_label('active', 'Active').'</span>' : '<span class="badge bg-danger">'.get_label('deactive', 'Deactive').'</span>' ?>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="phone"><?= get_label('phone_number', 'Phone number') ?></label>
                            <div class="input-group input-group-merge">
                                <input type="text" id="phone" name="phone" class="form-control" value="{{$user->phone}}" readonly />
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="email"><?= get_label('email', 'E-mail') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="exampleFormControlReadOnlyInput1" value="{{$user->email}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="role"><?= get_label('role', 'Role') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control text-capitalize" type="text" id="role" value="{{$user->getRoleNames()->first()}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="address"><?= get_label('address', 'Address') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="address" value="{{$user->address}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="city"><?= get_label('city', 'City') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="city" value="{{$user->city}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="state"><?= get_label('state', 'State') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="state" value="{{$user->state}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="country"><?= get_label('country', 'Country') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="country" value="{{$user->country}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="zip"><?= get_label('zip_code', 'Zip code') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="zip" value="{{$user->zip}}" readonly="">
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="dob"><?= get_label('dob', 'Date of birth') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="dob" value="{{ format_date($user->dob)}}" readonly="">
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="doj"><?= get_label('date_of_join', 'Date of joining') ?></label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="text" id="doj" value="{{ format_date($user->doj)}}" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    @if ($auth_user->can('manage_projects') || $auth_user->can('manage_tasks'))
    <div class="nav-align-top my-4">
        <ul class="nav nav-tabs" role="tablist">
            @if ($auth_user->can('manage_projects'))
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-projects" aria-controls="navs-top-projects" aria-selected="true">
                    <i class="menu-icon tf-icons bx bx-briefcase-alt-2 text-success"></i><?= get_label('projects', 'Projects') ?>
                </button>
            </li>
            @endif
            @if ($auth_user->can('manage_tasks'))
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-tasks" aria-controls="navs-top-tasks" aria-selected="false">
                    <i class="menu-icon tf-icons bx bx-task text-primary"></i><?= get_label('tasks', 'Tasks') ?>
                </button>
            </li>
            @endif
        </ul>
        <div class="tab-content">
            @if ($auth_user->can('manage_projects'))
            <div class="tab-pane fade active show" id="navs-top-projects" role="tabpanel">
                
                    <div class="table-responsive text-nowrap">

                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold">{{$user->first_name}}'s <?= get_label('projects', 'Projects') ?></h4>
                        </div>
                        @if (is_countable($projects) && count($projects) > 0)
                        <?php
                        $id = isAdminOrHasAllDataAccess() ? '' : 'user_' . $user->id;
                        ?>
                        <x-projects-card :projects="$projects" :id="$id" :users="$users" :clients="$clients" />
                        @else
                        <?php
                        $type = 'Projects'; ?>
                        <x-empty-state-card :type="$type" />

                        @endif
                    </div>
                
            </div>
            @endif

            @if ($auth_user->can('manage_tasks'))
            <div class="tab-pane fade {{!$auth_user->can('manage_projects')?'active show':''}}" id="navs-top-tasks" role="tabpanel">
                
                    <div class="table-responsive text-nowrap">

                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold">{{$user->first_name}}'s <?= get_label('tasks', 'Tasks') ?></h4>
                        </div>
                        @if ($tasks > 0)
                        <?php
                        $id = isAdminOrHasAllDataAccess() ? '' : 'user_' . $user->id;
                        ?>
                        <x-tasks-card :tasks="$tasks" :id="$id" :users="$users" :clients="$clients" :projects="$projects" />
                        @else
                        <?php
                        $type = 'Tasks'; ?>
                        <x-empty-state-card :type="$type" />

                        @endif
                    </div>
                
            </div>
            @endif
        </div>
    </div>
    @endif

</div>

@endsection