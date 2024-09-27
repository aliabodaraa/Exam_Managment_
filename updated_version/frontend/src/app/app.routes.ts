import { Routes } from '@angular/router';

export const rootRoutes: Routes = [
  {
    path: '',
    loadChildren: () =>
      import('../app/modules/secured/secured.module').then(
        (m) => m.SecuredModule
      ),

    // canActivate: [KeyClockGuardService],
  },
];
