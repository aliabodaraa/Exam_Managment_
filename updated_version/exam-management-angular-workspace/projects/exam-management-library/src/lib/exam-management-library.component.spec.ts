import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ExamManagementLibraryComponent } from './exam-management-library.component';

describe('ExamManagementLibraryComponent', () => {
  let component: ExamManagementLibraryComponent;
  let fixture: ComponentFixture<ExamManagementLibraryComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ExamManagementLibraryComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ExamManagementLibraryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
