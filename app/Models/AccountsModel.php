<?php

namespace App\Models;

use App\DAO\DAOAlumni;
use App\DAO\DAOAccounts;
use App\DAO\DAOCareerInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountsModel extends Model
{
    public function getAccounts($req){
        $dao_accounts = new DAOAccounts();
        if($req->method == 'GET_ACCOUNT'){
            return $dao_accounts->getAccounts();
        }else if($req->method == 'GET_DELETEDACCOUNT'){
            return $dao_accounts->getDeletedAccounts();
        }
    }

    public function showGraphAccounts(){
        $dao_accounts = new DAOAccounts();
        return $dao_accounts->showGraphAccounts();
    }


    public function updateAccounts($req){
        $dao_accounts = new DAOAccounts();
        if($req->method == 'delete'){
            return $dao_accounts->updateDeleteAccounts($req);
        }else if($req->method == 'restore'){
            return $dao_accounts->updateRestoreAccounts($req);
        }
    }


    public function insertAccounts($req){
        $dao_accounts = new DAOAccounts();
        $dao_careerinfo = new DAOCareerInfo();
        $id = $dao_accounts->getLatestID();
        $MaxIDCareerInfo = $dao_careerinfo->getLatestID();
        $validate = $dao_accounts->checkUsername($req->Username);

        if($validate){
            return 'Username already exist';
        }else{
             $dao_careerinfo->insertAdminCareerInfo($MaxIDCareerInfo[0]->MaxID,$id[0]->AlumniID);
            return $dao_accounts->insertAdminAccounts($req,$id[0]->AlumniID);
            
        }
        
    }
}
