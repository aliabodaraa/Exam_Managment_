import { DOCUMENT } from '@angular/common';
import {
  Component,
  DestroyRef,
  Input,
  OnInit,
  Renderer2,
  inject,
} from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import moment from 'moment';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { UserPreferencesService } from '../../services/user-preferences.service';
import { Langs } from '../../../../types/global';

interface Lang {
  label: string;
  id: string;
  character: string;
}
// function destroyNotifier() {
//   const destroy = new Subject<void>();
//   inject(DestroyRef).onDestroy(() => {
//     destroy.next();
//     destroy.complete();
//   });
//   return destroy;
// }
@Component({
  selector: 'app-languages',
  templateUrl: './languages.component.html',
  styleUrls: ['./languages.component.scss'],
})
export class LanguagesComponent implements OnInit {
  @Input() typeLangBtn: 'circle' | 'sequare' = 'circle';
  languages: Lang[] = [
    {
      label: 'English',
      id: 'en',
      character: 'E',
    },
    {
      label: 'العربية',
      id: 'ar',
      character: 'ع',
    },
  ];
  private document = inject(DOCUMENT);
  private rendere2 = inject(Renderer2);
  private translate = inject(TranslateService);
  private preferences = inject(UserPreferencesService);

  selectedLang: Lang = this.languages[0];
  private destroyRef = inject(DestroyRef);
  ngOnInit(): void {
    this.translate.onLangChange
      .pipe(takeUntilDestroyed(this.destroyRef))
      .subscribe(({ lang }) => {
        console.log('---aa----', lang);
        this.preferences.setLang(lang as Langs);
        if (this.document) {
          //check if the enviroment is web
          let bodyEle = this.document.querySelector('body')!;
          if (lang === 'ar') this.rendere2?.addClass(bodyEle, 'rtl');
          else this.rendere2?.removeClass(bodyEle, 'rtl');
        }
        moment.locale(`${lang}-sa`);
      });
  }

  selectLang(lang: Lang) {
    this.selectedLang = lang;
    this.translate.use(lang.id);
  }
}
