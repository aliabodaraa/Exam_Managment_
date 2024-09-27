import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { UnAuthorizedComponent } from './pages/un-authorized/un-authorized.component';

const routes: Routes = [
  {
    path: '',
    component: UnAuthorizedComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UnauthorizedRoutingModule { }
