<?php
namespace App\DAO;

use App\DTO\DTOComment;
use Illuminate\Support\Facades\DB;

class DAOComment{

    public function getComment($req){
        $data = DB::connection('mysql')->select(
            "SELECT 
            CommentID,
            COALESCE(
                (SELECT il.ImageName
                 FROM imagelist il
                 WHERE il.AlumniID = ac.AlumniID AND il.isProfile = 1),
                'blank.png'
            ) as ImageName,
                c.AlumniID,
                FirstName,
                MiddleName,
                LastName,
                Details,
                isEdited,
                c.CreatedDate
            FROM comments c
            INNER JOIN alumniaccount ac
            on c.AlumniID = ac.AlumniID
            where ForumID = '$req->ID'
            AND c.DeletedDate is null"
        );

        $dto_comment = new DTOComment();
        $dto_comment->setDto_comment($data);
        return $dto_comment->getDto_comment();
    }


    public function getLatestCommentID(){
        $data = DB::connection('mysql')->select(
            "SELECT max(CommentID) as MAXID from comments"
        );

        $dto_comment = new DTOComment();
        $dto_comment->setDto_comment($data);
        return $dto_comment->getDto_comment();
    }


    public function getCountCommentTopic($req){
        $data = DB::connection('mysql')->select(
            "SELECT a.count,o.* from openforum o
            LEFT JOIN
                ( SELECT ForumID, COUNT(*) as count
                FROM comments
                WHERE DeletedDate is null
                GROUP BY ForumID
                
                ) a
            on a.ForumID = o.ForumID
            where o.DeletedDate is null
            ORDER BY o.ForumID DESC"
        );

        $dto_comment = new DTOComment();
        $dto_comment->setDto_comment($data);
        return $dto_comment->getDto_comment();
    }



    public function insertComment($req,$id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        $id++;
        DB::connection('mysql')->insert(
            "INSERT INTO comments(
                CommentID,
                ForumID,
                AlumniID,
                Details,
                isEdited,
                CreatedDate,
                UpdatedDate,
                DeletedDate,
                UpdatedBy
            )VALUES(
                $id,
                '$req->ForumID',
                '$req->AlumniID',
                '$req->NewComment',
                0,
                NOW(),
                NOW(),
                NULL,
                '$user'
            )"
        );

        return 'success';
    }


    public function editComment($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE comments
            SET Details = '$req->Details',
                isEdited = 1,
                UpdatedDate = NOW(),
                UpdatedBy = ' $user'
            WHERE  CommentID = $req->CommentID"
        );

        return 'success';
    }


    public function deleteComment($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE comments
            SET DeletedDate = NOW(),
                UpdatedDate = NOW(),
                UpdatedBy = ' $user'
            WHERE  CommentID = $req->CommentID"
        );
    }

}


?>