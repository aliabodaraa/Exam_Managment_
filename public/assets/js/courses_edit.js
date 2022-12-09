$(document).ready(function() {

    //show button when rendering the page
    $.each($(".rooms"), function() {
        if ($(this).is(':checked'))
            $(this).parent().siblings().last().children(":last-child").css({ 'display': 'initial' });
    });

    $('[name="all_rooms"]').on('click', function() {
        if ($(this).is(':checked')) {
            $.each($('.rooms'), function() {
                if (!this.disabled)
                    $(this).prop('checked', true);
            });
        } else {
            $.each($('.rooms'), function() {
                $(this).prop('checked', false);
            });
        }
    });

    //show the button when ckick the checkbox
    $(".rooms").on('click', function() {
        //$(this).parent().siblings().last().css('backgroundColor', 'red');
        if ($(this).is(':checked')) {
            $.each($(this), function() {
                $(this).parent().siblings().last().children(":last-child").css({ 'display': 'initial' });
                $(this).parent().siblings().next().children(".common-courses").css({ 'display': 'initial' });
            });
        } else {
            $.each($(this), function() {
                $(this).parent().siblings().last().children(":last-child").css({ 'display': 'none' });
                $(this).parent().siblings().next().children(".common-courses").css({ 'display': 'none' });
            });
        }
    });
});