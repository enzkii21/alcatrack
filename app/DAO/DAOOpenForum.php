<?php

namespace App\DAO;

use App\DTO\DTOOpenForum;
use Illuminate\Support\Facades\DB;

class DAOOpenForum{


    public function insertForum($req, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->insert(
            "INSERT INTO openforum(
                ForumID,
                Title,
                Description,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            ) VALUES(
                '$id',
                '$req->Title',
                '$req->Description',
                NOW(),
                null,
                NOW(),
                '$user'
            )"
        );
        return 'success';
    }


    public function editTopic($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE openforum
            SET Title = '$req->Title',
                Description = '$req->Description',
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            where ForumID = '$req->ID'"
        );

        return 'success';
    }



    public function deleteTopic($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE openforum
            SET DeletedDate = NOW(),
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            where ForumID = '$req->ID'"
        );

        return 'success';
    }


    public function getForum(){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM openforum
            where DeletedDate is null
            "
        );

        $dto_forum = new DTOOpenForum();
        $dto_forum->setDto_forum($data);
        return $dto_forum->getDto_forum();

    }


    public function restoreTopic($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE openforum
            SET DeletedDate = NULL,
                UpdatedDate = NOW(),
                UpdatedBy = '$user'
            where ForumID = '$req->ID'"
        );

        return 'success';
    }


    public function getDeletedForum(){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM openforum
            where DeletedDate is not null"
        );

        $dto_forum = new DTOOpenForum();
        $dto_forum->setDto_forum($data);
        return $dto_forum->getDto_forum();
    }


    public function getLatestID(){
        $data = DB::connection('mysql')->select(
            "SELECT max(ForumID) as MaxID from openforum "
        );

        $dto_forum = new DTOOpenForum();
        $dto_forum->setDto_forum($data);
        return $dto_forum->getDto_forum();
    }


   
}

?>