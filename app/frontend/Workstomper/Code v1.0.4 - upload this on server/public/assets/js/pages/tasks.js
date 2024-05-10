
window.icons = {
    refresh: 'bx-refresh'
}

function loadingTemplate(message) {
    return '<i class="bx bx-loader-alt bx-spin bx-flip-vertical" ></i>'
}
function actionFormatter(value, row, index) {
    var href = (typeof id !== 'undefined' && id.split("_")[0] === "project") ? "/projects/tasks/edit/" + row.id : "/tasks/edit/" + row.id;
    return [
        '<a href="' + href + '" title=' + label_update + '>' +
        '<i class="bx bx-edit mx-1">' +
        '</i>' +
        '</a>' +
        '<button title=' + label_delete + ' type="button" class="btn delete" data-id=' + row.id + ' data-type="tasks" data-table="task_table">' +
        '<i class="bx bx-trash text-danger mx-1"></i>' +
        '</button>'+
        '<a href="javascript:void(0);" class="duplicate" data-id=' + row.id + ' data-type="tasks" data-table="task_table" title=' + label_duplicate + '>' +
        '<i class="bx bx-copy text-warning mx-2"></i>' +
        '</a>'
    ]
}

function TaskClientFormatter(value, row, index) {
    var clients = Array.isArray(row.clients) && row.clients.length ? row.clients : '<span class="badge bg-primary">' + label_not_assigned + '</span>';
    if (Array.isArray(clients)) {
        clients = clients.map(client => '<li>' + client + '</li>');
        return '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">' + clients.join('') + '</ul>';
    } else {
        return clients;
    }
}


function TaskUserFormatter(value, row, index) {
    var users = Array.isArray(row.users) && row.users.length ? row.users : '<span class="badge bg-primary">' + label_not_assigned + '</span>';
    if (Array.isArray(users)) {
        users = users.map(user => '<li>' + user + '</li>');
        return '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">' + users.join('') + '</ul>';
    } else {
        return users;
    }
}

function queryParamsTasks(p) {
    return {
        "status": $('#task_status_filter').val(),
        "user_id": $('#tasks_user_filter').val(),
        "client_id": $('#tasks_client_filter').val(),
        "project_id": $('#tasks_project_filter').val(),
        "task_start_date_from": $('#task_start_date_from').val(),
        "task_start_date_to": $('#task_start_date_to').val(),
        "task_end_date_from": $('#task_end_date_from').val(),
        "task_end_date_to": $('#task_end_date_to').val(),
        page: p.offset / p.limit + 1,
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
$('#task_status_filter,#tasks_user_filter,#tasks_client_filter,#tasks_project_filter').on('change', function (e) {
    e.preventDefault();
    $('#task_table').bootstrapTable('refresh');
});