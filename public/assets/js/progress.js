$(function() {
    $(".progress").each(function() {
        var value = $(this).attr('data-value');
        var left = $(this).find('.progress-left .progress-bar');
        var right = $(this).find('.progress-right .progress-bar');
        if (value > 0) {
            if (value <= 50) {
                right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
            } else {
                right.css('transform', 'rotate(180deg)')
                left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
            }
        }
    })

    function percentageToDegrees(percentage) {
        return percentage / 100 * 360
    }

    //increase slowly
    progress_remaining_to_full = parseInt($("#progress_remaining_to_full").text());
    //console.log(typeof(progress_remaining_to_full))
    var i = 0;
    const timer1 = setInterval(() => {
        i += 1;
        $("#progress_value").text(i);
        if (i == 100 - progress_remaining_to_full) {
            clearInterval(timer1);
        }
    }, 30);

    //increase slowly
    progress_remaining_to_full = parseInt($("#progress_remaining_to_full").text());
    //console.log(typeof(progress_remaining_to_full))
    var k = 0;
    const timer3 = setInterval(() => {
        var value = $("#progress_line").attr('data-value');
        //console.log(value)
        var left = $("#progress_line").find('.progress-left .progress-bar');
        var right = $("#progress_line").find('.progress-right .progress-bar');
        left.css('transform', 'rotate(0deg)')
        k += 1;
        if (k > 0) {
            if (k <= 50) {
                right.css('transform', 'rotate(' + percentageToDegrees(k) + 'deg)')
            } else {
                //right.css('transform', `rotate(180deg)`)
                left.css('transform', 'rotate(' + percentageToDegrees(k + 50) + 'deg)')
            }
        }
        if (k == value) {
            clearInterval(timer3);
        }
    }, 30);

});