<?php

namespace App\Models;

use App\DAO\DAOAlumni;
use App\DAO\DAORegisteredStudents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegisteredStudentsModel extends Model
{
    public function getStudentAccount($req){
        $dao_students = new DAORegisteredStudents();
        if($req->method == 'GET_STUDENTS' ){
            return $dao_students->getStudentAccount();
        }else if($req->method == 'GET_DELETED'){
            return $dao_students->getDeletedStudentAccount();
        }else if($req->method == 'GET_GRAPH'){
            return $dao_students->getStudentAccountGraph();
        }
    }


    public function insertStudentAccount($req){
        $dao_students = new DAORegisteredStudents();
        $dao_alumni = new DAOAlumni();
        $checkExist = $dao_students->checkIDNo($req->studentID);
        $checkAdminID = $dao_alumni->checkAdminID($req->studentID);
        if(!$checkAdminID){
            if(!$checkExist){
                return $dao_students->insertStudentAccount($req);   
            }else{
                return 'exist';
            }
        }else{
            return 'account exist';
        }
    }


    public function updateStudentAccount($req){
        $dao_students = new DAORegisteredStudents();
        if($req->method == 'edit'){
            return $dao_students->updateStudentAccount($req);
        }else if($req->method == 'restore'){
            return $dao_students->updateRestoreStudentAccount($req);
        }else{
            return $dao_students->updateDeleteStudentAccount($req);
        }
        
    }


    public function getPerBatch($req){
        $dao_students = new DAORegisteredStudents();
        if($req->process == 'getPerBatch'){
            return $dao_students->getPerBatch($req);
        }
    }
}
