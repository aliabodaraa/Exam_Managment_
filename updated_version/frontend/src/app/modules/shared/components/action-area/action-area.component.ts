import { Observable } from 'rxjs';
import { Component, OnInit } from '@angular/core';
import { PortalBridgeService } from '../../services/portal-bridge.service';
import { Portal } from '@angular/cdk/portal';

@Component({
  selector: 'app-action-area',
  templateUrl: './action-area.component.html',
  styleUrls: ['./action-area.component.scss'],
})
export class ActionAreaComponent implements OnInit {
  portal$: Observable<Portal<any>>;

  constructor(private portalBridge: PortalBridgeService) {}

  ngOnInit(): void {
    this.portal$ = this.portalBridge.portal$ as Observable<any>;
  }
}
