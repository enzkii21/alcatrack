<?php

namespace App\DAO;

use App\DTO\DTOCourse;
use Illuminate\Support\Facades\DB;

class DAOCourse{

    public function getCourses(){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM courses where DeletedDate is null"
        );

        $dto_course = new DTOCourse();
        $dto_course->setDto_course($data);
        return $dto_course->getDto_course();
    }


    public function getDeletedCourses(){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM courses where DeletedDate is not null"
        );

        $dto_course = new DTOCourse();
        $dto_course->setDto_course($data);
        return $dto_course->getDto_course();
    }


    public function getLatestID(){
        $data = DB::connection('mysql')->select(
            "SELECT max(CourseID) as MaxID FROM courses "
        );

        $dto_course = new DTOCourse();
        $dto_course->setDto_course($data);
        return $dto_course->getDto_course();
    }

    public function insertCourse($req,$id){
        $id++;
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->insert(
            "INSERT INTO courses(
                CourseID,
                CourseName,
                CourseAbvr,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            )VALUES(
                $id,
                '$req->CourseName',
                '$req->CourseAbvr',
                NOW(),
                NULL,
                NOW(),
                '$user'
            )"
        );
        return 'success';
    }



    public function updateCourse($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE courses
            SET CourseName = '$req->CourseName',
                CourseAbvr = '$req->CourseAbvr',
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            WHERE CourseID = $req->CourseID"
        );

        return 'updated';    
    }

    public function deleteCourse($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE courses
            SET DeletedDate = NOW(),
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            WHERE CourseID = $req->CourseID"
        );

        return 'deleted'; 
    }

    public function restoreCourse($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE courses
            SET DeletedDate = NULL,
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            WHERE CourseID = $req->CourseID"
        );

        return 'restore'; 
    }
}
?>