import { CdkPortal } from '@angular/cdk/portal';
import { PortalBridgeService } from './../portal-bridge.service';
import { Component, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { Observable, Subscription, tap } from 'rxjs';
import { HttpClient, HttpParams } from '@angular/common/http';
import { EmittedPaginatorValueType } from '../types/paginator';
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

@Component({
  selector: 'app-users-page',
  templateUrl: './users-page.component.html',
  styleUrls: ['./users-page.component.scss'],
})
export class UsersPageComponent implements OnInit, OnDestroy {
  @ViewChild(CdkPortal, { static: true })
  portalContent: CdkPortal;

  displayedColumns: string[] = [
    'email',
    'username',
    'number_of_observation',
    'role',
    'temporary_role',
    'city',
    'is_active',
    'property',
  ];
  data_count: number;
  has_next: boolean;
  has_previous: boolean;
  last_page: number;
  next_page: number;
  previous_page: number;
  remaining_items: number;
  current_page: number;
  iterms_per_page: number;

  showForm = false;
  dataSourceSubscription: Subscription;
  dataSource: any;
  progress$: Observable<number>;
  progress2$: Observable<number>;

  constructor(
    private portalBridge: PortalBridgeService,
    private http: HttpClient
  ) {
    this.getNextPage();
  }

  loaded: boolean;
  getNextPage(
    emitted_paginator_value: EmittedPaginatorValueType = { pageIndex: 1 }
  ) {
    this.loaded = false;
    // this.progress$ = interval(1000 / 19, animationFrameScheduler).pipe(
    //   takeWhile((x) => !this.loaded)
    // );
    console.log(emitted_paginator_value, 'emitted_paginator_value');
    this.dataSourceSubscription = this.http
      .get<any>('http://localhost:80/users/index', {
        params: new HttpParams({
          fromObject: {
            ...emitted_paginator_value,
          },
        }),
      })
      .pipe(tap(() => (this.loaded = true)))
      .subscribe((result) => {
        this.dataSource = result.data;
        this.data_count = result.data_count;
        this.has_next = result.has_next;
        this.has_previous = result.has_previous;
        this.last_page = result.last_page;
        this.next_page = result.next_page;
        this.previous_page = result.previous_page;
        this.remaining_items = result.remaining_items;
        this.current_page = result.current_page;
        this.iterms_per_page = result.iterms_per_page;
      });
  }
  ngOnInit(): void {
    this.portalBridge.setPortal(this.portalContent);
  }
  ngOnDestroy() {
    this.portalContent.detach();
    this.dataSourceSubscription.unsubscribe();
  }
}
