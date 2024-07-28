import { FormGroup, ValidationErrors } from '@angular/forms';

export function checkTimesForTwoMatchedDates() {
  return (form: FormGroup): ValidationErrors | null => {
    const start_date: string = form.controls['activity:startDate'].value;
    const end_date: string = form.controls['activity:endDate'].value;
    const time_from: string = form.controls['activity:timeFrom'].value;
    const time_to: string = form.controls['activity:timeTo'].value;
    // console.log(start_date, end_date, time_from, time_to);
    if (start_date && end_date) {
      let s = new Date(start_date).getTime();
      let e = new Date(end_date).getTime();
      const is_same_day = e - s == 0;
      if (is_same_day) {
        console.log('is_same_day');
        let time_from_converter = getDateFromStringTime(time_from);
        let time_to_converter = getDateFromStringTime(time_to);

        if (time_from_converter > time_to_converter) {
          console.log('is_same_day-->timeRange');
          return { timeRange: true };
        }
        return null;
      }
    }
    return null;
  };
  function getDateFromStringTime(time_string: string) {
    let date_from_time_string = new Date();
    let parts = time_string.match(/(\d+)\:(\d+)/)!;
    let hours = parseInt(parts[1], 10);
    let minutes = parseInt(parts[2], 10);
    date_from_time_string.setHours(hours);
    date_from_time_string.setMinutes(minutes);
    return date_from_time_string;
  }
}
