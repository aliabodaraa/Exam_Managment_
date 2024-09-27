import { Component } from '@angular/core';
import { NuxeoService } from 'nuxeo-development-framework';

@Component({
  selector: 'app-un-authorized',
  templateUrl: './un-authorized.component.html',
})
export class UnAuthorizedComponent{

  constructor(
    private nuxeoService: NuxeoService) { }

  logOut(): void {
    this.nuxeoService.doLogout();
  }

}
