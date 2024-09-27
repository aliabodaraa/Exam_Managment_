import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { securedRoutes } from './secured-routing';
import { LayoutModule } from './layout/layout.module';

@NgModule({
  declarations: [],
  imports: [CommonModule, LayoutModule, RouterModule.forChild(securedRoutes)],
})
export class SecuredModule {}
