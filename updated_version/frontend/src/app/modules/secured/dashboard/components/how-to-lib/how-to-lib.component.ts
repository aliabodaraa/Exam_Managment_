import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { HowToLibraryService } from 'app/modules/shared/services/how-to-library-service/how-to-library.service';

@Component({
  selector: 'app-how-to-lib',
  templateUrl: './how-to-lib.component.html',
  styleUrls: ['./how-to-lib.component.scss']
})
export class HowToLibComponent implements OnInit {

  resources
  constructor(public translate:TranslateService,
    private howToLibraryService:HowToLibraryService) { }

  ngOnInit(): void {
    this.howToLibraryService.getHowToLibraryAssets({
      pageSize:3
    }).subscribe((res)=>{
      this.resources=res.entries
    })
  }



}
