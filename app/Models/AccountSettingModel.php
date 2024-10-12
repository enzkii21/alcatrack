<?php

namespace App\Models;

use App\DAO\DAOCareerInfo;
use App\DAO\DAOAccountSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountSettingModel extends Model
{
    public function getAccount($req){
        $dao_account_setting = new DAOAccountSetting();
        if($req->method == 'GET_PROFILE'){
            return $dao_account_setting->getAccount($req);
        }else if($req->method == 'GET_PICTURE'){
            return $dao_account_setting->getPictures($req);
        }else{
            return $dao_account_setting->getCareer($req);
        }
            
    }


    public function insertJobProfile($req){
        $dao_account_setting = new DAOAccountSetting();
        $dao_careerinfo = new DAOCareerInfo();
        $MaxIDCareerInfo = $dao_careerinfo->getMaxInfoID();
        $dao_account_setting->updateCurrentJob($req);
        return $dao_account_setting->insertJobProfile($req, $MaxIDCareerInfo[0]->MaxID);

    }


    public function updateAccount($req){
        $dao_account_setting = new DAOAccountSetting();
       
        $new_data = $req->data;

        if($req->method == 'PROFILE'){

            
            $user = $req->user;
            $age = $req->age;

            if($req->title == 'New Birth Date'){
                $dao_account_setting->updateAge($age, $user);
                 $data = $dao_account_setting->updateBirthDate($new_data, $user);
                 return[
                    'result' => $data,
                    'status' => 200
                 ];
            }else if($req->title == 'New Username'){
                $data = $dao_account_setting->updateUsername($new_data, $user);
                return[
                    'result' => $data,
                    'status' => 200
                 ];
            }else if($req->title == 'New Password'){
                $data = $dao_account_setting->updatePasword($new_data, $user);
                return[
                    'result' => $data,
                    'status' => 200
                 ];
            }else if($req->title == 'New Email'){
                $data = $dao_account_setting->updateEmail($new_data, $user);
                return[
                    'result' => $data,
                    'status' => 200
                 ];
            }else if($req->title == 'New Contact Number'){
                $data = $dao_account_setting->updateContactNumber($new_data, $user);
                return[
                    'result' => $data,
                    'status' => 200
                 ];
            }
        }else if($req->method == 'PICTURE'){
            return $dao_account_setting->deleteImage($req);
        }else if($req->method == 'UPDATE_PIC'){
            $dao_account_setting->updateOldPic($req->oldPic,$req->id);
            return $dao_account_setting->updateProfilePic($req->newPic, $req->id);
        }
        else if($req->method == 'PRIVATE'){
            return $dao_account_setting->priavteAccount($req);
        }else if($req->method == 'PUBLIC'){
            return $dao_account_setting->publicAccount($req);
        }
        else{
            return $dao_account_setting->updateJobInfo($req);
        }
        
    }
}
