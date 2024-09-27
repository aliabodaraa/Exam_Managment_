import {
  ChangeDetectionStrategy,
  Component,
  EventEmitter,
  Input,
  Output,
  SimpleChanges,
  ViewEncapsulation,
  inject,
} from '@angular/core';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { map, merge } from 'rxjs';
import { UserPreferencesService } from '../../services/user-preferences.service';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { MaterialModule } from '../../modules/material.module';
import { IconsModule } from '../../modules/icons.module';
import { EmittedPaginatorValueType, Langs } from '../paginator.type';
@Component({
  selector: 'lib-paginator',
  templateUrl: './paginator.component.html',
  styleUrls: ['./paginator.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
  encapsulation:ViewEncapsulation.None,
  standalone:true,
  imports:[
    CommonModule,
    FormsModule,
    IconsModule,
    MaterialModule,
    TranslateModule,
  ]
})
export class PaginatorComponent {
  @Input('data_count') data_count: number = 1;
  @Input('current_page') current_page: number = 1;
  @Input('last_page') last_page: number;
  @Input('has_previous') has_previous: boolean;
  @Input('has_next') has_next: boolean;
  @Input('previous_page') previous_page: number;
  @Input('next_page') next_page: number;
  @Input('iterms_per_page') iterms_per_page: number;
  @Input('paginator_length') paginator_length: number;

  @Input('term') term: string = '';

  @Output('changeEmitter') emitter: EventEmitter<EmittedPaginatorValueType> =
    new EventEmitter();
  public langs$ = merge(
    inject(UserPreferencesService).getLang(),
    inject(TranslateService).onLangChange.pipe(map(({ lang }) => lang as Langs))
  );
  get dataCountArr() {
    return Array(this.paginator_length);
  }
  ngOnChanges(changes: SimpleChanges): void {
    console.log(changes);
  }
  next(pageIndex: number, from_select?: boolean) {
    if (pageIndex === this.current_page && !from_select) return;
    console.log(pageIndex, this.current_page, this.last_page);
    let obj: EmittedPaginatorValueType = {
      pageIndex,
      itermsPerPage: +this.iterms_per_page,
      term: this.term,
    };
    this.emitter.emit(obj);
  }
}
