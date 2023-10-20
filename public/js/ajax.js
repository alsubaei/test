$(function () {
    //----- Open model of posts with its data if it's update btn-----//
    $(document).on('click', '.btn-open-post', function () {
        $('#error_list').empty();
        if ($('input:hidden[post_id]'))
            $('input:hidden[post_id]').remove();
        $('#img').css("display", "none");
        $('#form')[0].reset();
        $('#error').hide();
        $('#btn-save-post').attr('id', "btn-post");
        $('#btn-edit-post').attr('id', "btn-post");
        $('#formModal').modal('show');
        //the create button
        if ($(this).val() == 'add')
            $('#btn-post').attr('id', "btn-save-post");
        else {
            //the edit button
            $('#img').css("display", "block");
            $('textarea').text("");
            //the array contains posts values
            values = [];
            $('#post' + $(this).attr('post_id') + '> td').each(function (index) {
                if (index != 5) {
                    values[index] = $(this).html().trim();
                } if (index == 1) {
                    values[index] = $(this).find('img').attr('src');
                }
            });
            // console.log("the values in td in row that will update:\n", values);
            //the array contains posts keys
            keys = [];
            $('#formModal :input').each(function () {
                if ($(this).prop('name') != '')
                    keys.push($(this).prop('name'));
            });
            // console.log("the names in td in row that will update:\n", keys);

            // put the values in the keys in formModal
            $.each(values, function (index) {
                if (keys[index] == 'image') {
                    if (values[index]) {
                        $('#img').attr("src", values[index]);
                        $('#img').attr("alt", 'image');
                    }
                } else if (keys[index] == 'content') {
                    $('textarea').text(values[index]);
                }
                else {
                    $('input[name="' + keys[index] + '"]').val(values[index]);
                }
            });
            // determine the btn if edit
            if ($(this).val() == 'edit') {
                $('#btn-post').attr('id', "btn-edit-post");
            }
            $('#formModal').append('<input type="hidden" post_id="' + $(this).attr("post_id") + '" />');
        }
    });

    //add the post
    $(document).on('click', '#btn-save-post', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = new FormData();
        formData.append('title', $('#title').val());
        formData.append("image", $('#attachment').prop("files")[0]);
        formData.append('content', $('#content').val());
        formData.append('user', $('#user').val());
        $.ajax({
            type: 'POST',
            url: 'post/',
            enctype: 'multipart/form-data',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (result) {
                $('#formModal').modal('hide');
                $('.modal-backdrop').remove();
                $('#form')[0].reset();
                $('#error_list').empty();
                $('#error').hide();
                if ($('input:hidden[post_id]'))
                    $('input:hidden[post_id]').remove();
                $('#img').css("display", "none");
                $("#post-list").prepend('<tr id="post' + result.id + '"><td>' + result.title + '</td><td><img src="attachment/' + result.image + '" alt="img" width="100" height="100"></td><td>' + result.content + '</td><td>' + result.user + '</td><td><button data-toggle="modal" post_id="' + result.id + '" class= "btn-open-post btn btn-xs btn-default text-primary mx-1 shadow" title = "Edit" > <i class="fa fa-lg fa-fw fa-pen"></i> </button> <button post_id="' + result.id + '" class="btn btn-xs btn-default text-danger mx-1 shadow btn-delete-post" title = "Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button></td ></tr > ');
            },
            error: function (reject) {
                $('#error_list').empty();
                var response = JSON.parse(reject.responseText);
                if (response.errors) {
                    $('#error').show();

                    $.each(response.errors, function (key, value) {
                        $('#error_list').append('<li>' + value[0] + '</li>');
                    });
                }
                else {
                    $('#error').show();
                    $('#error_list').append('<li>' + response.message + '</li>');
                    console.log(response.message);
                }
                console.log(reject);
            }
        });
    });

    // edit the post
    $(document).on('click', '#btn-edit-post', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = new FormData();
        formData.append('title', $('#title').val());
        formData.append('content', $('#content').val());
        if (typeof $('#attachment').prop("files")[0] == 'undefined')
            formData.append("image", $('#img').attr('src'));
        else
            formData.append("image", $('#attachment').prop("files")[0]);
        formData.append('user', $('#user').val());
        $.ajax({
            type: 'post',
            url: "post/" + $('#formModal > input').attr('post_id') + '/update',
            enctype: 'multipart/form-data',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (result) {
                $('#formModal').modal('hide');
                $('.modal-backdrop').remove();
                $('#form')[0].reset();
                $('#error_list').empty();
                $('#error').hide();
                if ($('input:hidden[post_id]'))
                    $('input:hidden[post_id]').remove();
                $('#img').css("display", "none");
                $('#post' + result.id + " > td:nth-child(1)").text(result.title);
                if (result.image.includes('http'))
                    $('#post' + result.id + " > td:nth-child(2)").html('<img src="' + result.image + '" alt="">');
                else
                    $('#post' + result.id + " > td:nth-child(2)").html('<img src="attachment/' + result.image + '" alt="">');
                $('#post' + result.id + " > td:nth-child(3)").text(result.content);
                $('#post' + result.id + " > td:nth-child(4)").text(result.user.name);
            },
            error: function (reject) {
                $('#error_list').empty();
                var response = JSON.parse(reject.responseText);
                if (response.errors) {
                    $('#error').show();

                    $.each(response.errors, function (key, value) {
                        $('#error_list').append('<li>' + value[0] + '</li>');
                    });
                }
                else {
                    $('#error').show();
                    $('#error_list').append('<li>' + response.message + '</li>');
                    console.log(response.message);
                }
                console.log(reject);
            }
        });

    });


    // delete of post
    $(document).on('click', '.btn-delete-post', function (e) {
        console.log($(this).attr('post_id'))
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: "post/" + $(this).attr('post_id'),
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'id': $(this).attr('post_id'),
            },
            dataType: 'json',
            success: function (result) {
                alert('delete the post');
                $("#post" + result.id).remove();

            }, error: function (reject) {
                console.log(reject);
            }
        });

    });

});

