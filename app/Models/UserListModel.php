<?php

namespace App\Models;

use App\DAO\DAOUserList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserListModel extends Model
{
    public function getUserList(){
        $dao_userlist = new DAOUserList();
        return $dao_userlist->getAllUser();
    }

    public function showProfile($req){
        $dao_userlist = new DAOUserList();
        if($req->method == 'CAREER'){
            return $dao_userlist->showCareerInfo($req);
        }else if($req->method == 'PICTURE'){
            return $dao_userlist->showPicture($req);
        }
    }
}
