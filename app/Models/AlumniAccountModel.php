<?php

namespace App\Models;


use App\DAO\DAOAlumni;
use App\DAO\DAOCareerInfo;
use App\DAO\DAORegisteredStudents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlumniAccountModel extends Model
{
    public function getAlumniAccount($req){
        $dao_alumni = new DAOAlumni();
        if($req->Process =='login'){
            return $dao_alumni->LoginAuth($req);
        }else{
            return $dao_alumni->getRegisteredAccount();
        }
    }


    public function RegisterAccount($req){
        $dao_alumni = new DAOAlumni();
        $dao_student = new DAORegisteredStudents();
        $dao_careerinfo = new DAOCareerInfo();
        $validateStudent = $dao_student->checkifExist($req->PerInfo);
        $validateAccount = $dao_alumni->validate($req->PerInfo);
        $MaxIDCareerInfo = $dao_careerinfo->getLatestID();
        if($validateAccount){
            return 'Account already exist!';
        }else if($validateStudent){
            $checkuser = $dao_alumni->checkUsername($req->PerInfo['Username']);
            if($checkuser){
                return 'Username already exist!';
            }else{
                $id = $validateStudent[0]->StudentID;
                $dao_careerinfo->insertCareerInfo($req->JobInfo,$id, $MaxIDCareerInfo[0]->MaxID);
                return $dao_alumni->insertAccount($req->PerInfo,$id);
            }
        }else{
           return 'Register first';
        }
    }
   
}
