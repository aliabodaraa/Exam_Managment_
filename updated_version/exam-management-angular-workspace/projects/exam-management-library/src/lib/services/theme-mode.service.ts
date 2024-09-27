import { DOCUMENT } from '@angular/common';
import { Injectable, inject } from '@angular/core';
import { Subject } from 'rxjs';
enum ThemeModes {
  DARK = 'dark',
  LIGHT = 'light',
}
@Injectable({
  providedIn: 'root',
})
export class ThemeModeService {
  private document = inject(DOCUMENT);
  public theme: ThemeModes = ThemeModes.DARK;
  onthemeChanged = new Subject<ThemeModes>();
  constructor() {
    this.setThemeMode();
  }

  setThemeMode() {
    this.document.body.classList.remove(
      this.theme === ThemeModes.DARK ? 'light' : 'dark'
    );
    this.document.body.classList.add(this.theme);
    this.onthemeChanged.next(this.theme);
  }

  changeTheme() {
    this.theme =
      this.theme === ThemeModes.DARK ? ThemeModes.LIGHT : ThemeModes.DARK;
    this.setThemeMode();
  }
}
