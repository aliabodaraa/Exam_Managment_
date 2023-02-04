var start_rotation_val;
document.getElementsByClassName('date_picker_start')[0].onchange = (e) => {
    start_rotation_val = e.target.value;
}
var end_rotation_val;
document.getElementsByClassName('date_picker_end')[0].onchange = (e) => {
    console.log(document.getElementsByClassName('date_picker_end')[0]);
    end_rotation_val = e.target.value;
}
let date_picker_start = (e) => {
    console.log(e);
    today = new Date(),
        //today=today.toDateString(),
        month = '' + (today.getMonth() + 1),
        day = '' + today.getDate(),
        year = today.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    $('.date_picker_start').attr('min', [year, month, day].join('-'));

    if (end_rotation_val !== undefined) {
        $('.date_picker_start').attr('max', end_rotation_val);
    }
};

let date_picker_end = () => {
    //console.log(start_rotation_val);
    today = new Date(),
        //today=today.toDateString(),
        month = '' + (today.getMonth() + 1),
        day = '' + today.getDate(),
        year = today.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    if (start_rotation_val !== undefined) {
        $('.date_picker_end').attr('min', start_rotation_val);
    } else {
        $('.date_picker_end').attr('min', [year, month, day].join('-'));
    }
};

var current_rotation;

function myFunction(x) {
    console.log(x);
    current_rotation = JSON.parse(x);
    console.log(current_rotation.start_date + "\n" + current_rotation.end_date);
    $('#date_picker').attr('min', current_rotation.start_date);
    $('#date_picker').attr('max', current_rotation.end_date);
}