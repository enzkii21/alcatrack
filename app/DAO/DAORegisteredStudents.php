<?php

namespace App\DAO;

use App\DTO\DTORegisteredStudents;
use Illuminate\Support\Facades\DB;


class DAORegisteredStudents{

    public function getStudentAccount(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                 StudentID as oldStudentID,StudentID,FirstName,MiddleName,LastName,Suffix,CourseName,c.CourseID,Batch, rs.DeletedDate
            FROM registeredstudents rs
            INNER JOIN courses c
            on rs.CourseID= c.CourseID
            WHERE rs.DeletedDate is null
            ORDER BY rs.CreatedDate"
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }

    public function getStudentAccountGraph(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                 StudentID as oldStudentID,
                 StudentID,
                 FirstName,
                 MiddleName,
                 LastName,
                 Suffix,
                 CourseName,
                 c.CourseID,
                 c.CourseAbvr,
                 Batch, 
                 rs.DeletedDate
            FROM registeredstudents rs
            INNER JOIN courses c
            on rs.CourseID= c.CourseID
            WHERE rs.DeletedDate is null
            ORDER BY CourseID"
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }


    public function getDeletedStudentAccount(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                 StudentID,FirstName,MiddleName,LastName,Suffix,CourseName,c.CourseID,Batch, rs.DeletedDate
            FROM registeredstudents rs
            INNER JOIN courses c
            on rs.CourseID= c.CourseID
            WHERE rs.DeletedDate is not null
            ORDER BY rs.CreatedDate"
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }


    public function checkifExist($req){
        $FirstName =  $req['First Name'];
        $MiddleName =  $req['Middle Name'];
        $Surname =  $req['Surname'];
        $Suffix =  $req['Suffix'];

        $data =  DB::connection('mysql')->select(
            "SELECT 
                *
            FROM registeredstudents rs
            INNER JOIN courses c
            on rs.CourseID= c.CourseID
            where (rs.FirstName = '$FirstName'
            and rs.MiddleName = '$MiddleName'
            and rs.Lastname = '$Surname')
            and rs.Suffix = '$Suffix'
            and rs.DeletedDate is null"
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }


    public function checkIDNo($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM registeredstudents
            WHERE StudentID = $req"
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }

    public function getPerBatch($req){
        $data =  DB::connection('mysql')->select(
            ""
        );

        $dto_students = new DTORegisteredStudents();
        $dto_students->setDto_students($data);
        return $dto_students->getDto_students();
    }


    public function insertStudentAccount($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        $firstName = strtoupper($req->firstName);
        $middleName = strtoupper($req->middleName);
        $lastName = strtoupper($req->lastName);
        $suffix = strtoupper( $req->suffix);
        DB::connection('mysql')->insert(
            "INSERT INTO registeredstudents(
                StudentID,
                FirstName,
                MiddleName,
                LastName,
                SUffix,
                CourseID,
                Batch,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            )VALUES(
                $req->studentID,
                '$firstName',
                '$middleName',
                '$lastName',
                '$suffix',
                $req->selectedCourse,
                $req->batch,
                CURDATE(),
                NULL,
                CURDATE(),
                '$user'
        )");

        return 'success';
    }


    public function updateStudentAccount($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        $firstName = strtoupper($req->firstName);
        $middleName = strtoupper($req->middleName);
        $lastName = strtoupper($req->lastName);
        $suffix = strtoupper( $req->suffix);
        DB::connection('mysql')->update(
            "UPDATE registeredstudents
            SET StudentID =  $req->studentID,
                FirstName = '$firstName',
                MiddleName = '$middleName',
                LastName = '$lastName',
                Suffix = '$suffix',
                CourseID = $req->selectedCourse,
                Batch = $req->batch,
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            where StudentID =  $req->oldStudentID"
        );

        return 'updated';
    }

    public function updateDeleteStudentAccount($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE registeredstudents
            SET DeletedDate = CURDATE(),
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            WHERE StudentID =  $req->studentID"
        );

        return 'deleted';
    }


    public function updateRestoreStudentAccount($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE registeredstudents
            SET DeletedDate = null,
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            WHERE StudentID =  $req->studentID"
        );

        return 'restored';
    }
}

?>