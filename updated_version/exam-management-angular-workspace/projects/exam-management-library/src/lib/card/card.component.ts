import { CommonModule } from '@angular/common';
import { ChangeDetectionStrategy, Component } from '@angular/core';

@Component({
    selector: 'app-card',
    standalone: true,
    imports: [
        CommonModule,
    ],
    template: `<p>card works!</p>`,
    styleUrl: './card.component.css',
    changeDetection: ChangeDetectionStrategy.OnPush,
})
export class CardComponent { }
