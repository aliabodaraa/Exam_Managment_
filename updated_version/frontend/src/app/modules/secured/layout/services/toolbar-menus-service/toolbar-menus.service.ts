import { Injectable } from '@angular/core';

export interface MenuItem {
  key: string;
  icon: string;
  url: string;
  accessCondition?: string;
}

@Injectable({
  providedIn: 'root',
})
export class ToolbarMenusService {
  constructor() {
    this.buildToolbarMenus();
  }

  buildToolbarMenus(): MenuItem[] {
    return [
      {
        key: 'home',
        icon: 'icons:home',
        url: '/dashboard',
      },
      {
        key: 'users',
        icon: 'icons:users',
        url: '/users',
        accessCondition: 'users',
      },
      {
        key: 'rooms',
        icon: 'icons:rooms',
        url: '/rooms',
        accessCondition: 'rooms',
      },
      {
        key: 'courses',
        icon: 'icons:courses',
        url: '/courses',
        accessCondition: 'courses',
      },
    ];
  }
}
