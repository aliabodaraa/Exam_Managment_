import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HowToLibComponent } from './how-to-lib.component';

describe('HowToLibComponent', () => {
  let component: HowToLibComponent;
  let fixture: ComponentFixture<HowToLibComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HowToLibComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HowToLibComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
