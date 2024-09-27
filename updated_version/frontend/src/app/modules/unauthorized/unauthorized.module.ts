import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UnAuthorizedComponent } from './pages/un-authorized/un-authorized.component';
import { MatMenuModule } from '@angular/material/menu';
import { MatIconModule } from '@angular/material/icon';
import { UnauthorizedRoutingModule } from './unauthorized-routing.module';
import { SharedModule } from 'app/modules/shared/shared.module';



@NgModule({
  declarations: [
    UnAuthorizedComponent
  ],
  imports: [
    CommonModule,
    MatMenuModule,
    MatIconModule,
    UnauthorizedRoutingModule,
    SharedModule
  ]
})
export class UnauthorizedModule { }
