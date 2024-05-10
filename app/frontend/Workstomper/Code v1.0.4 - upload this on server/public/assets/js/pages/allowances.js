
'use strict';
function queryParams(p) {
    return {
        page: p.offset / p.limit + 1,
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}


window.icons = {
    refresh: 'bx-refresh',
    toggleOn: 'bx-toggle-right',
    toggleOff: 'bx-toggle-left'
}

function loadingTemplate(message) {
    return '<i class="bx bx-loader-alt bx-spin bx-flip-vertical" ></i>'
}

function actionsFormatter(value, row, index) {
    return [
        '<a href="javascript:void(0);" class="edit-allowance" data-id=' + row.id + ' title=' + label_update + ' class="card-link"><i class="bx bx-edit mx-1"></i></a>' +
        '<button title=' + label_delete + ' type="button" class="btn delete" data-id=' + row.id + ' data-type="allowances">' +
        '<i class="bx bx-trash text-danger mx-1"></i>' +
        '</button>'
    ]
}

$(document).on('click', '.edit-allowance', function () {
    var id = $(this).data('id');
    $('#edit_allowance_modal').modal('show');
    $.ajax({
        url: '/allowances/get/' + id,
        type: 'get',
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value') // Replace with your method of getting the CSRF token
        },
        dataType: 'json',
        success: function (response) {
            var amount = parseFloat(response.allowance.amount);
            $('#allowance_id').val(response.allowance.id)
            $('#allowance_title').val(response.allowance.title)
            $('#allowance_amount').val(amount.toFixed(decimal_points))
        },

    });
});