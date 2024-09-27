import { CdkPortal } from '@angular/cdk/portal';
import { Component, OnInit, ViewChild, OnDestroy } from '@angular/core';
import { PortalBridgeService } from '../../../shared/services/portal-bridge.service';

export interface Room {
  item: string;
  address: string;
  country: string;
}

const ROOMS_DATA: Room[] = [
  { item: 'iPhone 12', address: 'Rammstein Straße 4', country: 'Germany' },
  { item: 'MacBook Pro', address: 'Oida Gasse 5', country: 'Austria' },
];

@Component({
  selector: 'app-rooms-page',
  templateUrl: './rooms-page.component.html',
  styleUrls: ['./rooms-page.component.scss'],
})
export class RoomsPageComponent implements OnInit, OnDestroy {
  @ViewChild(CdkPortal, { static: true })
  portalContent: CdkPortal;

  displayedColumns: string[] = ['item', 'address', 'country'];
  dataSource = ROOMS_DATA;

  constructor(private portalBridge: PortalBridgeService) {}

  ngOnInit(): void {
    this.portalBridge.setPortal(this.portalContent);
  }

  ngOnDestroy(): void {
    //Called once, before the instance is destroyed.
    //Add 'implements OnDestroy' to the class.
    // this.portalContent?.detach();
  }
}
