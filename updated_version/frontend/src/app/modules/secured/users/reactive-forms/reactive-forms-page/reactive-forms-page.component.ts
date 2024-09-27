import {
  ChangeDetectionStrategy,
  ChangeDetectorRef,
  Component,
  OnDestroy,
  OnInit,
  ViewChild,
} from '@angular/core';
import { CommonModule } from '@angular/common';
import {
  FormGroupDirective,
  FormBuilder,
  FormControl,
  FormGroup,
  FormRecord,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import {
  bufferCount,
  filter,
  map,
  Observable,
  startWith,
  Subscription,
  tap,
} from 'rxjs';
import { banWords } from '../validators/ban-words.validator';
import { passwordShouldMatch } from '../validators/password-should-match.validator';
import { UniqueNicknameValidator } from '../validators/unique-nickname.validator';
import { DynamicValidatorMessage } from '../core/dynamic-validator-message.directive';
import { ValidatorMessageContainer } from '../core/input-error/validator-message-container.directive';
import { OnTouchedErrorStateMatcher } from '../core/input-error/error-state-matcher.service';
import { UserSkillsService } from '../core/user-skills.service';
import { TranslateModule } from '@ngx-translate/core';
import { MatDialogRef } from '@angular/material/dialog';
import { SharedModule } from '../../../../shared/shared.module';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-reactive-forms-page',
  standalone: true,
  imports: [
    CommonModule,
    ReactiveFormsModule,
    DynamicValidatorMessage,
    ValidatorMessageContainer,
    TranslateModule,
    SharedModule,
  ],
  templateUrl: './reactive-forms-page.component.html',
  styleUrls: [
    // '../common-page.scss',
    // '../common-form.scss',
    './reactive-forms-page.component.scss',
  ],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class ReactiveFormsPageComponent implements OnInit, OnDestroy {
  phoneLabels = ['Main', 'Mobile', 'Work', 'Home'];
  years = this.getYears();
  skills$!: Observable<string[]>;
  roles$!: Observable<{ roles: string[]; temporary_roles: string[] }>;

  showErrorStrategy = new OnTouchedErrorStateMatcher();
  userForm = this.fb.group({
    email: ['abodaraaali@gmail.com', [Validators.required, Validators.email]],
    username: ['abodaraaali', [Validators.required]],
    password: this.fb.group(
      {
        password: ['', [Validators.required, Validators.minLength(6)]],
        confirmPassword: '',
      },
      {
        validators: passwordShouldMatch,
      }
    ),
    role: ['', [Validators.required]],
    temporary_role: ['', [Validators.required]],
  });
  form = this.fb.group({
    firstName: [
      'Dmytro',
      [
        Validators.required,
        Validators.minLength(4),
        banWords(['test', 'dummy']),
      ],
    ],
    lastName: ['Mezhenskyi', [Validators.required, Validators.minLength(2)]],
    nickname: [
      '',
      {
        validators: [
          Validators.required,
          Validators.minLength(2),
          Validators.pattern(/^[\w.]+$/),
          banWords(['dummy', 'anonymous']),
        ],
        asyncValidators: [
          this.uniqueNickname.validate.bind(this.uniqueNickname),
        ],
        updateOn: 'blur',
      },
    ],
    email: [
      'dmytro@decodedfrontend.io',
      [Validators.email, Validators.required],
    ],
    yearOfBirth: this.fb.nonNullable.control(
      this.years[this.years.length - 1],
      Validators.required
    ),
    passport: ['', [Validators.pattern(/^[A-Z]{2}[0-9]{6}$/)]],
    address: this.fb.nonNullable.group({
      fullAddress: ['', Validators.required],
      city: ['', Validators.required],
      postCode: [0, Validators.required],
    }),
    phones: this.fb.array([
      this.fb.group({
        label: this.fb.nonNullable.control(this.phoneLabels[0]),
        phone: '',
      }),
    ]),
    skills: this.fb.record<boolean>({}),
    password: this.fb.group(
      {
        password: ['', [Validators.required, Validators.minLength(6)]],
        confirmPassword: '',
      },
      {
        validators: passwordShouldMatch,
      }
    ),
  });

  private ageValidators!: Subscription;
  private formPendingState!: Subscription;

  private initialFormValues: any;

  @ViewChild(FormGroupDirective)
  private formDir!: FormGroupDirective;

  constructor(
    private userSkills: UserSkillsService,
    public fb: FormBuilder,
    private uniqueNickname: UniqueNicknameValidator,
    private cd: ChangeDetectorRef,
    public dialogRef: MatDialogRef<ReactiveFormsPageComponent>,
    private http: HttpClient
  ) {}

  ngOnInit(): void {
    this.roles$ = this.http
      .get<{ roles: string[]; temporary_roles: string[] }>(
        'http://localhost/users/roles'
      )
      .pipe(
        tap(({ roles, temporary_roles }) => {
          this.userForm.controls.role.setValue(roles[0]),
            this.userForm.controls.temporary_role.setValue(temporary_roles[0]);
        }),
        tap(() => (this.initialFormValues = this.form.value))
      );
    this.ageValidators = this.form.controls.yearOfBirth.valueChanges
      .pipe(
        tap(() => console.log('AAAAAAa')),
        tap(() => this.form.controls.passport.markAsDirty()),
        startWith(this.form.controls.yearOfBirth.value),
        tap(() => console.log('BBBBBBb'))
      )
      .subscribe((yearOfBirth) => {
        this.isAdult(yearOfBirth)
          ? this.form.controls.passport.addValidators(Validators.required)
          : this.form.controls.passport.removeValidators(Validators.required);
        this.form.controls.passport.updateValueAndValidity();
      });
    this.formPendingState = this.form.statusChanges
      .pipe(
        bufferCount(2, 1),
        filter(([prevState]) => prevState === 'PENDING')
      )
      .subscribe(() => this.cd.markForCheck());
  }

  ngOnDestroy(): void {
    this.ageValidators.unsubscribe();
    this.formPendingState.unsubscribe();
  }

  addPhone() {
    this.form.controls.phones.insert(
      0,
      new FormGroup({
        label: new FormControl(this.phoneLabels[0], { nonNullable: true }),
        phone: new FormControl(''),
      })
    );
  }

  removePhone(index: number) {
    this.form.controls.phones.removeAt(index);
  }

  onSubmit(e: Event) {
    console.log(this.form.value);
    this.initialFormValues = this.form.value;
    this.formDir.resetForm(this.form.value);
  }
  onSubmitUserForm(e: Event) {
    console.log({
      ...this.userForm.value,
      password: this.userForm.value.password?.password,
    });
    // this.initialFormValues = this.form.value;
    // this.formDir.resetForm(this.form.value);
  }
  onReset(e: Event) {
    e.preventDefault();
    this.formDir.resetForm(this.initialFormValues);
  }
  onResetUserForm(e: Event) {
    e.preventDefault();
    this.formDir.resetForm(this.initialFormValues);
  }
  private getYears() {
    const now = new Date().getUTCFullYear();
    return Array(now - (now - 40))
      .fill('')
      .map((_, idx) => now - idx);
  }

  private buildSkillControls(skills: string[]) {
    skills.forEach((skill) =>
      this.form.controls.skills.addControl(
        skill,
        new FormControl(false, { nonNullable: true })
      )
    );
  }
  // private buildRoleControls(roles: string[]) {
  //   roles.forEach((skill) =>
  //     this.userForm.controls.roles.addControl(
  //       skill,
  //       new FormControl(false, { nonNullable: true })
  //     )
  //   );
  // }
  private isAdult(yearOfBirth: number): boolean {
    const currentYear = new Date().getFullYear();
    return currentYear - yearOfBirth >= 18;
  }

  closeForm(actionType: 'submit' | 'cancel') {
    this.dialogRef.close({
      actionType,
    });
  }
}
