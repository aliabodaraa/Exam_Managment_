import { Injectable, OnDestroy } from '@angular/core';
import { Observable, Subject } from 'rxjs';
enum COLORS {
  PRIMARY = 'primary',
  WARNING = 'warn',
  ACCENT = 'accent',
}
@Injectable({
  providedIn: 'root',
})
export class ProgressService implements OnDestroy {
  private progress$$ = new Subject<number>();
  private progress_color$$ = new Subject<COLORS>();

  public reset() {
    this.progress_color$$.next(COLORS.PRIMARY);
    this.progress$$.next(0);
  }
  public emit(progress_val: number) {
    this.progress$$.next(progress_val);
  }
  public finalize() {
    this.progress$$.next(100);
  }
  public emitError() {
    this.progress_color$$.next(COLORS.WARNING);
  }
  public get progress$(): Observable<number> {
    return this.progress$$.asObservable();
  }
  public get progressColor$(): Observable<COLORS> {
    return this.progress_color$$.asObservable();
  }
  ngOnDestroy(): void {
    this.progress$$.unsubscribe();
    this.progress_color$$.unsubscribe();
  }
}
