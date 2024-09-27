import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { dashboardRoutes } from './dashboard-routiong.module';
import { DashboardComponent } from './page/dashboard.component';
import { SharedModule } from '../../shared/shared.module';

@NgModule({
  declarations: [DashboardComponent],
  imports: [CommonModule, RouterModule.forChild(dashboardRoutes), SharedModule],
})
export class DashboardModule {}
