<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
//          Faculty::create([
//              'faculty_name' => 'Informatic Emgineering',
//              'studing_duration'=>5,
//              'location'=>'Syria'
//          ]);
//          $software_department = Department::create([
//              'dept_name' => 'Software Branch',
//              'faculty_id'=>Faculty::all()->random()->id,
//          ]);
//          $network_department = Department::create([
//             'dept_name' => 'Network Branch',
//             'faculty_id'=>Faculty::all()->random()->id,
//         ]);
//         $artifical_department = Department::create([
//             'dept_name' => 'Artifical Intelligence Branch',
//             'faculty_id'=>Faculty::all()->random()->id,
//         ]);
//         $admin = User::create([
//             'email' => 'admin@gmail.com',
//             'username' => 'Admin',
//             'password' => 'admin123',
//             'department_id' => Department::all()->random()->id,
//             'studing_year'=>3,
//         ]);
//         $teacher=User::create([
//             'email' => 'teacher@gmail.com',
//             'username' => 'Teacher',
//             'password' => 'teacher123',
//             'department_id' => Department::all()->random()->id,
//             'studing_year'=>3,
//         ]);
//         $student=User::create([
//             'email' => 'student@gmail.com',
//             'username' => 'Student',
//             'password' => 'student123',
//             'department_id' => Department::all()->random()->id,
//             'studing_year'=>3,
//         ]);
//         $courses_software_ids=[];
//         $course_software=null;
//         for ($i=1; $i <10; $i++) {
//                 $course_software1 = Course::create([
//                     'course_name' => 'Algorithm '.$i,
//                     'year' => $i % 5 + 1,
//                     //description: it has default constrant
//                     'teacher_name' => 'samerTeacher'.$i,
//                     'doctor_name' => 'mofed'.$i,
//                     'semester'=> 1
//                 ]);
//                 $course_software2= Course::create([
//                     'course_name' => 'Complex Theory '.$i+1,
//                     'year' => $i % 5 + 1,
//                     //description: it has default constrant
//                     'teacher_name' => 'samerTeacher'.$i+1,
//                     'doctor_name' => 'mofed'.$i+1,
//                     'semester'=> 2
//                 ]);
//                 array_push($courses_software_ids, $course_software1->id);
//                 array_push($courses_software_ids, $course_software2->id);
//         }
//         $admin->courses()->sync($courses_software_ids);
//         $software_department->courses()->sync($courses_software_ids);

//         $courses_artifical_ids=[];
//         $course_artifical=null;
//         for ($i=1; $i <10; $i++) {
//                 $course_artifical1 = Course::create([
//                     'course_name' => 'Artifical-Sem1 '.$i,
//                     'year' => $i % 5 + 1,
//                     //description: it has default constrant
//                     'teacher_name' => 'ahmadTeacher'.$i,
//                     'doctor_name' => 'ahmadDoc'.$i,
//                     'semester'=> 1
//                 ]);
//                 $course_artifical12 = Course::create([
//                     'course_name' => 'Artifical-Sem2 '.$i+1,
//                     'year' => $i % 5 + 1,
//                     //description: it has default constrant
//                     'teacher_name' => 'ahmadTeacher'.$i+1,
//                     'doctor_name' => 'ahmadDoc'.$i+1,
//                     'semester'=> 2
//                 ]);
//                 array_push($courses_artifical_ids, $course_artifical1->id);
//                 array_push($courses_artifical_ids, $course_artifical12->id);
//         }
//         $teacher->courses()->sync($courses_artifical_ids);
//         $artifical_department->courses()->sync($courses_artifical_ids);

//         $courses_network_ids=[];
//         for ($i=1; $i <5; $i++) {
//             $course1 = Course::create([
//                 'course_name' => 'Network-Sem1 '.$i,
//                 'year' => $i % 5 + 1,
//                 //description: it has default constrant
//                 'teacher_name' => 'ahmadTeacher'.$i,
//                 'doctor_name' => 'ahmadDoc'.$i,
//                 'semester'=> 2
//             ]);
//             $course2 = Course::create([
//                 'course_name' => 'Network-Sem2 '.$i+1,
//                 'year' => $i % 5 + 1,
//                 //description: it has default constrant
//                 'teacher_name' => 'ahmadTeacher'.$i+1,
//                 'doctor_name' => 'ahmadDoc'.$i+1,
//                 'semester'=> 2
//             ]);
//             array_push($courses_network_ids, $course1->id);
//             array_push($courses_network_ids, $course2->id);
//         }
//         $teacher->courses()->sync($courses_network_ids);
//         $network_department->courses()->sync($courses_network_ids);

//         $lectures_ids=[];
//         for ($i=1; $i < Course::count(); $i++) {
//             $lecture = Lecture::create([
//                 'lecture_name' => 'Lecture '.$i,
//                 'file_path' => 'lecture-1654189222.pdf',
//                 'publisher' => 'admin',
//                 'description' => 'description for lecture'.$i,
//                 'course_id' => Course::all()->random()->id,
//             ]);
//             array_push($lectures_ids, $lecture->id);
//         }

//         $permissions=[
//             'user-edit',
//             'user-delete',
//             'user-create',
//             'users-list',
//             'post-edit',
//             'post-delete',
//             'post-create',
//             'posts-list',
//             'role-edit',
//             'role-delete',
//             'role-create',
//             'roles-panel',
//             'permissions-panel',
//             'courses-list',
//             'lecture-delete',
//             'lecture-create',
//             'lectures-list',
//         ];
//         foreach ($permissions as $permission) {
//             Permission::create(['name' => $permission]);
//         }
// //Admin
//         $adminRole = Role::create(['name' => 'Admin']);
//         $permissionsAdmin = Permission::pluck('id','id')->all();
//         $adminRole->syncPermissions($permissionsAdmin);//syncPermissions defined in class HasPermissions
//         $admin->assignRole([$adminRole->id]);//assignRole defined in class HasRoles
// //Student
//         $studentRole = Role::create(['name' => 'Student']);
//         $permissionsStudent = Permission::where('name','like',['%list%'])->pluck('id','id');
//         $studentRole->syncPermissions($permissionsStudent);
//         $student->assignRole([$studentRole->id]);
// //Teacher
//         $teacherRole = Role::create(['name' => 'Teacher']);
//         $permissionsTeacher = Permission::where('name','like',['%list%','%ecture-creat%'])->pluck('id','id');
//         $teacherRole->syncPermissions($permissionsTeacher);
//         $teacher->assignRole([$teacherRole->id]);
    }
}
// $students= User::factory()->count(100)->create();
// Track::factory()->count(100)->create();
// Course::factory()->count(100)->create();
//  Video::factory()->count(100)->create();
//  Quiz::factory()->count(100)->create();
//  Question::factory()->count(100)->create();
//  Photo::factory()->count(100)->create();
//  foreach($students as $student){
//     $tracks_ids=[];
//     $tracks_ids[]=Track::all()->random()->id;
//     $tracks_ids[]=Track::all()->random()->id;
//     $student->tracks()->sync($tracks_ids);
//     $courses_ids=[];
//     $courses_ids[]=Course::all()->random()->id;
//     $courses_ids[]=Course::all()->random()->id;
//     $student->courses()->sync($courses_ids);
//     $quizzes_ids=[];
//     $quizzes_ids[]=Quiz::all()->random()->id;
//     $quizzes_ids[]=Quiz::all()->random()->id;
//     $student->quizzes()->sync($quizzes_ids);
//  }
