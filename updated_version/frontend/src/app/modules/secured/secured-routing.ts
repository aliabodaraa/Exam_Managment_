import { Route } from '@angular/router';
import { LayoutComponent } from './layout/layout.component';
import { RoundsModule } from './rounds/rounds.module';
import { CoursesModule } from './courses/courses.module';
import { RoomsModule } from './rooms/rooms.module';
import { UsersModule } from './users/users.module';
export const securedRoutes: Route[] = [
  {
    path: '',
    component: LayoutComponent,
    data: {
      condition: ['hasReadPolicy'],
    },
    children: [
      {
        path: '',
        pathMatch: 'full',
        redirectTo: 'users',
      },
      {
        path: 'dashboard',
        loadChildren: () =>
          import(
            '../../../app/modules/secured/dashboard/dashboard.module'
          ).then((m) => m.DashboardModule),
      },
      {
        path: 'users',
        loadChildren: () =>
          import('../../../app/modules/secured/users/users.module').then(
            (m) => m.UsersModule
          ),
      },
      {
        path: 'rooms',
        loadChildren: () =>
          import('../../../app/modules/secured/rooms/rooms.module').then(
            (m) => m.RoomsModule
          ),
      },
      {
        path: 'courses',
        loadChildren: () =>
          import('../../../app/modules/secured/courses/courses.module').then(
            (m) => m.CoursesModule
          ),
      },
      {
        path: 'rounds',
        loadChildren: () => RoundsModule,
      },
      // {
      //   path: 'profiles',
      //   loadChildren: () =>
      //     import('app/modules/secured/profile/profile.module').then(
      //       (m) => m.ProfileModule
      //     ),
      // },
      // {
      //   path: 'unauthorized',
      //   loadChildren: () =>
      //     import('app/modules/secured/unauthorized/unauthorized.module').then(
      //       (m) => m.UnauthorizedModule
      //     ),
      //   data: {
      //     breadcrumb: { key: 'unauthorized', path: '' },
      //   },
      // },
    ],
  },
];
