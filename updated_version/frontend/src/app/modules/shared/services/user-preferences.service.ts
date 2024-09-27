import { Injectable } from '@angular/core';
import { Langs } from '../../../types/global';
import { Observable, of } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserPreferencesService {
  constructor() {
    this.setLang('en');
  }
  setLang(lang: Langs) {
    localStorage.setItem('lang', lang);
  }
  getLang(): Observable<Langs> {
    return of(localStorage.getItem('lang')! as Langs);
  }
}
