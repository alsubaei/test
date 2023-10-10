$(function () {
    //----- Open the modal -----//
    $id = 0;
    $(document).on('click', '.btn-pass', function () {
        $('#password').val('');
        $('#passModal').modal('show');
        $id = $(this).attr("user-id");
    });
    // reset the password
    $(document).on('click', '#btn-update', function (e) {
        $password = $('#password').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: "user/reset",
            data: {
                'id': $id,
                'password': $password,
            },
            dataType: 'json',
            success: function (result) {
                alert("successfully reset password.");
            }, error: function (reject) {
                console.log(reject);
            }
        });

    });

});