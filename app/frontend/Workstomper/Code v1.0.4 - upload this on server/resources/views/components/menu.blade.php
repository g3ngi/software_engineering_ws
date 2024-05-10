<?php

use App\Models\User;
use App\Models\Workspace;
use App\Models\LeaveRequest;
use Chatify\ChatifyMessenger;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$user = getAuthenticatedUser();
if (isAdminOrHasAllDataAccess()) {
    $workspaces = Workspace::all()->skip(0)->take(5);
    $total_workspaces = Workspace::all()->count();
} else {
    $workspaces = $user->workspaces;
    $total_workspaces = count($workspaces);
    $workspaces = $user->workspaces->skip(0)->take(5);
}
$current_workspace = Workspace::find(session()->get('workspace_id'));
$current_workspace_title = $current_workspace->title ?? 'No workspace(s) found';

$messenger = new ChatifyMessenger();
$unread = $messenger->totalUnseenMessages();
$pending_todos_count = $user->todos(0)->count();
$ongoing_meetings_count = $user->meetings('ongoing')->count();
$query = LeaveRequest::where('status', 'pending')
    ->where('workspace_id', session()->get('workspace_id'));

if (!is_admin_or_leave_editor()) {
    $query->where('user_id', $user->id);
}
$pendingLeaveRequestsCount = $query->count();

?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme menu-container">
    <div class="app-brand demo">
        <a href="/home" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{asset($general_settings['full_logo'])}}" width="200px" alt="" />
            </span>
            <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Taskify</span> -->
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <div class="btn-group dropend px-2">
        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $current_workspace_title ?>
        </button>
        <ul class="dropdown-menu">
            @foreach ($workspaces as $workspace)
            <?php $checked = $workspace->id == session()->get('workspace_id') ? "<i class='menu-icon tf-icons bx bx-check-square text-primary'></i>" : "<i class='menu-icon tf-icons bx bx-square text-solid'></i>" ?>
            <li><a class="dropdown-item" href="/workspaces/switch/{{$workspace->id}}"><?= $checked ?>{{$workspace->title}}</a></li>
            @endforeach
            <li>
                <hr class="dropdown-divider" />
            </li>
            @if ($user->can('manage_workspaces'))
            <li><a class="dropdown-item" href="/workspaces"><i class='menu-icon tf-icons bx bx-bar-chart-alt-2 text-success'></i><?= get_label('manage_workspaces', 'Manage workspaces') ?> <?= $total_workspaces > 5 ? '<span class="badge badge-center bg-primary"> + ' . ($total_workspaces - 5) . '</span>' : "" ?></a></li>
            @if ($user->can('create_workspaces'))
            <li><a class="dropdown-item" href="/workspaces/create"><i class='menu-icon tf-icons bx bx-plus text-warning'></i><?= get_label('create_workspace', 'Create workspace') ?></a></span></li>
            <!-- <li><span data-bs-toggle="modal" data-bs-target="#create_workspace_modal"><a class="dropdown-item" href="javascript:void(0);"><i class='menu-icon tf-icons bx bx-plus text-warning'></i><?= get_label('create_workspace', 'Create workspace') ?></a></span></li> -->
            @endif
            @if ($user->can('create_workspaces'))
            <li><a class="dropdown-item" href="/workspaces/edit/<?= session()->get('workspace_id') ?>"><i class='menu-icon tf-icons bx bx-edit text-info'></i><?= get_label('edit_workspace', 'Edit workspace') ?></a></li>
            @endif
            @endif
            <li><a class="dropdown-item" href="#" id="remove-participant"><i class='menu-icon tf-icons bx bx-exit text-danger'></i><?= get_label('remove_me_from_workspace', 'Remove me from workspace') ?></a></li>
        </ul>
    </div>
    <ul class="menu-inner py-1">
        <hr class="dropdown-divider" />
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('home') ? 'active' : '' }}">
            <a href="/home" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle text-danger"></i>
                <div><?= get_label('dashboard', 'Dashboard') ?></div>
            </a>
        </li>
        @if ($user->can('manage_projects'))
        <li class="menu-item {{ Request::is('projects') || Request::is('tags/*') || Request::is('projects/*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2 text-success"></i>
                <div><?= get_label('projects', 'Projects') ?></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('projects') || Request::is('projects/*') && !Request::is('projects/favorite') ? 'active' : '' }}">
                    <a href="/projects" class="menu-link">
                        <div><?= get_label('manage_projects', 'Manage projects') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('projects/favorite') ? 'active' : '' }}">
                    <a href="/projects/favorite" class="menu-link">
                        <div><?= get_label('favorite_projects', 'Favorite projects') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('tags/*') ? 'active' : '' }}">
                    <a href="/tags/manage" class="menu-link">
                        <div><?= get_label('tags', 'Tags') ?></div>
                    </a>
                </li>
            </ul>
        </li>


        @endif
        @if ($user->can('manage_tasks'))
        <li class="menu-item {{ Request::is('tasks') || Request::is('tasks/*') ? 'active' : '' }}">
            <a href="/tasks" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task text-primary"></i>
                <div><?= get_label('tasks', 'Tasks') ?></div>
            </a>
        </li>
        @endif

        @if ($user->can('manage_projects') || $user->can('manage_tasks'))
        <li class="menu-item {{ Request::is('status/manage') ? 'active' : '' }}">
            <a href="/status/manage" class="menu-link">
                <i class='menu-icon tf-icons bx bx-grid-small text-secondary'></i>
                <div><?= get_label('statuses', 'Statuses') ?></div>
            </a>
        </li>
        @endif

        @if ($user->can('manage_workspaces'))
        <li class="menu-item {{ Request::is('workspaces') || Request::is('workspaces/*') ? 'active' : '' }}">
            <a href="/workspaces" class="menu-link">
                <i class='menu-icon tf-icons bx bx-check-square text-danger'></i>
                <div><?= get_label('workspaces', 'Workspaces') ?></div>
            </a>
        </li>
        @endif


        @if (Auth::guard('web')->check())
        <li class="menu-item {{ Request::is('chat') || Request::is('chat/*') ? 'active' : '' }}">
            <a href="/chat" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat text-warning"></i>
                <div><?= get_label('chat', 'Chat') ?> <span class="flex-shrink-0 badge badge-center bg-danger w-px-20 h-px-20">{{$unread}}</span></div>

            </a>
        </li>
        @endif


        <li class="menu-item {{ Request::is('todos') || Request::is('todos/*') ? 'active' : '' }}">
            <a href="/todos" class="menu-link">
                <i class='menu-icon tf-icons bx bx-list-check text-dark'></i>
                <div><?= get_label('todos', 'Todos') ?> <span class="flex-shrink-0 badge badge-center bg-danger w-px-20 h-px-20">{{$pending_todos_count}}</span></div>
            </a>
        </li>
        @if ($user->can('manage_meetings'))
        <li class="menu-item {{ Request::is('meetings') || Request::is('meetings/*') ? 'active' : '' }}">
            <a href="/meetings" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shape-polygon text-success"></i>
                <div><?= get_label('meetings', 'Meetings') ?> <span class="flex-shrink-0 badge badge-center bg-success w-px-20 h-px-20">{{$ongoing_meetings_count}}</span></div>
            </a>
        </li>
        @endif
        @if ($user->can('manage_users'))
        <li class="menu-item {{ Request::is('users') || Request::is('users/*') ? 'active' : '' }}">
            <a href="/users" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group text-primary"></i>
                <div><?= get_label('users', 'Users') ?></div>
            </a>
        </li>
        @endif
        @if ($user->can('manage_clients'))
        <li class="menu-item {{ Request::is('clients') || Request::is('clients/*') ? 'active' : '' }}">
            <a href="/clients" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group text-warning"></i>
                <div><?= get_label('clients', 'Clients') ?></div>
            </a>
        </li>
        @endif

        @if ($user->can('manage_contracts'))

        <li class="menu-item {{ Request::is('contracts') || Request::is('contracts/*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-news text-success"></i>
                <?= get_label('contracts', 'Contracts') ?>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('contracts') ? 'active' : '' }}">
                    <a href="/contracts" class="menu-link">
                        <div><?= get_label('manage_contracts', 'Manage contracts') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('contracts/contract-types') ? 'active' : '' }}">
                    <a href="/contracts/contract-types" class="menu-link">
                        <div><?= get_label('contract_types', 'Contract types') ?></div>
                    </a>
                </li>
            </ul>
        </li>

        @endif

        @if ($user->can('manage_payslips'))
        <li class="menu-item {{ Request::is('payslips') || Request::is('payslips/*') || Request::is('allowances') || Request::is('deductions') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box text-warning"></i>
                <?= get_label('payslips', 'Payslips') ?>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('payslips') || Request::is('payslips/*') ? 'active' : '' }}">
                    <a href="/payslips" class="menu-link">
                        <div><?= get_label('manage_payslips', 'Manage payslips') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('allowances') ? 'active' : '' }}">
                    <a href="/allowances" class="menu-link">
                        <div><?= get_label('allowances', 'Allowances') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('deductions') ? 'active' : '' }}">
                    <a href="/deductions" class="menu-link">
                        <div><?= get_label('deductions', 'Deductions') ?></div>
                    </a>
                </li>
            </ul>
        </li>
        @endif


        @if ($user->can('manage_estimates_invoices') || $user->can('manage_expenses'))
        <li class="menu-item {{ Request::is('estimates-invoices') || Request::is('estimates-invoices/*') || Request::is('taxes') || Request::is('payment-methods') || Request::is('payments') || Request::is('units') || Request::is('items') || Request::is('expenses') || Request::is('expenses/*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box text-success"></i>
                <?= get_label('finance', 'Finance') ?>
            </a>
            <ul class="menu-sub">
                @if ($user->can('manage_expenses'))
                <li class="menu-item {{ Request::is('expenses') || Request::is('expenses/*') ? 'active' : '' }}">
                    <a href="/expenses" class="menu-link">
                        <div><?= get_label('expenses', 'Expenses') ?></div>
                    </a>
                </li>
                @endif

                @if ($user->can('manage_estimates_invoices'))
                <li class="menu-item {{ Request::is('estimates-invoices') || Request::is('estimates-invoices/*') ? 'active' : '' }}">
                    <a href="/estimates-invoices" class="menu-link">
                        <div><?= get_label('etimates_invoices', 'Estimates/Invoices') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('payments') ? 'active' : '' }}">
                    <a href="/payments" class="menu-link">
                        <div><?= get_label('payments', 'Payments') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('payment-methods') ? 'active' : '' }}">
                    <a href="/payment-methods" class="menu-link">
                        <div><?= get_label('payment_methods', 'Payment methods') ?></div>
                    </a>
                </li>

                <li class="menu-item {{ Request::is('taxes') ? 'active' : '' }}">
                    <a href="/taxes" class="menu-link">
                        <div><?= get_label('taxes', 'Taxes') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('units') ? 'active' : '' }}">
                    <a href="/units" class="menu-link">
                        <div><?= get_label('units', 'Units') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('items') ? 'active' : '' }}">
                    <a href="/items" class="menu-link">
                        <div><?= get_label('items', 'Items') ?></div>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif


        <li class="menu-item {{ Request::is('notes') || Request::is('notes/*') ? 'active' : '' }}">
            <a href="/notes" class="menu-link">
                <i class='menu-icon tf-icons bx bx-notepad text-primary'></i>
                <div><?= get_label('notes', 'Notes') ?></div>
            </a>
        </li>


        @if (Auth::guard('web')->check())
        <li class="menu-item {{ Request::is('leave-requests') || Request::is('leave-requests/*') ? 'active' : '' }}">
            <a href="/leave-requests" class="menu-link">
                <i class='menu-icon tf-icons bx bx-right-arrow-alt text-danger'></i>
                <div><?= get_label('leave_requests', 'Leave requests') ?> <span class="flex-shrink-0 badge badge-center bg-danger w-px-20 h-px-20">{{$pendingLeaveRequestsCount}}</span></div>
            </a>
        </li>
        @endif

        @if ($user->can('manage_activity_log'))
        <li class="menu-item {{ Request::is('activity-log') || Request::is('activity-log/*') ? 'active' : '' }}">
            <a href="/activity-log" class="menu-link">
                <i class='menu-icon tf-icons bx bx-line-chart text-warning'></i>
                <div><?= get_label('activity_log', 'Activity log') ?></div>
            </a>
        </li>
        @endif
        @role('admin')
        <li class="menu-item {{ Request::is('settings') || Request::is('roles/*') || Request::is('settings/*') ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box text-success"></i>
                <div data-i18n="User interface"><?= get_label('settings', 'Settings') ?></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('settings/general') ? 'active' : '' }}">
                    <a href="/settings/general" class="menu-link">
                        <div><?= get_label('general', 'General') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/permission') || Request::is('roles/*') ? 'active' : '' }}">
                    <a href="/settings/permission" class="menu-link">
                        <div><?= get_label('permissions', 'Permissions') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/languages') || Request::is('settings/languages/create') ? 'active' : '' }}">
                    <a href="/settings/languages" class="menu-link">
                        <div><?= get_label('languages', 'Languages') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/email') ? 'active' : '' }}">
                    <a href="/settings/email" class="menu-link">
                        <div><?= get_label('email', 'Email') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/pusher') ? 'active' : '' }}">
                    <a href="/settings/pusher" class="menu-link">
                        <div><?= get_label('pusher', 'Pusher') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/media-storage') ? 'active' : '' }}">
                    <a href="/settings/media-storage" class="menu-link">
                        <div><?= get_label('media_storage', 'Media storage') ?></div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('settings/system-updater') ? 'active' : '' }}">
                    <a href="/settings/system-updater" class="menu-link">
                        <div><?= get_label('system_updater', 'System updater') ?></div>
                    </a>
                </li>

            </ul>
        </li>
        @endrole
    </ul>
</aside>