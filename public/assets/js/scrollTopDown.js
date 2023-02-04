$(document).ready(function() {
    //console.log("scrollTopDown");
    $(".scroll_top_button").hide();
    //Scroll to the bottom
    $(".scroll_buttom_button").click(function() {
        $("html, body").animate({
            scrollTop: $('html, body').get(0).scrollHeight
        }, 200);
        $(".scroll_buttom_button").fadeOut(1000);
        $(".scroll_top_button").fadeIn(1000);
    });
    //Scroll to the top
    $(".scroll_top_button").click(function() {
        $('html, body').animate({
            scrollTop: $(window).get(0).top
        }, 200);
        $(".scroll_top_button").fadeOut(1000);
        $(".scroll_buttom_button").fadeIn(1000);
    });
    $(".scroll_top_button,.scroll_buttom_button").hover(function() {
        $(this).css({
            "background-color": "whitesmoke",
            "color": "#888"
        });
    }, function() {
        $(this).css({
            "background-color": "white",
            "color": "black"
        });
    });
});