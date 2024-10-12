<?php
namespace App\DAO;

use App\DTO\DTOImageList;
use Illuminate\Support\Facades\DB;


class DAOImageList{

    public function getLatestImageID(){
        $data = DB::connection('mysql')->select(
            "SELECT max(ImageID) as MaxID FROM imagelist"
        );

        $dto_image = new DTOImageList();
        $dto_image->setDto_image($data);
        return $dto_image->getDto_image();
    }


    public function insertUploadImage($id,$imageName,$userID){

        DB::connection('mysql')->insert(
            "INSERT INTO imagelist(
                ImageID,
                AlumniID,
                ImageName,
                isProfile,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            ) VALUES(
                '$id',
                '$userID',
                '$imageName',
                1,
                CURDATE(),
                null,
                CURDATE(),
                '$userID'
            )"
        );
        return 'success';
    }


    public function getProfilePic($req){
        $data = DB::connection('mysql')->select(
            "SELECT ImageName  FROM imagelist
            WHERE DeletedDate is null 
            AND AlumniID = '$req->id'
            AND IsProfile = 1"
        );

        $dto_image = new DTOImageList();
        $dto_image->setDto_image($data);
        return $dto_image->getDto_image();
    }

    
    

    public function updateImageStatus($req){
        DB::connection('mysql')->update(
            "UPDATE imagelist
            SET isProfile = 0,
                UpdatedDate = CURDATE(),
                UpdatedBy = '$req->id'
            WHERE ImageName = '$req->data'"
        );

        return 'updated';
    }


    public function ImgValidator($ImageName,$userID){
        $data = DB::connection('mysql')->select(
            "SELECT *  FROM imagelist
            WHERE ImageName = '$ImageName'
            and AlumniID = '$userID'
            and DeletedDate is null"
        );

        $dto_image = new DTOImageList();
        $dto_image->setDto_image($data);
        return $dto_image->getDto_image();
    }

    public function updateExistImg($exist_id, $userID){
        DB::connection('mysql')->update(
            "UPDATE imagelist
            SET isProfile = 1,
                UpdatedDate = CURDATE(),
                UpdatedBy = $userID
            WHERE ImageID= '$exist_id'"
        );

        return 'success';
    }
}



?>