import { TestBed } from '@angular/core/testing';

import { ExamManagementLibraryService } from './exam-management-library.service';

describe('ExamManagementLibraryService', () => {
  let service: ExamManagementLibraryService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ExamManagementLibraryService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
