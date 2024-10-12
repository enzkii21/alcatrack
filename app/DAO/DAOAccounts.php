<?php

namespace App\DAO;

use App\DTO\DTOAccounts;
use Illuminate\Support\Facades\DB;


class DAOAccounts{

    public function getAccounts(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                a.*, c.CourseName,c.CourseID,c.CourseAbvr, rs.Batch
            FROM alumniaccount a
            LEFT JOIN registeredstudents rs
            on rs.StudentID = a.AlumniID
            LEFT JOIN courses c
            on c.CourseID = rs.CourseID
            WHERE a.FirstName != 'ADMIN'
            and a.MiddleName != 'ADMIN'
            and a.LastName != 'ADMIN'
            AND a.DeletedDate is null
            ORDER BY a.AlumniID"
        );

        $dto_accounts = new DTOAccounts();
        $dto_accounts->setDto_accounts($data);
        return $dto_accounts->getDto_accounts();
    }

    public function getDeletedAccounts(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                a.*, c.CourseName,c.CourseID,c.CourseAbvr, rs.Batch
            FROM alumniaccount a
            LEFT JOIN registeredstudents rs
            on rs.StudentID = a.AlumniID
            LEFT JOIN courses c
            on c.CourseID = rs.CourseID
            WHERE a.FirstName != 'ADMIN'
            and a.MiddleName != 'ADMIN'
            and a.LastName != 'ADMIN'
            AND a.DeletedDate is not null
            ORDER BY a.AlumniID"
        );

        $dto_accounts = new DTOAccounts();
        $dto_accounts->setDto_accounts($data);
        return $dto_accounts->getDto_accounts();
    }


    public function showGraphAccounts(){
        $data =  DB::connection('mysql')->select(
            "WITH LatestCareerInfo AS (
                SELECT 
                    ci.AlumniID,
                    MAX(ci.JobTitle) AS LatestJobTitle,
                    MAX(ci.CompanyName) AS LatestCompanyName,
                    MAX(ci.CompanyAddress) AS LatestCompanyAddress,
                    MAX(ci.LengthOfService) AS LatestLengthOfService,
                    ci.IsRelated
                FROM 
                    careerinfo ci
                WHERE ci.Isrelated = 1
    			AND ci.isCurrentJob = 1
                GROUP BY 
                    ci.AlumniID, ci.IsRelated
            )
            SELECT 
                ac.*,rs.*,
                lci.LatestJobTitle,
                lci.LatestCompanyName,
                lci.LatestCompanyAddress,
                lci.LatestLengthOfService,
                lci.IsRelated,
                c.CourseAbvr
            FROM 
                alumniaccount ac
            RIGHT JOIN 
                LatestCareerInfo lci ON lci.AlumniID = ac.AlumniID
            RIGHT join 
            	registeredstudents rs on ac.AlumniID = rs.StudentID
            RIGHT JOIN 
            	courses c on c.CourseID = rs.CourseID
            	
            WHERE 
                ac.UserTypeID != 1
                AND ac.DeletedDate IS NULL"
        );

        $dto_accounts = new DTOAccounts();
        $dto_accounts->setDto_accounts($data);
        return $dto_accounts->getDto_accounts();
    }


    public function updateDeleteAccounts($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET DeletedDate = CURDATE(),
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            WHERE AlumniID =  '$req->AlumniID'"
        );

        return 'deleted';
    }


    public function updateRestoreAccounts($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET DeletedDate = null,
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            WHERE AlumniID =  '$req->AlumniID'"
        );

        return 'restored';
    
    }

    public function checkUsername($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM alumniaccount
            where Username = '$req'"
        );

        $dto_accounts = new DTOAccounts();
        $dto_accounts->setDto_accounts($data);
        return $dto_accounts->getDto_accounts();
    }

    public function getLatestID(){
        $data =  DB::connection('mysql')->select(
            "SELECT max(AlumniID) as AlumniID FROM alumniaccount
            where UserTypeID = 1"
        );

        $dto_accounts = new DTOAccounts();
        $dto_accounts->setDto_accounts($data);
        return $dto_accounts->getDto_accounts();
    }

    public function insertAdminAccounts($req,$id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        $Suffix = strtoupper($req->Suffix);
        $Surname = strtoupper($req->Surname); 
        $MiddleName= strtoupper($req->MiddleName);
        $FirstName= strtoupper($req->FirstName);
        $Username= $req->Username;
        $Password= $req->Password;
        $id++;
        DB::connection('mysql')->insert(
            "INSERT INTO alumniaccount(
                AlumniID,
                FirstName,
                MiddleName,
                LastName,
                Suffix,
                BirthDate,
                Age,
                Username,
                Password,
                Email,
                ContactNumber,
                UserTypeID,
                isPrivate,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            )VALUES(
                '$id',
                '$FirstName',
                '$MiddleName',
                '$Surname ',
                '$Suffix',
                '1900-01-01',
                0,
                '$Username',
                '$Password',
                'N/A',
                'N/A',
                1,
                0,
                NOW(),
                NULL,
                NOW(),
                '$user'
        )");

        return 'Success';
    }



}


?>