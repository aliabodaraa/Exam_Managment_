import { CdkPortal } from '@angular/cdk/portal';
import {
  Component,
  ElementRef,
  OnChanges,
  OnDestroy,
  OnInit,
  SimpleChanges,
  ViewChild,
} from '@angular/core';
import {
  Subscription,
  debounceTime,
  distinctUntilChanged,
  fromEvent,
  map,
  tap,
} from 'rxjs';
import { HttpClient, HttpContext, HttpParams } from '@angular/common/http';
import { PortalBridgeService } from '../../../shared/services/portal-bridge.service';
import { LOADING_ENABLED } from '../../../shared/intercepters/loading.interceptor';
import { MatDialog } from '@angular/material/dialog';
import { ReactiveFormsPageComponent } from '../reactive-forms/reactive-forms-page/reactive-forms-page.component';
import { EmittedPaginatorValueType } from 'exam-management-library';
export interface User {
  id: number;
  email: string;
  username: string;
  number_of_observation: number;
  role: string;
  temporary_role: string;
  city: string;
  is_active: number;
  property: string;
  department_id: null;
  faculty_id: number;
  created_at: null;
  updated_at: string;
}
type PropNames =
  | 'email'
  | 'username'
  | 'number_of_observation'
  | 'role'
  | 'temporary_role'
  | 'city'
  | 'is_active'
  | 'property';

type DataType1 = Record<PropNames, string> &
  Record<'department' | 'faculty', { name: string }>;
@Component({
  selector: 'app-users-page',
  templateUrl: './users-page.component.html',
  styleUrls: ['./users-page.component.scss'],
})
export class UsersPageComponent implements OnInit, OnDestroy, OnChanges {
  @ViewChild(CdkPortal, { static: true })
  portalContent: CdkPortal;
  data_count: number;
  has_next: boolean;
  has_previous: boolean;
  last_page: number;
  next_page: number;
  previous_page: number;
  current_page: number;
  iterms_per_page: number;
  paginator_length: number;
  showForm = false;
  dataSourceSubscription: Subscription;
  data: any;
  @ViewChild('term', { static: true })
  termElement!: ElementRef<HTMLInputElement>;
  term:string='';

  constructor(
    private portalBridge: PortalBridgeService,
    private http: HttpClient,
    public dialog: MatDialog
  ) {
    this.getNextPage();
  }

  openDialog() {
    this.dialog.open(ReactiveFormsPageComponent, {
      width: '900px',
      height: '700px',
      panelClass: 'dialogWrapper',
      // disableClose: true,
    });
  }
  ngOnChanges(changes: SimpleChanges): void {
    console.log(changes, '----------');
  }
  loaded: boolean;
  getNextPage(
    emitted_paginator_value: EmittedPaginatorValueType = { pageIndex: 1 }
  ) {
    this.loaded = false;
    this.dataSourceSubscription = 
    this.http
      .get<any>('http://localhost/users', {
        params: new HttpParams({
          fromObject: {
            ...emitted_paginator_value,
          },
        }),
        context: new HttpContext().set(LOADING_ENABLED, true),
      })
      .pipe(tap(() => (this.loaded = true)))
      .subscribe((result) => {
        this.data = result
      });
  }
  // requiredProps={
  //   Name:{accessor_api:'username',order:1},Email:{accessor_api:'email',order:2},
  //   'Number Of Observation':{accessor_api:'number_of_observation',order:3},
  //   Role:{accessor_api:'role',order:4},
  //   'Temporary Role':{accessor_api:'temporary_role',order:5},
  //   City:{accessor_api:'city',order:6},
  //   Property:{accessor_api:'property',order:7},
  //   faculty_name:{accessor_api:'faculty?.name',order:8},
  //   department_name:{accessor_api:'department?.name',order:9},
  //   'is_active':{accessor_api:'is_active',order:10}
  // }
  ngOnInit(): void {
    this.portalBridge.setPortal(this.portalContent);
    console.log(this.portalBridge, 'this.portalBridge');
  }
  ngOnDestroy() {
    // this.portalContent?.detach();
    this.dataSourceSubscription.unsubscribe();
  }
}
