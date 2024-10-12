<?php

namespace App\Models;

use App\DAO\DAOImageList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageListModel extends Model
{
    public function insertImage($req){
        $dao_image = new DAOImageList();
        $imageName =  $req->data;
        $userID = $req->id;
        $latestID = $dao_image->getLatestImageID();
        $validate = $dao_image->ImgValidator($imageName,$userID);

        
        if($validate){
            $exist_id = $validate[0]->ImageID;
            return $dao_image->updateExistImg($exist_id, $userID);
        }else{
            if(!$latestID[0]->MaxID){
                $id = 'IMG-0001';
                return $dao_image->insertUploadImage($id,$imageName,$userID);
            }else{
                $numericPart = substr($latestID[0]->MaxID, 4); // Start after 'IMG-'
    
                // Convert to integer and increment
                $incrementedNumeric = intval($numericPart) + 1;
        
                // Format the incremented ID
                $newId = sprintf('IMG-%04d', $incrementedNumeric);
        
                return $dao_image->insertUploadImage($newId ,$imageName,$userID);
            }
        }

        
    }


    public function getImage($req){
        $dao_image = new DAOImageList();
        return $dao_image->getProfilePic($req);
    }


    public function updateImage($req){
        $dao_image = new DAOImageList();
        return $dao_image->updateImageStatus($req);
    }
}
