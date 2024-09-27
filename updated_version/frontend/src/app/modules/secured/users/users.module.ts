import { NgModule } from '@angular/core';
import { UsersPageComponent } from './users-page/users-page.component';
import { SharedModule } from '../../shared/shared.module';
import { RouterModule } from '@angular/router';
import { usersRoutes } from './users-routiong.module';
import { PaginatorComponent, TableComponent } from 'exam-management-library';

@NgModule({
  declarations: [UsersPageComponent],
  imports: [SharedModule, RouterModule.forChild(usersRoutes), PaginatorComponent,TableComponent],
})
export class UsersModule {}
