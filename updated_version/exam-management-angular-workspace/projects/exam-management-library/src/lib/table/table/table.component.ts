import {
  ChangeDetectionStrategy,
  Component,
  ElementRef,
  EventEmitter,
  Input,
  Output,
  ViewChild,
  ViewEncapsulation,
} from '@angular/core';
import { TranslateModule} from '@ngx-translate/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { MaterialModule } from '../../modules/material.module';
import { IconsModule } from '../../modules/icons.module';
import { Subscription, debounceTime, distinctUntilChanged, fromEvent, map } from 'rxjs';
import { IncomingDataTableType } from './table.type';
import { PaginatorComponent } from '../paginator/paginator.component';
import { EmittedPaginatorValueType } from '../paginator.type';
@Component({
  selector: 'lib-table',
  templateUrl: './table.component.html',
  styleUrls: ['./table.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
  encapsulation:ViewEncapsulation.None,
  standalone:true,
  imports:[
    CommonModule,
    FormsModule,
    IconsModule,
    MaterialModule,
    TranslateModule,
    PaginatorComponent
  ]
})
export class TableComponent {
  @Input() data:IncomingDataTableType;
  @Input() withPaginator:boolean=true;
  @Input() requiredProps:{[x:string]:{accessor_api:string,order:number}};
  @ViewChild('term', { static: true })
  searchTermElement!: ElementRef<HTMLInputElement>;
  searchEventSub: Subscription;
  @Output() searchTermEvent=new EventEmitter<string>();
  
  @Output('changePaginator') paginatorEmitter: EventEmitter<EmittedPaginatorValueType> =
    new EventEmitter();
    ngOnInit(): void {
      console.log("requiredProps",this.requiredProps)
      this.searchEventSub = fromEvent<Event>(
        this.searchTermElement.nativeElement,
        'input'
      )
        .pipe(
          debounceTime(1000),
          map((x) => (x?.target as HTMLInputElement).value),
          distinctUntilChanged()
        )
        .subscribe((term_value: string) => {
          this.paginatorEmitter.emit({
            pageIndex: this.data.current_page,
            itermsPerPage: this.data.iterms_per_page,
            term: term_value,
            searchMode: true,
          })
        });
    }
    ngOnDestroy() {
      this.searchEventSub.unsubscribe();
    }
    //  comparatorFn = (
    //   a: any,
    //   b: any
    // ): number => a.value.order - b.value.order;
}
