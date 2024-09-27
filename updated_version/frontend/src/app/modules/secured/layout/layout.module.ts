import { NgModule } from '@angular/core';
import { LayoutComponent } from './layout.component';
import { ToolbarComponent } from './components/toolbar/toolbar.component';
import { SideMenuComponent } from './components/side-menu/side-menu.component';
import { SharedModule } from '../../shared/shared.module';

@NgModule({
  declarations: [LayoutComponent, ToolbarComponent, SideMenuComponent],
  imports: [SharedModule],
  exports: [SideMenuComponent],
})
export class LayoutModule {}
