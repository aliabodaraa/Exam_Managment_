import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss'],
})
export class FooterComponent {
  @Input() usedIn: 'withLogIn' | 'withoutLogIn' = 'withLogIn';
  constructor(private router: Router) {}

  navigateTo(to: string) {
    let route = this.usedIn === 'withLogIn' ? 'information' : 'info';
    this.router.navigate([`/${route}/${to}`]);
  }
}
