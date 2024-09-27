import { Injectable, inject } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor,
  HttpHandlerFn,
  HttpContextToken,
} from '@angular/common/http';
import {
  Observable,
  Subscription,
  animationFrameScheduler,
  interval,
  of,
} from 'rxjs';
import {
  catchError,
  delay,
  finalize,
  share,
  take,
  takeWhile,
  tap,
  timeout,
} from 'rxjs/operators';
import { ProgressService } from '../services/loader.service';
import { AnimationFrameScheduler } from 'rxjs/internal/scheduler/AnimationFrameScheduler';

// @Injectable()
// export class LoadingInterceptor implements HttpInterceptor {
//   private totalRequests = 0;
//   private progressService = inject(ProgressService);
//   private counter = 0;

//   intercept(
//     request: HttpRequest<unknown>,
//     next: HttpHandler
//   ): Observable<HttpEvent<unknown>> {
//     console.log('caught', this.counter++);
//     this.totalRequests++;
//     this.progressService.setLoading(this.counter);
//     return next.handle(request).pipe(
//       finalize(() => {
//         this.totalRequests--;
//         if (this.totalRequests == 0) {
//           this.progressService.setLoading(100);
//         }
//       })
//     );
//   }
// }

export const LOADING_ENABLED = new HttpContextToken<boolean>(() => false);

let totalRequests = 0;
export function LoadingInterceptor(
  req: HttpRequest<unknown>,
  next: HttpHandlerFn
): Observable<HttpEvent<unknown>> {
  if (req.context.get(LOADING_ENABLED)) {
    console.log(req.reportProgress, 'reportProgress');

    let progressService = inject(ProgressService);
    totalRequests++;
    let sub = interval(100, animationFrameScheduler)
      .pipe(
        tap((x) => progressService.emit(x)),
        tap(console.log),
        takeWhile((x) => x < 100)
      )
      .subscribe();
    return next(req).pipe(
      finalize(() => {
        totalRequests--;
        if (totalRequests == 0) {
          sub.unsubscribe();
          progressService.finalize();
          console.log('=========FINISH REQUESTS============');
        }
      }),
      catchError((err) =>
        of(err).pipe(
          tap((e) => {
            progressService.emitError();
            console.log(e, 'After ERROR');
          })
        )
      )
    );
  } else {
    // caching has been disabled for this request
    return next(req);
  }
}
