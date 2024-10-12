<?php

namespace App\Models;

use App\DAO\DAOCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseModel extends Model
{
    public function getCourses($req){
        $dao_course = new DAOCourse();
        if($req->method == 'GET_COURSES'){
            return $dao_course->getCourses();
        }else if($req->method == 'GET_DELETED'){
            return $dao_course->getDeletedCourses();
        }
    }

    public function insertCourses($req){
        $dao_course = new DAOCourse();
        $latestID = $dao_course->getLatestID();
        return $dao_course->insertCourse($req,$latestID[0]->MaxID);
    }


    public function updateCourses($req){
        $dao_course = new DAOCourse();
        if($req->method == 'edit'){
            return $dao_course->updateCourse($req);
        }else if($req->method == 'delete'){
            return $dao_course->deleteCourse($req);
        }else if($req->method == 'restore'){
            return $dao_course->restoreCourse($req);
        }
    }
}
