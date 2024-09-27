import { NgModule } from '@angular/core';
import { RoomsPageComponent } from './rooms-page/rooms-page.component';
import { SharedModule } from '../../shared/shared.module';
import { RouterModule } from '@angular/router';
import { roomsRoutes } from './rooms-routiong.module';

@NgModule({
  declarations: [RoomsPageComponent],
  imports: [SharedModule, RouterModule.forChild(roomsRoutes)],
})
export class RoomsModule {}
