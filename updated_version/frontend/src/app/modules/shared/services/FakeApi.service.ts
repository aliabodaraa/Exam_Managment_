import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
const FAKE_USER_DATA={
  "data": [
      {
          "id": 1,
          "username": "admin",
          "email": "admin@gmail.com",
          "password": "$2y$10$f/hz8pJda.NkJJM5gLYWceda/.EQHaedHYKnONP6oJUCH/vcWxtpW",
          "number_of_observation": 20,
          "role": "موظف إداري",
          "temporary_role": "رئيس شعبة الامتحانات",
          "city": "اللاذفية",
          "is_active": true,
          "property": "",
          "facultyId": 1,
          "departmentId": null,
          "faculty": {
              "id": 1,
              "name": "كلية الهندسة المعلوماتية",
              "location": null,
              "description": null
          },
          "department": null
      },
      {
          "id": 2,
          "username": "د. غيث بلال",
          "email": "11@gmail.com",
          "password": "$2y$10$ApcDEBdwLy1qRUGZLpTWau6Ah.SpnRgaAPu9ZHVOIWPM1MJM130QK",
          "number_of_observation": 12,
          "role": "دكتور",
          "temporary_role": null,
          "city": "بانياس",
          "is_active": true,
          "property": "عضو هيئة تدريسية",
          "facultyId": 1,
          "departmentId": 1,
          "faculty": {
              "id": 1,
              "name": "كلية الهندسة المعلوماتية",
              "location": null,
              "description": null
          },
          "department": {
              "id": 1,
              "name": "قسم البرمحيات ونظم المعلومات",
              "facultyId": 1
          }
      },
      {
          "id": 3,
          "username": "د . بسيم برهوم",
          "email": "22@gmail.com",
          "password": "$2y$10$duxL6PaoOENOoq7wt9iT7upbBrS2oy6IoWRByiWP9LvsHWq0g477i",
          "number_of_observation": 12,
          "role": "دكتور",
          "temporary_role": "رئيس قسم",
          "city": "اللاذفية",
          "is_active": true,
          "property": "عضو هيئة تدريسية",
          "facultyId": 1,
          "departmentId": 1,
          "faculty": {
              "id": 1,
              "name": "كلية الهندسة المعلوماتية",
              "location": null,
              "description": null
          },
          "department": {
              "id": 1,
              "name": "قسم البرمحيات ونظم المعلومات",
              "facultyId": 1
          }
      },
      {
          "id": 4,
          "username": "د. محمد صبيح",
          "email": "33@gmail.com",
          "password": "$2y$10$lZUyVNbjE60JDFQuP0nX8.0edUc5JOZFyqyJ6y2xK8BJrKoMGUcYy",
          "number_of_observation": 12,
          "role": "دكتور",
          "temporary_role": null,
          "city": "اللاذفية",
          "is_active": false,
          "property": "عضو هيئة تدريسية",
          "facultyId": 1,
          "departmentId": 2,
          "faculty": {
              "id": 1,
              "name": "كلية الهندسة المعلوماتية",
              "location": null,
              "description": null
          },
          "department": {
              "id": 2,
              "name": "قسم الشبكات والنظم الحاسوبية",
              "facultyId": 1
          }
      },
      {
          "id": 5,
          "username": "د. علي إسماعيل",
          "email": "44@gmail.com",
          "password": "$2y$10$yKeaDqgRAvRqsZ0EFmXkouPzMc1Q4tnrRb8MolHrjb4O9fe5j9dXa",
          "number_of_observation": 12,
          "role": "دكتور",
          "temporary_role": "رئيس قسم",
          "city": "اللاذفية",
          "is_active": true,
          "property": "عضو هيئة تدريسية",
          "facultyId": 1,
          "departmentId": 1,
          "faculty": {
              "id": 1,
              "name": "كلية الهندسة المعلوماتية",
              "location": null,
              "description": null
          },
          "department": {
              "id": 1,
              "name": "قسم البرمحيات ونظم المعلومات",
              "facultyId": 1
          }
      }
  ],
  "data_count": 229,
  "has_next": true,
  "has_previous": false,
  "next_page": 2,
  "previous_page": 0,
  "last_page": 46,
  "current_page": 1,
  "iterms_per_page": 5,
  "paginator_length": 7
}
@Injectable({
  providedIn: 'root'
})
export class FakeApiService {

  constructor() { }
  getFakeUserData():Observable<any>{
    return of(FAKE_USER_DATA)
  }

}
