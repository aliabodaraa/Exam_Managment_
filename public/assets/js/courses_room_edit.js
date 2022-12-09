$(document).ready(function() {
    //Filter Users according to name only (create_initial_members.blade.php)(edit_initial_members.blade.php)
    searchForUserNameInInitialMembers = (x) => {
            //console.log(x);
            let users = JSON.parse(x);
            $(".user").hide();
            var detected_num = 0;
            jQuery.each(users, function(id) {
                //console.log("SIZE", Object.keys(users).length);
                if (users[id].indexOf($('.searchForUserNameInInitialMembers').val()) > -1) {
                    $("." + id).show();
                    detected_num++;
                    $(".result").text("detect " + detected_num);
                    if (detected_num != Object.keys(users).length)
                        $(".result").show();
                    else
                        $(".result").hide();

                }
            });
        }
        //Filter Users according to name only (edit_course_room.blade.php)
    searchForUserName = (x) => {
        let users = JSON.parse(x);
        $(".user").hide();
        jQuery.each(users, function(id) {
            if (users[id]["username"].indexOf($('#search_user_name').val()) > -1)
                $("#" + users[id]["id"]).show();
        });
    }

    $('[name="all_roomheads"]').on('click', function() {

        if ($(this).is(':checked')) {
            $.each($('.roomheads'), function() {
                if (!this.disabled)
                    $(this).prop('checked', true);
            });
        } else {
            $.each($('.roomheads'), function() {
                $(this).prop('checked', false);
            });
        }

    });
    $('[name="all_secertaries"]').on('click', function() {
        if ($(this).is(':checked')) {
            $.each($('.secertaries'), function() {
                if (!this.disabled)
                    $(this).prop('checked', true);
            });
        } else {
            $.each($('.secertaries'), function() {
                $(this).prop('checked', false);
            });
        }
    });
    $('[name="all_observers"]').on('click', function() {

        if ($(this).is(':checked')) {
            $.each($('.observers'), function() {
                if (!this.disabled)
                    $(this).prop('checked', true);
            });
        } else {
            $.each($('.observers'), function() {
                $(this).prop('checked', false);
            });
        }
    });

    //calc number of secertaries that checked
    let number_of_secertaries_that_checked = 0;
    let number_of_secertaries_that_not_checked = 0;

    let number_of_observers_that_checked = 0;
    let number_of_roomheads_that_checked = 0;
    $(".secertaries").each(function() {
        if ($(this).is(':checked'))
            number_of_secertaries_that_checked++;
        else
            number_of_secertaries_that_not_checked++;
    });

    if (number_of_secertaries_that_checked >= 2) {
        $(".secertaries").each(function() {
            if (!$(this).is(':checked'))
                $(this).prop('disabled', true);
        });
    } else {
        $(".secertaries").each(function() {
            if (!$(this).is(':checked') && !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                $(this).prop('disabled', false);
        });
    }


    console.log(number_of_secertaries_that_checked, number_of_secertaries_that_not_checked);
    $(".observers").each(function() {
        if ($(this).is(':checked'))
            number_of_observers_that_checked++;
    });
    $(".roomheads").each(function() {
        if ($(this).is(':checked'))
            number_of_roomheads_that_checked++;
    });


    $('#num_roomHeads').text(`${number_of_roomheads_that_checked} roomHeads`);
    $('#num_secertaries').text(`${number_of_secertaries_that_checked} secertaries`);
    $('#num_observers').text(`${number_of_observers_that_checked} observers`)

    //prevent two checkboxes or more clicked in the same row
    $(".roomheads").on('click', function() {
        if ($(this).is(':checked')) {
            number_of_roomheads_that_checked = 1;
            //prevent take more than one Room-Head in the same column
            $.each($('.roomheads'), function() {
                if (!this.disabled)
                    $(this).prop('checked', false);
            });
            //end prevent
            if ($(this).next().next().next().next().prop('checked')) {
                number_of_observers_that_checked--;
                $(this).next().next().next().next().prop('checked', false);
            }
            //$(this).next().next().prop('checked',false);
            $(this).prop('checked', true);
            if ($(this).next().next().prop('checked')) {
                $(this).next().next().prop('checked', false);
                number_of_secertaries_that_not_checked++;
                number_of_secertaries_that_checked--;
                //when you swich betwen secertary to observer in the same person
                if (number_of_secertaries_that_checked >= 2) {
                    $(".secertaries").each(function() {
                        if (!$(this).is(':checked'))
                            $(this).prop('disabled', true);
                    });
                } else {
                    $(".secertaries").each(function() {
                        if (!$(this).is(':checked') && !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                            $(this).prop('disabled', false);
                    });
                }
            }
        } else {
            number_of_roomheads_that_checked--;
        }
        //number_of_roomheads_that_checked++;
        if (number_of_roomheads_that_checked == 1) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_roomheads_that_checked == 0) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        }
        if (number_of_secertaries_that_checked == 2) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_secertaries_that_checked == 0) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
        if (number_of_observers_that_checked >= 2) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_observers_that_checked == 0) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
    });



    //let x=0;
    $(".secertaries").on('click', function() {
        if ($(this).is(':checked') && $(this).next().next().prop('checked')) {
            number_of_observers_that_checked--;
        }
        if ($(this).is(':checked') && $(this).prev().prev().prop('checked')) {
            number_of_roomheads_that_checked--;
        }
        if ($(this).is(':checked') && number_of_secertaries_that_checked < 2) {
            // if($(this).next().next().prop('checked')){
            //     number_of_observers_that_checked--;
            // }else if($(this).prev().prev().prop('checked')){
            //     number_of_roomheads_that_checked--;
            // }
            $(this).prev().prev().prop('checked', false);
            $(this).next().next().prop('checked', false);
            $(this).prop('checked', true);
            number_of_secertaries_that_checked++;
            number_of_secertaries_that_not_checked--;
            console.log('err1');
        } else if ($(this).is(':checked') && number_of_secertaries_that_checked >= 2) {
            $(this).prev().prev().prop('checked', false);
            $(this).next().next().prop('checked', false);
            $(this).prop('checked', true);
            number_of_secertaries_that_checked++;
            number_of_secertaries_that_not_checked--;
            console.log('err2');
        } else if (!$(this).is(':checked') && number_of_secertaries_that_checked < 2) {
            number_of_secertaries_that_checked--;
            number_of_secertaries_that_not_checked++;
            console.log('err3');
        } else {
            //$(this).prop('checked',false);
            number_of_secertaries_that_not_checked++;
            number_of_secertaries_that_checked--;
            console.log('err4');
        }
        console.log(number_of_secertaries_that_checked, number_of_secertaries_that_not_checked);
        if (number_of_secertaries_that_checked >= 2) {
            $(".secertaries").each(function() {
                if (!$(this).is(':checked'))
                    $(this).prop('disabled', true);
            });
        } else {
            $(".secertaries").each(function() {
                if (!$(this).is(':checked') && !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                    $(this).prop('disabled', false);
            });
        }
        if (number_of_roomheads_that_checked == 1) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_roomheads_that_checked == 0) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        }
        if (number_of_secertaries_that_checked == 2) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_secertaries_that_checked == 0) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
        if (number_of_observers_that_checked >= 2) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_observers_that_checked == 0) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
    });
    $(".observers").on('click', function() {
        if ($(this).is(':checked')) {
            number_of_observers_that_checked++;
            if ($(this).prev().prev().prop('checked')) {
                $(this).prev().prev().prop('checked', false);
                number_of_secertaries_that_not_checked++;
                number_of_secertaries_that_checked--;
                //when you swich betwen secertary to observer in the same person
                if (number_of_secertaries_that_checked >= 2) {
                    $(".secertaries").each(function() {
                        if (!$(this).is(':checked'))
                            $(this).prop('disabled', true);
                    });
                } else {
                    $(".secertaries").each(function() {
                        if (!$(this).is(':checked') && !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                            $(this).prop('disabled', false);
                    });
                }
            } else if ($(this).prev().prev().prev().prev().prop('checked')) {
                $(this).prev().prev().prev().prev().prop('checked', false);
                number_of_roomheads_that_checked--;
            }
        } else if (!$(this).is(':checked')) {
            number_of_observers_that_checked--;
        }
        if (number_of_roomheads_that_checked == 1) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_roomheads_that_checked == 0) {
            $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        }
        if (number_of_secertaries_that_checked == 2) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_secertaries_that_checked == 0) {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
        if (number_of_observers_that_checked >= 2) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
        } else if (number_of_observers_that_checked == 0) {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
        } else {
            $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
        }
    });
    let num_observers = `<h6><span class="badge bg-dark">${number_of_observers_that_checked}</span></h6>`;
    let num_secertaries = `<h6><span class="badge bg-dark">${number_of_secertaries_that_checked}</span></h6>`;
    // var $newdiv1 = $( `<div id='yy'>${num-observers}</div>` );
    // $( "span" ).append($newdiv1);
    // $('.rounded').prepend(`<span> I have been appended ${num_observers}</span>`);
    // $('.rounded').prepend(`<span> I have been appended ${num_secertaries}</span>`);
    // let i=0;
    // const timer=setInterval(()=>{
    // ++i;
    // if(i === 1000){
    // clearInterval(timer);
    // }
    // $('.rounded').prepend(`<span>${num_observers}</span>`);
    // $('.rounded').prepend(`<span>${num_secertaries}</span>`);
    // },200);
    if (number_of_roomheads_that_checked == 1) {
        $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
    } else if (number_of_roomheads_that_checked == 0) {
        $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
    }
    if (number_of_secertaries_that_checked == 2) {
        $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
    } else if (number_of_secertaries_that_checked == 0) {
        $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
    } else {
        $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
    }
    if (number_of_observers_that_checked >= 2) {
        $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="${imagesUrl}/success-icon.png" alt="success" style="width: 30px;height: 30px;">`);
    } else if (number_of_observers_that_checked == 0) {
        $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="${imagesUrl}/danger2.png" alt="danger" style="width: 30px;height: 30px;">`);
    } else {
        $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="${imagesUrl}/warning.png" alt="success" style="width: 30px;height: 30px;">`);
    }
});