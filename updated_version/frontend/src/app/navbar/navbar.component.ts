import { Component, OnInit, ElementRef } from '@angular/core';
import { KeycloakProfile } from 'keycloak-js';
import { AuthService } from '../services/auth.service';
import { TranslateService } from '@ngx-translate/core';
import { AppConfigService } from 'nuxeo-development-framework';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'],
  host: {
    '(document:click)': 'onClick($event)',
  },
})
export class NavbarComponent implements OnInit {
  appUserBs: string | undefined;
  isMenuCollapsed = true;
  isTokenValid: boolean = false;
  profileUser: KeycloakProfile | null = null;
  constructor(
    public auth: AuthService,
    public appConfService: AppConfigService,
    public translate: TranslateService
  ) {
    translate.addLangs(['en', 'ar']);
    // {{'slide-bar.logout'|translate}}
    this.auth
      .isTokenValid()
      .then((isTokenValid) => {
        this.isTokenValid = isTokenValid;
      })
      .catch((x) => console.log('QQQQQQQQQQQQQQQQQQQQ'));
  }
  onClick(event: Event) {}
  logout() {
    this.auth.logout();
  }
  isUserMenuOpen = false;
  isUserMobileMenuOpen = false;
  isTranslationMenuOpen = false;
  clickOutside(type_param: string) {
    //console.log('CBBBBBBBBBBB', type_param);
    if (type_param == 'languages_dropdown') this.isTranslationMenuOpen = false;
    else if (type_param == 'profile_dropdown') this.isUserMenuOpen = false;
  }
  ngOnInit(): void {}
  useArabic() {
    document.querySelector('html')?.style.setProperty('direction', 'rtl');
    return this.translate.use('ar');
  }
  useEnglish() {
    document.querySelector('html')?.style.setProperty('direction', 'ltr');
    return this.translate.use('en');
  }
}
