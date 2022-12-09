$(document).ready(function() { //console.log(4444);
    //AJAX
    // //----- Open model CREATE -----//
    // jQuery('#btn-add').click(function() {
    //     jQuery('#btn-save').val("add");
    //     jQuery('#myForm').trigger("reset");
    //     jQuery('#formModal').modal('show');
    // });
    // // CREATE
    // $("#btn-save").click(function(e) { //console.log(4444);
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     e.preventDefault();
    //     var formData = {
    //         email: jQuery('#email').val(),
    //         username: jQuery('#username').val(),
    //         password: jQuery('#password').val(),
    //         verifyPassword: jQuery('#verifyPassword').val(),
    //         role: jQuery('#role').val(),
    //     };
    //     var state = jQuery('#btn-save').val();
    //     var type = "POST";
    //     var user_id = jQuery('#user_id').val();
    //     var ajaxurl = 'http://127.0.0.1:8000/users/create';
    //     $.ajax({
    //         type: type,
    //         url: ajaxurl,
    //         data: formData,
    //         dataType: 'json',
    //         success: function(data) {
    //             var user = '<tr id="user' + data.id + '"><td>' + data.id + '</td><td>' + data.username + '</td><td>' + data.password + '</td><td>' + data.password;
    //             if (state == "add") {
    //                 jQuery('#user-list').append(user);
    //             } else {
    //                 jQuery("#user" + user_id).replaceWith(user);
    //             }
    //             jQuery('#myForm').trigger("reset");
    //             jQuery('#formModal').modal('hide')
    //         },
    //         error: function(data) {
    //             console.log(data);
    //         }
    //     });
    // });




    //is active

    isActiveUser = (user_id) => {
        if (!$('#is_active_user' + user_id).is(':checked'))
            $('#is_active_user' + user_id).prop('value', false)
        else
            $('#is_active_user' + user_id).prop('value', true)
        $('#isActiveForm' + user_id).submit();
    }


    //is active


    //Filtering Start
    searchUsers = (users_stringify_from_user_collections, faculty_name) => {
            let users = JSON.parse(users_stringify_from_user_collections); //convert collections to js Object
            console.log(faculty_name, users);
            $(".user").hide();
            jQuery.each(users, function(id) {
                if ((users[id]["username"] && users[id]["username"].indexOf($('#search_user').val()) > -1) ||
                    (users[id]["email"] && users[id]["email"].indexOf($('#search_user').val()) > -1) ||
                    (users[id]["property"] && users[id]["property"].indexOf($('#search_user').val()) > -1) ||
                    (users[id]["role"] && users[id]["role"].indexOf($('#search_user').val()) > -1) ||
                    (users[id]["temporary_role"] && users[id]["temporary_role"].indexOf($('#search_user').val()) > -1) ||
                    (users[id]["city"] && users[id]["city"].indexOf($('#search_user').val()) > -1) ||
                    (faculty_name.indexOf($('#search_user').val()) > -1))
                    $("#" + users[id]["id"]).show();
            });
        }
        //Filtering End
});