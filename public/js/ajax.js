$(function () {
    //----- Open model of status -----//
    $(document).on('click', '.btn-open-status', function () {
        if ($('input:hidden[post_id]'))
            $('input:hidden[post_id]').remove();
        $('#btn-save-status').attr('id', "btn-status");
        $('#btn-edit-status').attr('id', "btn-status");
        $('#title').val("");
        $('#image').val("");
        $('#content').val("");
        $('#error').hide();
        $('ul li').remove();
        if ($(this).val() == 'add')
            $('#btn-status').attr('id', "btn-save-status");
        else {
            $('#btn-status').attr('id', "btn-edit-status");
            $title = $('#post' + $(this).attr('post_id') + '> td').each(function (index) {
                if (index != 4) {
                    values[index] = $(this).html().trim();
                }
            });
            keys = [];
            $('#formModal :input').each(function () {
                if ($(this).prop('name') != '')
                    keys.push($(this).prop('name'));
            });
        }
        $('#formModal').append('<input type="hidden" post_id="' + $(this).attr("post_id") + '" />');
        $('#formModal').modal('show');
    });

    // CREATE of status
    $(document).on('click', '#btn-save-status', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var data = new FormData();
        data.append('createStatusName', $('#StatusName').val());
        $.ajax({
            type: 'post',
            url: '/Post',
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (result) {
                $('#error').hide();
                $('#formModal').modal('hide');
                $("#post-list").append('<tr id="status' + result.id + '"><td>' + result.title + '</td><td>' + result.image + '</td><td>' + result.content + '</td><td><button data-toggle="modal" status_id="' + result.id + '" class= "btn-open-status btn btn-xs btn-default text-primary mx-1 shadow" title="Edit"> <i class="fa fa-lg fa-fw fa-pen"></i> </button> <button status_id="' + result.id + '" class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete-status" title = "Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button></td></tr>'
                );
            }, error: function (reject) {
                $('ul li').remove();
                var response = JSON.parse(reject.responseText);
                if (response.errors) {
                    $('#error').show();
                    $.each(response.errors, function (key, value) {
                        $('#error_list').append('<li>' + value[0] + '</li>');
                    });
                }
                console.log(reject);
            }
        });
    });

    // delete of status
    $(document).on('click', '.btn-delete-status', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "Post/" + $(this).attr('post_id'),
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $(this).attr('post_id'),
            },
            dataType: 'json',
            success: function (result) {
                $("#post" + result.id).remove();

            }, error: function (reject) {
                console.log(reject);
            }
        });

    });

    // edit of status
    $(document).on('click', '#btn-edit-status', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: "Status/" + $('#formModal > input').attr('status_id') + "/update",
            data: {
                'id': $('#formModal input').attr('status_id'),
                'editStatusName': $('#StatusName').val(),
            },
            dataType: 'json',
            success: function (result) {
                $('#error').hide();
                $('#formModal').modal('hide');
                $('#status' + result.id + " > td:nth-child(1)").text(result.name);
            }, error: function (reject) {
                $('ul li').remove();
                var response = JSON.parse(reject.responseText);
                if (response.errors) {
                    $('#error').show();
                    $.each(response.errors, function (key, value) {
                        $('#error_list').append('<li>' + value[0] + '</li>');
                    });
                }
                console.log(reject);
            }
        });

    });
});

