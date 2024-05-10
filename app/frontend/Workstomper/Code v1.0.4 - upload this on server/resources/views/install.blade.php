@extends('layout')

@section('title')
Installer
@endsection

@section('content')
<div class="container-fluid">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner installer-div">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="app-brand justify-content-center">
                        <a href="/install" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('storage/logos/default_full_logo.png') }}" width="300px" alt="" />

                            </span>
                        </a>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <h3>INSTALLER</h3>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
                                            <i class="tf-icons bx bx-cog"></i> Database Configuration
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" id="complete_installation_btn" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false">
                                            <i class="tf-icons bx bx-check-square"></i> Complete Installation
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                                        <form action="{{url('/installer/config-db')}}" class="form-submit-event" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="dnr">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Database name <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="text" name="db_name" placeholder="Please enter database name" value="{{ old('db_name') }}">

                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Database host name <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="text" name="db_host_name" placeholder="Please enter database host name" value="{{ old('db_host_name')??'localhost' }}">

                                                </div>

                                                <div class="mb-3">
                                                    <label for="" class="form-label">Database user name <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="text" name="db_user_name" placeholder="Please enter database user name" value="{{ old('db_user_name') }}">

                                                </div>

                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Database password</label>
                                                    <input class="form-control" type="password" name="db_password" placeholder="Please enter database password">
                                                </div>

                                                <div class="mt-2 text-center">
                                                    <button type="submit" class="btn btn-primary me-2" id="submit_btn">Submit</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                        <form action="{{url('/installer/install')}}" class="form-submit-event" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="redirect_url" value="/">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 mt-4">
                                                    <label for="firstName" class="form-label">Admin first name <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="text" name="first_name" placeholder="Please enter admin first name" value="{{ old('first_name') }}">

                                                </div>

                                                <div class="mb-3">
                                                    <label for="firstName" class="form-label">Admin last name <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="text" name="last_name" placeholder="Please enter admin last name" value="{{ old('last_name') }}">

                                                </div>


                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Admin E-mail <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="email" name="email" placeholder="Please enter admin E-mail" value="{{ old('email') }}">

                                                </div>


                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Admin password <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="password" name="password" placeholder="Please enter admin password">

                                                </div>
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">Confirm admin password <span class="asterisk">*</span></label>
                                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Please re enter admin password">

                                                </div>

                                                <div class="mt-2 text-center">
                                                    <button type="submit" class="btn btn-primary me-2" id="submit_btn">Install</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pills -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection