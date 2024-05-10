@extends('layout')

@section('title')
<?= get_label('payments', 'Payments') ?>
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
                    <li class="breadcrumb-item active">
                        <?= get_label('payments', 'Payments') ?>
                    </li>

                </ol>
            </nav>
        </div>
        <div>
            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#create_payment_modal"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title=" <?= get_label('create_payment', 'Create payment') ?>"><i class="bx bx-plus"></i></button></a>
            <a href="{{url('/payment-methods')}}"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="<?= get_label('payment_methods', 'Payment methods') ?>"><i class='bx bx-list-ul'></i></button></a>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                @if ($payments > 0)

                <div class="row mt-4 mx-2">
                    <div class="mb-3 col-md-3">
                        <div class="input-group input-group-merge">
                            <input type="text" id="payment_date_between" class="form-control" placeholder="<?= get_label('payment_date_between', 'Payment date between') ?>" autocomplete="off">
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
                    @endif

                    <div class="col-md-3">
                        <select class="form-select" id="invoice_filter" aria-label="Default select example">
                            <option value=""><?= get_label('select_invoice', 'Select invoice') ?></option>
                            @foreach ($invoices as $invoice)
                            <option value="{{$invoice->id}}">{{get_label('invoice_id_prefix', 'INVC-') . $invoice->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="payment_method_filter" aria-label="Default select example">
                            <option value=""><?= get_label('select_payment_method', 'Select payment method') ?></option>
                            @foreach ($payment_methods as $pm)
                            <option value="{{$pm->id}}">{{$pm->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" id="payment_date_from">
                <input type="hidden" id="payment_date_to">


                <input type="hidden" id="data_type" value="payments">
                <div class="mx-2 mb-2">
                    <table id="table" data-toggle="table" data-loading-template="loadingTemplate" data-url="/payments/list" data-icons-prefix="bx" data-icons="icons" data-show-refresh="true" data-total-field="total" data-trim-on-search="false" data-data-field="rows" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-side-pagination="server" data-show-columns="true" data-pagination="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-query-params="queryParams">
                        <thead>
                            <tr>
                                <th data-checkbox="true"></th>
                                <th data-sortable="true" data-field="id"><?= get_label('id', 'ID') ?></th>
                                <th data-sortable="true" data-field="user_id" data-visible="false"><?= get_label('user_id', 'User ID') ?></th>
                                <th data-sortable="true" data-field="user"><?= get_label('user', 'User') ?></th>
                                <th data-sortable="true" data-field="invoice_id" data-visible="false"><?= get_label('invoice_id', 'Invoice ID') ?></th>
                                <th data-sortable="true" data-field="invoice"><?= get_label('invoice', 'Invoice') ?></th>
                                <th data-sortable="true" data-field="payment_method_id" data-visible="false"><?= get_label('payment_method_id', 'Payment method ID') ?></th>
                                <th data-sortable="true" data-field="payment_method"><?= get_label('payment_method', 'Payment method') ?></th>
                                <th data-sortable="true" data-field="amount"><?= get_label('amount', 'Amount') ?></th>
                                <th data-sortable="true" data-field="payment_date"><?= get_label('payment_date', 'Payment date') ?></th>
                                <th data-sortable="true" data-field="note" data-visible="false"><?= get_label('note', 'Note') ?></th>
                                <th data-sortable="false" data-field="created_by" data-visible="false"><?= get_label('created_by', 'Created by') ?></th>
                                <th data-sortable="true" data-field="created_at" data-visible="false"><?= get_label('created_at', 'Created at') ?></th>
                                <th data-sortable="true" data-field="updated_at" data-visible="false"><?= get_label('updated_at', 'Updated at') ?></th>
                                <th data-formatter="actionsFormatter"><?= get_label('actions', 'Actions') ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                @else
                <?php
                $type = 'Payments'; ?>
                <x-empty-state-card :type="$type" />

                @endif
            </div>
        </div>
    </div>
</div>

<script>
    var label_update = '<?= get_label('update', 'Update') ?>';
    var label_delete = '<?= get_label('delete', 'Delete') ?>';
    var label_duplicate = '<?= get_label('duplicate', 'Duplicate') ?>';
</script>
<script src="{{asset('assets/js/pages/payments.js')}}"></script>
@endsection