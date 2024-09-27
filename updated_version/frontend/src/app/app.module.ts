import { BrowserModule } from '@angular/platform-browser';
import { NgModule, inject } from '@angular/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {
  HttpClient,
  provideHttpClient,
  withInterceptors,
} from '@angular/common/http';
import { RouterModule } from '@angular/router';
import { rootRoutes } from './app.routes';
import { IconsModule } from './modules/icons.module';
import {
  TranslateLoader,
  TranslateModule,
  TranslateService,
} from '@ngx-translate/core';
import { LoadingInterceptor } from './modules/shared/intercepters/loading.interceptor';
import { SharedModule } from './modules/shared/shared.module';
let counter = 0;
// export function loggingInterceptor(
//   req: HttpRequest<unknown>,
//   next: HttpHandlerFn
// ): Observable<HttpEvent<unknown>> {
//   inject(ProgressService).setLoading(counter++);
//   return next(req);
// }
export function HttpLoaderFactory(http: any): TranslateHttpLoader {
  return new TranslateHttpLoader(http, '../../../assets/i18n/');
}
import { PaginatorComponent } from 'exam-management-library';
@NgModule({
  declarations: [AppComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    RouterModule.forRoot(rootRoutes),
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: HttpLoaderFactory,
        deps: [HttpClient],
      },
      defaultLanguage: 'en',
    }),
    IconsModule,
    SharedModule,
    PaginatorComponent,
  ],
  providers: [provideHttpClient(withInterceptors([LoadingInterceptor]))],
  bootstrap: [AppComponent],
})
export class AppModule {
  constructor(private translateService: TranslateService) {
    this.translateService.addLangs(['ar', 'en']);
    this.translateService.use('en');
  }
}
