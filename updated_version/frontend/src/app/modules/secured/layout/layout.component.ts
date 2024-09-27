import { Component } from '@angular/core';
import { Router } from '@angular/router';
// import { KeycloakService } from 'keycloak-angular';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss'],
})
export class LayoutComponent {
  constructor(
    public router: Router // public keyClock: KeycloakService
  ) {}
  ngAfterViewInit() {
    // document.getElementById('openSysLoader')?.remove();
  }
}
