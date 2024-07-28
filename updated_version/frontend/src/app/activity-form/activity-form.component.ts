import { Component, OnDestroy, OnInit } from '@angular/core';
import { PageTypeEnum, ProviderTypeEnum } from '../models/data-request-api';
import {
  FormArray,
  FormBuilder,
  FormControl,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import { FormArrayActivityKeysType } from '../models/form';
import * as form from '../models/form';
import { DatePipe, Location } from '@angular/common';

import {
  NgbCalendar,
  NgbDate,
  NgbDateStruct,
} from '@ng-bootstrap/ng-bootstrap';
import { EntryType, isActivityEntry } from '../models/app_data_state';
import { ActivatedRoute } from '@angular/router';
import { take } from 'rxjs/operators';
import { UploadCoverService } from '../services/upload-cover.service';
import { ToastrService } from 'ngx-toastr';
import { checkTimesForTwoMatchedDates } from './timesSameDay.validators';
import { Subscription } from 'rxjs';
import { isFileValid } from './file.validation';
import { ActivityService } from '../services/activity.service';
import { OrganizerService } from '../services/organizer.service';
import { TranslateService } from '@ngx-translate/core';
import { creatDateRangeValidator } from './dates.validators';
import { CustomToastrService } from 'nuxeo-development-framework';
type CoverPictureType = { 'upload-batch': string; 'upload-fileId': string };
type OrganizerObjectType = { id: string; name: string };
// declare var Datepicker: any;
@Component({
  selector: 'app-activity-form',
  templateUrl: './activity-form.component.html',
  styleUrls: ['./activity-form.component.scss'],
  providers: [DatePipe],
})
export class ActivityFormComponent implements OnInit, OnDestroy {
  submitted = false;
  entry: EntryType | null = null;
  pageType!: PageTypeEnum;
  providerType!: ProviderTypeEnum;
  model!: NgbDateStruct;
  today = this.calendar.getToday();
  form!: FormGroup;
  organizers_objects: OrganizerObjectType[] = [];
  entry_organizer_name!: string | null;
  coverPictureUrl: string | ArrayBuffer | null = null;
  isImageLoading = false;
  shouldCoverPictureExist = false;
  select_is_loaading = false;

  constructor(
    private location: Location,
    private ActivityService: ActivityService,
    private OrganizerService: OrganizerService,
    private route: ActivatedRoute,
    private toastr: CustomToastrService,
    private formBuilder: FormBuilder,
    private calendar: NgbCalendar,
    private uploadCoverService: UploadCoverService,
    private dpipe: DatePipe,
    private translate: TranslateService
  ) {
    translate.onLangChange.subscribe((x) => {
      translate
        .use(translate.currentLang)
        .subscribe((x) => console.log('useeeed'));
      console.log('ActivityFormComponent', translate.currentLang, x);
    });
    this.entry = this.ActivityService.getEntryInfo() ?? null;
    this.route.queryParamMap.pipe(take(1)).subscribe((queryParams) => {
      this.pageType = queryParams.get('page_type')! as PageTypeEnum;
      // this.providerType = queryParams.get('provider_type')! as ProviderTypeEnum;
    });

    if (this.entry && isActivityEntry(this.entry))
      this.coverPictureUrl = this.entry['activity:coverPicture']?.data;
  }
  meridian1 = true;
  meridian2 = true;
  currentPageIndex = 0;
  private initializeFormCreation() {
    this.form = this.formBuilder.group(
      {
        'dc:title': ['', Validators.required],
        'dc:description': ['', Validators.required],
        'activity:categorization': ['categ1', Validators.required],
        'activity:locations': this.formBuilder.group({
          city: ['city1', Validators.required],
          geographicLocation: ['', Validators.required],
        }),
        'activity:organizers': ['', Validators.required],
        'activity:startDate': ['', [Validators.required]],
        'activity:endDate': ['', Validators.required],
        'activity:timeFrom': ['', Validators.required],
        'activity:timeTo': ['', Validators.required],
        // 'activity:coverPicture': this.formBuilder.group({
        //   'upload-batch': '',
        //   'upload-fileId': '0',
        // }),
      },
      {
        validators: [checkTimesForTwoMatchedDates(), creatDateRangeValidator()],
      }
    );
  }
  ngOnInit() {
    this.initializeFormCreation();
    if (this.pageType === PageTypeEnum.Edit) {
      this.mapDataToForm();
      console.log('pageType', this.pageType, 'entry', this.entry);
    }
    this.getCustomizedOrganizersObjects();
  }
  getCustomizedOrganizersObjects() {
    this.select_is_loaading = true;
    // this.currentPageIndex++;
    console.log(this.currentPageIndex, 'ccccc');
    this.OrganizerService.getOrganizer(this.currentPageIndex++).subscribe(
      (res) => {
        let organizers_obj: OrganizerObjectType[] = res.entries.map(
          (entry: any) => {
            let org_obj: OrganizerObjectType = { id: '', name: '' };
            org_obj.id = entry.uid;
            org_obj.name = entry.properties['organizer:name'];
            return org_obj;
          }
        );
        console.log(
          organizers_obj,
          '{{{{{{{{{{{{{{{{{{before}}}}}}}}}}}}}}}}}'
        );
        this.organizers_objects = [
          ...this.organizers_objects,
          ...organizers_obj,
        ];
        this.select_is_loaading = false;
        console.log(
          this.organizers_objects,
          '{{{{{{{{{{{{{{{{{{after}}}}}}}}}}}}}}}}}'
        );
      }
    );
  }
  get f() {
    return this.form.controls;
  }
  get t() {
    return this.f.tickets as FormArray;
  }
  get accessLocation() {
    return this.f['activity:locations'] as FormGroup;
  }
  get accessCoverPicture() {
    return this.f['activity:coverPicture'] as FormGroup;
  }
  get ticketFormGroups() {
    return this.t.controls as FormGroup[];
  }
  public updateSelectedDate(date: NgbDate) {
    // Use this method to set any other date format you want
    this.f['activity:endDate'].setValue(
      new Date(date.year, date.month, date.day)
    );
  }
  onReset() {
    // reset whole form back to initial state
    this.submitted = false;
    this.form.reset();
    this.t.clear();
  }

  onClear() {
    // clear errors and reset ticket fields
    this.submitted = false;
    this.t.reset();
  }

  private mapDataToForm() {
    if (this.entry && isActivityEntry(this.entry)) {
      this.form.patchValue({
        'dc:title': this.entry['title'],
        'dc:description': this.entry['description'],
        'activity:categorization': this.entry['activity:categorization'],
        'activity:startDate': this.dpipe.transform(
          this.entry['activity:startDate'],
          'yyyy-MM-dd'
        ), //accept '2023-11-22'
        'activity:endDate': this.dpipe.transform(
          this.entry['activity:endDate'],
          'yyyy-MM-dd'
        ), //accept '2023-11-22'
        'activity:organizers': this.entry['activity:organizers'][0],
        'activity:timeFrom': this.entry['activity:timeFrom'],
        'activity:timeTo': this.entry['activity:timeTo'],
        // 'activity:coverPicture': this.entry['activity:coverPicture'],
        'activity:locations': this.entry['locations'],
      });
      for (const key in this.entry) {
        this.form.controls[key]?.markAllAsTouched();
      }
    }
  }

  private subscribeCoverPictureFieldChanges() {
    return this.accessCoverPicture.valueChanges.subscribe((val) => {
      if (val) {
        this.shouldCoverPictureExist = true;
        console.log('enter valueChanges1 -------');
      }
      console.log('enter valueChanges2 -------');
    });
  }

  public addToFormArray(
    formArray: FormArray,
    formArraykey: FormArrayActivityKeysType,
    ...newValues: HTMLInputElement[]
  ) {
    let propActivitiesMetaData =
      form.default.getControlsOfActivityPropertiesMetaData()[formArraykey];
    let type = propActivitiesMetaData.type;
    let chKeys = propActivitiesMetaData.childrenKeys;
    let Validators = propActivitiesMetaData.validators;
    let childrenValidators = propActivitiesMetaData.childrenValidators;
    if (type === 'arr_controls') {
      formArray.push(new FormControl(newValues[0].value, Validators));
    } else if (chKeys?.length)
      formArray.push(
        new FormGroup(
          {
            [chKeys[0]]: new FormControl(
              newValues[0].value,
              childrenValidators
            ),
            [chKeys[1]]: new FormControl(newValues[1].value),
          },
          Validators
        )
      );
    for (const inputElement of newValues) {
      inputElement.value = '';
    }
  }
  public removeFromFormArray(formArray: FormArray, index: number) {
    formArray.removeAt(index);
  }
  public save() {
    this.submitted = true;
    let formValue: Partial<EntryType> = this.form.value;
    console.log(
      this.pageType,
      '--------------------------------',
      this.providerType,
      '--------------------------------',
      this.entry
    );
    console.log(this.form);
    if (this.form.valid) {
      if (this.pageType === PageTypeEnum.New) {
        this.ActivityService.saveActivity(formValue).subscribe(
          (s) => {
            this.location.back();
            this.toastr.show(
              'success',
              'TOASTER.SUCCESS.title',
              'TOASTER.SUCCESS.activity-new'
            );
          },
          (e) => {
            this.submitted = false;
            this.toastr.show(
              'error',
              'TOASTER.ERROR.title',
              'TOASTER.ERROR.activity-new'
            );
          }
        );
      } else if (this.pageType === PageTypeEnum.Edit && this.entry) {
        this.ActivityService.updateActivity(
          formValue,
          this.entry.uid
        ).subscribe(
          (s) => {
            this.location.back();
            this.toastr.show(
              'success',
              'TOASTER.SUCCESS.title',
              'TOASTER.SUCCESS.activity-update'
            );
          },
          (e) => {
            this.submitted = false;
            this.toastr.show(
              'error',
              'TOASTER.ERROR.title',
              'TOASTER.ERROR.activity-update'
            );
          }
        );
      }
    }
    console.log(this.pageType);
  }
  clickCoverPictureInput() {
    document.getElementById('coverPictureInput')?.click();
  }
  onAttachFileChange(event: any): void {
    const file: File = event.target.files[0];
    const reader = new FileReader();

    if (!isFileValid(file)) return;

    this.isImageLoading = true;
    reader.readAsDataURL(file);

    reader.onloadend = () => {
      this.coverPictureUrl = reader.result;
      console.log(event, file, reader);
    };

    console.log('change________________', file, reader.result);

    this.requestBlobImage(file);
  }
  // on select image
  private requestBlobImage(source: string | File) {
    this.uploadCoverService.uploadCover(source).subscribe(
      (res: any) => {
        this.setCoverPictureControl(res.blob);
        this.isImageLoading = false;
      },
      (err: any) => {
        this.isImageLoading = false;
        this.toastr.show(
          'error',
          'TOASTER.ERROR.title',
          'TOASTER.ERROR.upload-image'
        );
      }
    );
  }
  private setCoverPictureControl(
    uploding_contents: CoverPictureType,
    validator?: ValidatorFn
  ) {
    let coverPictureFormGroup = this.formBuilder.group({
      'upload-batch': [uploding_contents['upload-batch']],
      'upload-fileId': uploding_contents['upload-fileId'],
    });
    if (validator) coverPictureFormGroup.addValidators(validator);
    this.form.setControl('activity:coverPicture', coverPictureFormGroup);

    console.log(uploding_contents);
  }
  resetCoverImage() {
    this.coverPictureUrl = null;

    this.setCoverPictureControl(
      {
        'upload-batch': '',
        'upload-fileId': '0',
      },
      Validators.requiredTrue
    );

    this.f['activity:coverPicture'].markAsTouched();
  }
  swipeCoverPicture() {
    var largeImage = document.getElementById('coverPicture')!;
    largeImage.style.display = 'block';
    largeImage.style.width = 200 + 'px';
    largeImage.style.height = 200 + 'px';
    var url = largeImage.getAttribute('src')!;
    window.open(
      url,
      'Image',
      'width=largeImage.stylewidth,height=largeImage.style.height,resizable=1'
    );
  }

  setMinDate() {
    let startDate = new Date(this.form.get('activity:startDate')?.value);
    let month = '' + (startDate.getMonth() + 1);
    let day = '' + startDate.getDate();
    let year = startDate.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    document
      .getElementById('endDate')
      ?.setAttribute('min', [year, month, day].join('-'));
  }
  setMaxDate() {
    let endDate = new Date(this.form.get('activity:endDate')?.value);
    if (!endDate) return;
    let month = '' + (endDate.getMonth() + 1);
    let day = '' + endDate.getDate();
    let year = endDate.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    document
      .getElementById('startDate')
      ?.setAttribute('max', [year, month, day].join('-'));
  }
  ngOnDestroy(): void {
    localStorage.removeItem('entry');
  }
}
