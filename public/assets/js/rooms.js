$(document).ready(function() {

    //is active

    isActiveRoom = (room_id) => {
        if (!$('#is_active_room').is(':checked'))
            $('#is_active_room').prop('value', false)
        else
            $('#is_active_room').prop('value', true)
        $('#isActiveForm' + room_id).submit();
    }


    //is active

    //Filtering Start
    searchRooms = (x) => {
            let rooms = JSON.parse(x);
            $(".room").hide();
            jQuery.each(rooms, function(id) {
                if (rooms[id]["room_name"].indexOf($('#search_room_name').val()) > -1)
                    $("#" + rooms[id]["id"]).show();
            });
        }
        //Filtering End
});