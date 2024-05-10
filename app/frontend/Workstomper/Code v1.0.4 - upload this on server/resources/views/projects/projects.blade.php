@extends('layout')

@section('title')
<?= get_label('projects', 'Projects') ?> - <?= get_label('list_view', 'List view') ?>
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
                    @if ($is_favorites==1)
                    <li class="breadcrumb-item"><a href="{{url('/projects/favorite')}}"><?= get_label('favorite', 'Favorite') ?></a></li>
                    @endif
                    <li class="breadcrumb-item active"><?= get_label('list', 'List') ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{url('/projects/create')}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('create_project', 'Create project') ?>"><i class='bx bx-plus'></i></button></a>
            <a href="{{url(request()->has('status') ? '/projects?status=' . request()->status : '/projects')}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('grid_view', 'Grid view') ?>"><i class='bx bxs-grid-alt'></i></button></a>
        </div>
    </div>
    <x-projects-card :projects="$projects" :users="$users" :clients="$clients" :favorites="$is_favorites" />
</div>
@endsection