import { NgModule } from '@angular/core';
import { MatIconRegistry } from '@angular/material/icon';
import { DomSanitizer } from '@angular/platform-browser';

@NgModule()
export class IconsModule {
  constructor(
    private _domSanitizer: DomSanitizer,
    private _matIconRegistry: MatIconRegistry
  ) {
    // Register icon sets
    this._matIconRegistry.addSvgIconSetInNamespace(
      'icons',
      this._domSanitizer.bypassSecurityTrustResourceUrl(
        '/assets/icons/icons.svg'
      )
    );
  }
}
