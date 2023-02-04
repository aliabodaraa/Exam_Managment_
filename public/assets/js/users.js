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
    let fetch_user = false;
    searchUsers = (users_stringify_from_user_collections, faculty_name) => {
        let users = JSON.parse(users_stringify_from_user_collections); //convert collections to js Object
        //console.log(faculty_name, users);
        let arr_users_objs = [];
        $(".user").hide();
        jQuery.each(users, function(id, user) {
            if ((users[id]["username"] && users[id]["username"].indexOf($('#search_user').val()) > -1) ||
                (users[id]["email"] && users[id]["email"].indexOf($('#search_user').val()) > -1) ||
                (users[id]["property"] && users[id]["property"].indexOf($('#search_user').val()) > -1) ||
                (users[id]["role"] && users[id]["role"].indexOf($('#search_user').val()) > -1) ||
                (users[id]["temporary_role"] && users[id]["temporary_role"].indexOf($('#search_user').val()) > -1) ||
                (users[id]["city"] && users[id]["city"].indexOf($('#search_user').val()) > -1) ||
                (faculty_name.indexOf($('#search_user').val()) > -1)) {
                $("#" + users[id]["id"]).show();
                arr_users_objs.push(user);
                // $("#user-list").append("<tr class=' user' id=" + `${users[id]["id"]}` + "style='display: table-row;'>" +
                //     "<td>" + `${users[id]["id"]}` + "</td>" +
                //     "<td>" + `${users[id]["email"]}` + "</td>" +
                //     "<td>" + `${users[id]["username"]}` + "</td>" +
                //     "<td><span class='badge bg-primary'>" + `${users[id]["property"]}` + "</span></td>" +
                //     "<td><span class='badge bg-danger'>" + `${users[id]["role"]}` + "</span></td>" +
                //     "<td><span class='badge bg-secondary'>" + `${users[id]["temporary_role"]}` + "</span></td>" +
                //     "<td style='display: flex;'>" +
                //     "<form id='isActiveForm" + `${users[id]["id"]}` + "method='post' action='http://127.0.0.1:8000/users/" + `${users[id]["id"]}` + "/isActive'>" +
                //     "<input type='hidden' name='_method' value='patch'>" +
                //     "<input type='hidden' name='_token' value='CKonWFIwh3jvGkvGm5r0ETtgFCDkg9cKt9shgQFc'>" +
                //     "<input type = 'checkbox' name = 'is_active' id = 'is_active_user" + `${users[id]["id"]}` + "' onclick = 'isActiveUser(" + `${users[id]["id"]}` + ")' class = 'toggler-wrapper style-4' checked = '' >" +
                //     "</form>" +
                //     "<img id='img_warning' src='http://127.0.0.1:8000/images/success-icon.png' alt='success' style='width: 20px;height: 20px;'>" +
                //     "</td>" +
                //     "<td>" + `${users[id]["city"]}` + "</td>" +
                //     // "<td><?php eval('$a=json_decode(" + JSON.stringify(`${users[id]}`) + ");echo $a->username;')?></td>" +
                //     "<td><span class='badge bg-secondary'>" + `${users[id]["number_of_observation"]}` + "</span></td>" +
                //     "<td>" +
                //     "<div class='btn-group-vertical' aria-labelledby='btnGroupDrop1' style='font-size: 1px; width:100%'>" +
                //     "<a href='http://127.0.0.1:8000/users/" + `${users[id]["id"]}` + "/profile' class='btn btn-primary btn-sm me-2'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-lines-fill' style=' float:left;' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z'></path></svg> الشخصية</a>" +
                //     "<a href='http://127.0.0.1:8000/users/" + `${users[id]["id"]}` + "/edit' class='btn btn-info btn-sm me-2'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-fill-gear' style=' float:left;' viewBox='0 0 16 16'><path d='M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z'></path></svg>تعديل </a>" +
                //     "<a href='#exampleModalToggle" + `${users[id]["id"]}` + "' data-bs-toggle='modal' class='btn btn-danger btn-sm'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-person-fill-x' style=' float:left;' viewBox='0 0 16 16'><path d = 'M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z'> </path><path d = 'M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z' > </path></svg> حذف </a>" +
                //     "</div>" +
                //     "</td>" +
                //     "</tr>");
            }
        });
        //sessionStorage.setItem('users_storage', 1);

        //show No users Message 
        let count = 0;
        jQuery.each($("#user-list").children(), function(child_id, child) {
            //$(this).clone().attr('rel', child_id).appendTo("table");
            if ($(this).hasClass("user") && $(this).css('display') != 'none') {
                count++;
            }
            if (count == 0)
                $("#empty_users").show();
            else
                $("#empty_users").hide();
        });

        console.log(arr_users_objs);
        return JSON.stringify(arr_users_objs);

    }
    if (fetch_user)
        $("#user-list").append("لا يوجد مستخدمين");
    //Filtering End
});