<?php
namespace App\DAO;

use App\DTO\DTOUserList;
use Illuminate\Support\Facades\DB;


class DAOUserList{


    public function getAllUser(){
        $data =  DB::connection('mysql')->select(
            "WITH LatestJobTitles AS (
                SELECT 
                    ci.AlumniID,
                    MAX(ci.JobTitle) AS LatestJobTitle
                FROM 
                    careerinfo ci
                WHERE
    				isCurrentJob = 1
                GROUP BY 
                    ci.AlumniID
            )
            SELECT 
                a.*,
                c.CourseName,
                rs.CourseID,
                c.CourseAbvr,
                ljt.LatestJobTitle,
                rs.Batch,
                COALESCE(
                    (SELECT il.ImageName
                    FROM imagelist il
                    WHERE il.AlumniID = a.AlumniID AND il.isProfile = 1),
                    'blank.png'
                ) as ImageName
            FROM 
                alumniaccount a
            inner JOIN 
            	registeredstudents rs on rs.StudentID = a.AlumniID
             LEFT JOIN 
                courses c ON rs.CourseID = c.CourseID
            INNER JOIN 
       
                LatestJobTitles ljt ON ljt.AlumniID = a.AlumniID
            WHERE 
                a.FirstName != 'ADMIN'
                AND a.MiddleName != 'ADMIN'
                AND a.LastName != 'ADMIN'
                AND A.DeletedDate is null
                AND a.isPrivate != 1"
        );

        $dto_userlist = new DTOUserList();
        $dto_userlist->setDto_userlist($data);
        return $dto_userlist->getDto_userlist();
    }


    public function showCareerInfo($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM careerinfo
             WHERE AlumniID = '$req->userID'"
           
        );

        $dto_userlist = new DTOUserList();
        $dto_userlist->setDto_userlist($data);
        return $dto_userlist->getDto_userlist();
    }

    public function showPicture($req){
        $data =  DB::connection('mysql')->select(
            "SELECT AlumniID,ImageID, ImageName as img from imagelist
            WHERE DeletedDate is null
            AND AlumniID = '$req->userID'
            ORDER BY ImageID desc"
           
        );

        $dto_userlist = new DTOUserList();
        $dto_userlist->setDto_userlist($data);
        return $dto_userlist->getDto_userlist();
    }
}


?>