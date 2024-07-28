import {
  ChangeDetectionStrategy,
  Component,
  EventEmitter,
  Input,
  Output,
  SimpleChanges,
} from '@angular/core';
import { EmittedPaginatorValueType } from '../types/paginator';

@Component({
  selector: 'app-paginator',
  templateUrl: './paginator.component.html',
  styleUrls: ['./paginator.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class PaginatorComponent {
  @Input('current_page') current_page: number = 1;
  @Input('last_page') last_page: number;
  @Input('has_previous') has_previous: boolean;
  @Input('has_next') has_next: boolean;
  @Input('previous_page') previous_page: number;
  @Input('next_page') next_page: number;
  @Input('iterms_per_page') iterms_per_page: number;
  @Output('changeEmitter') emitter: EventEmitter<EmittedPaginatorValueType> =
    new EventEmitter();
  @Input('loaded') set loaded(val: boolean) {
    this.loaded_ = val;
  }
  get loaded() {
    return this.loaded_;
  }
  loaded_: boolean;

  next(pageIndex: number, resetMode?: boolean) {
    this.loaded_ = false;
    console.log(pageIndex, this.current_page, this.last_page);
    let obj: EmittedPaginatorValueType = {
      pageIndex,
      itermsPerPage: +this.iterms_per_page,
    };
    this.emitter.emit(obj);
    let interval: any;
    if (resetMode) {
      //this section for the case when we change the value of the slecet `items_per_page` and the value of last_page is less than the current_page value the we need a new render
      //we use setInterval to consider the network delay case with retrying process logic
      interval = setInterval(() => {
        if (this.loaded_) clearInterval(interval);
        if (this.last_page < this.current_page) {
          console.log('AAA', this.loaded_);
          this.emitter.emit({
            pageIndex: this.last_page,
            itermsPerPage: +this.iterms_per_page,
          });
          console.log(pageIndex, this.current_page, this.last_page);
        }
      }, 200);
    }
  }
}
