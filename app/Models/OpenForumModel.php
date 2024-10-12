<?php

namespace App\Models;

use App\DAO\DAOOpenForum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpenForumModel extends Model
{
    public function insertForum($req){
        $dao_openforum = new DAOOpenForum();
        $latestID = $dao_openforum->getLatestID();
        if(!$latestID[0]->MaxID ){
            $id = 'FID-0001';
            return  $dao_openforum->insertForum($req, $id);
        }else{
            $numericPart = substr($latestID[0]->MaxID, 4); // Start after 'PDF-'
        
            // Convert to integer and increment
            $incrementedNumeric = intval($numericPart) + 1;
            
            // Format the incremented ID
            $newId = sprintf('FID-%04d', $incrementedNumeric);
            
            
            return $dao_openforum->insertForum($req, $newId);
        }
    }


    public function updateForum($req){
        $dao_openforum = new DAOOpenForum();
        if($req->method == 'EDIT'){
            return $dao_openforum->editTopic($req);
        }else if($req->method == 'DELETE'){
            return $dao_openforum->deleteTopic($req);
        }else if($req->method == 'RESTORE'){
            return $dao_openforum->restoreTopic($req);
        }
    }


    public function getForum($req){
        $dao_openforum = new DAOOpenForum();
       
        if($req->method == 'GET'){
            return $dao_openforum->getForum();
        }else if($req->method == 'GET_DELETE'){
            return $dao_openforum->getDeletedForum();
        }
    }
}
