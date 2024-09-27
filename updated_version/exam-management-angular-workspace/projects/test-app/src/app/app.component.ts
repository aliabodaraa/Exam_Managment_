import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { PaginatorComponent } from "../../../exam-management-library/src/lib/table/paginator/paginator.component";
import { CardComponent } from '../../../exam-management-library/src/public-api';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, CardComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'test-app';
}
