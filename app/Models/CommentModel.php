<?php

namespace App\Models;

use App\DAO\DAOComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentModel extends Model
{
    public function showComment($req){
        $dao_comment = new DAOComment();
        if($req->method == 'GET_COMMENT'){
            return $dao_comment->getComment($req);
        }else if($req->method == 'COUNT_TOPICCOMMENT'){
            return $dao_comment->getCountCommentTopic($req);
        }
    }


    public function insertComment($req){
        $dao_comment = new DAOComment();
        if($req->method == 'INSERT'){
             $latestID = $dao_comment->getLatestCommentID();
            if(!$latestID){
                $startID = 1;
                return $dao_comment->insertComment($req,$startID);
            }else{
                return $dao_comment->insertComment($req,$latestID[0]->MAXID);
            }
        }else if($req->method == 'EDIT'){
            return $dao_comment->editComment($req);
        }else if($req->method == 'DELETE'){
            return $dao_comment->deleteComment($req);
        }
    }
}
