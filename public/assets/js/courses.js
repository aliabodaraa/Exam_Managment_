$(document).ready(function() { //console.log(4444);
    //Filtering Start
    searchCourses = (x) => {
            let courses = JSON.parse(x);
            $(".course").hide();
            jQuery.each(courses, function(id) {
                if (courses[id]["course_name"].indexOf($('#search_course_name').val()) > -1)
                    $("#" + courses[id]["id"]).show();
            });
        }
        //Filtering End
});