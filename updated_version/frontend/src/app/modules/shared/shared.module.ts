import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MaterialModule } from '../material.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ActionAreaComponent } from './components/action-area/action-area.component';
import { ActionsButtonsComponent } from './components/actions-buttons/actions-buttons.component';
import { TranslateModule } from '@ngx-translate/core';
import { RouterModule } from '@angular/router';
import { PortalModule } from '@angular/cdk/portal';
import { LanguagesComponent } from './components/languages/languages.component';

@NgModule({
  declarations: [
    ActionAreaComponent,
    ActionsButtonsComponent,
    LanguagesComponent,
  ],
  imports: [
    CommonModule,
    MaterialModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule,
    TranslateModule,
    PortalModule,
  ],
  exports: [
    CommonModule,
    MaterialModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule,
    TranslateModule,
    PortalModule,
    ActionAreaComponent,
    ActionsButtonsComponent,
    LanguagesComponent,
  ],
})
export class SharedModule {}
