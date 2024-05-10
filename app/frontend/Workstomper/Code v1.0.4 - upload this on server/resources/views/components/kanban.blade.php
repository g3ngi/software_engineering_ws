@props(['task'])
<div class="card m-2 shadow" data-task-id="{{$task->id}}">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h6 class="card-title"><a href="{{url('/tasks/information/' . $task->id)}}" target="_blank"><strong>{{$task->title}}</strong></a></h6>
            <div>
                <div class="input-group">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-cog'></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a href="/{{Request::segment(1)=='projects'?'projects/tasks':'tasks'}}/edit/{{$task->id}}" class="card-link"><i class='menu-icon tf-icons bx bx-edit'></i> <?= get_label('update', 'Update') ?></a></li>
                        <li class="dropdown-item"><a href="javascript:void(0);" class="card-link delete" data-reload="true" data-type="tasks" data-id="{{ $task->id }}">
                                <i class='menu-icon tf-icons bx bx-trash text-danger'></i> <?= get_label('delete', 'Delete') ?>
                            </a>
                        </li>
                        <li class="dropdown-item">
                            <a href="javascript:void(0);" class="duplicate" data-reload="true" data-type="tasks" data-id="{{$task->id}}">
                                <i class='menu-icon tf-icons bx bx-copy text-warning'></i><?= get_label('duplicate', 'Duplicate') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-subtitle text-muted mb-3">{{$task->project->title}}</div>
        <div class="row mt-2">
            <div class="col-md-6">
                <p class="card-text">
                    <?= get_label('users', 'Users') ?>:
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <?php
                    $users = $task->users;
                    $count = count($users);
                    $displayed = 0;
                    if ($count > 0) { ?>
                        @foreach($users as $user)
                        @if($displayed < 3) <li class="avatar avatar-sm pull-up" title="{{$user->first_name}} {{$user->last_name}}"><a href="/users/profile/{{$user->id}}" target="_blank">
                                <img src="{{$user->photo ? asset('storage/' . $user->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$user->first_name}} {{$user->last_name}}">
                            </a></li>
                            <?php $displayed++ ?>
                            @else
                            <?php
                            $remaining = $count - $displayed;
                            echo '<span class="badge badge-center rounded-pill bg-primary mx-1">+' . $remaining . '</span>';
                            break;
                            ?>
                            @endif
                            @endforeach
                        <?php } else { ?>
                            <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>

                        <?php }
                        ?>

                </ul>
                </p>
            </div>

            <div class="col-md-6">
                <p class="card-text">
                    Clients:
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <?php
                    $clients = $task->project->clients;
                    $count = $clients->count();
                    // dd($count);
                    $displayed = 0;
                    if ($count > 0) { ?>

                        @foreach($clients as $client)
                        @if($displayed < 3) <li class="avatar avatar-sm pull-up" title="{{$client->first_name}} {{$client->last_name}}"><a href="/clients/profile/{{$client->id}}" target="_blank">
                                <img src="{{$client->photo ? asset('storage/' . $client->photo) : asset('storage/photos/no-image.jpg')}}" class="rounded-circle" alt="{{$client->first_name}} {{$client->last_name}}">
                            </a></li>
                            <?php $displayed++ ?>
                            @else
                            <?php
                            $remaining = $count - $displayed;
                            echo '<span class="badge badge-center rounded-pill bg-primary mx-1">+' . $remaining . '</span>';
                            break;
                            ?>
                            @endif
                            @endforeach
                        <?php } else { ?>
                            <span class="badge bg-primary"><?= get_label('not_assigned', 'Not assigned') ?></span>
                        <?php }
                        ?>
                </ul>
                </p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <span class='badge bg-label-{{$task->status->color}} me-1' id="status"> {{$task->status->title}}</span>
            <small class="float-right" style="font-size: small; width: 120px">{{ format_date($task->due_date)}}</small>
        </div>
    </div>
</div>