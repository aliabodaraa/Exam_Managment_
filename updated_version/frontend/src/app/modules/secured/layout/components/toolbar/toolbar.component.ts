import { Component, inject } from '@angular/core';
import { toolbarAnimation } from './toolbar.component.animations';
import { ThemeModeService } from '../../../../shared/services/theme-mode.service';
import {
  MenuItem,
  ToolbarMenusService,
} from '../../services/toolbar-menus-service/toolbar-menus.service';
import { TranslateService } from '@ngx-translate/core';
import { ProgressService } from '../../../../shared/services/loader.service';
import { NavigationEnd, NavigationStart, Router } from '@angular/router';
import { PortalBridgeService } from '../../../../shared/services/portal-bridge.service';

@Component({
  selector: 'app-toolbar',
  templateUrl: './toolbar.component.html',
  styleUrls: ['./toolbar.component.scss'],
  animations: [toolbarAnimation],
})
export class ToolbarComponent {
  loading: boolean = true;
  toolbarMenus: MenuItem[] = [];
  organizationFields = {
    arabicName: 'gkmpc:arabicName',
    englishName: 'gkmpc:englishName',
    code: 'gkmpc:code',
  };
  isArabic = false;
  progressBarValue: number = 50;
  public loaderService = inject(ProgressService);
  public progress$ = this.loaderService.progress$;
  public progressColor$ = this.loaderService.progressColor$;
  public router = inject(Router);
  private portalBridge = inject(PortalBridgeService);
  constructor(
    public themeServ: ThemeModeService,
    private toolbarMenusService: ToolbarMenusService,
    private translate: TranslateService
  ) {
    console.log(this.translate, '----------');
    this.toolbarMenus = this.toolbarMenusService.buildToolbarMenus();
    this.router.events.subscribe((event) => {
      if (event instanceof NavigationStart) {
        this.loaderService.reset();

        this.portalBridge.setPortal(null);
      }
      if (event instanceof NavigationEnd) {
        console.log('NavigationEnd AAAA');
      }
    });
  }

  changeTheme() {
    this.themeServ.changeTheme();
  }
}
