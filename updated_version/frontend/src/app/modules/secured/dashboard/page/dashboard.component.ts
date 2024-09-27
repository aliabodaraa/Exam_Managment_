import { Component, OnDestroy, OnInit, ViewEncapsulation } from '@angular/core';
import { Subscription } from 'rxjs';
import { ThemeModeService } from '../../../shared/services/theme-mode.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
  encapsulation: ViewEncapsulation.None,
  host: { class: 'dashboardWrapper' },
})
export class DashboardComponent implements OnInit, OnDestroy {
  canAccessSideMenu = true;

  isArabic: boolean;
  sub: Subscription;
  showSideMenu: boolean = true;
  constructor(public themeServ: ThemeModeService) {}

  ngOnInit() {}

  changeTheme() {
    this.themeServ.changeTheme();
  }

  ngOnDestroy(): void {
    if (this.sub) {
      this.sub.unsubscribe();
    }
  }
  ngAfterViewInit(): void {
    const hamburgerBtn = document.getElementById('hamburger-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const toggleMenu = () => {
      mobileMenu!.classList.toggle('flex');
      mobileMenu!.classList.toggle('hidden');
      hamburgerBtn!.classList.toggle('toggle-btn');
    };
    hamburgerBtn!.addEventListener('click', toggleMenu);
    mobileMenu!.addEventListener('click', toggleMenu);
  }
}
