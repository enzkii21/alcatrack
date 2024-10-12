<?php

namespace App\DAO;

use App\DTO\DTOALumni;
use Illuminate\Support\Facades\DB;


class DAOAlumni{

    public function LoginAuth($req){
        $data = DB::connection('mysql')->select(
            "SELECT 
                COALESCE(ac.AlumniID, 'N/A') AS AlumniID,
                COALESCE(ac.FirstName, 'N/A') AS FirstName,
                COALESCE(ac.MiddleName, 'N/A') AS MiddleName,
                COALESCE(ac.LastName, 'N/A') AS LastName,
                COALESCE(ac.Suffix, 'N/A') AS Suffix,
                COALESCE(ac.Username, 'N/A') AS Username,
                COALESCE(ac.Password, 'N/A') AS Password,
                COALESCE(ac.Email, 'N/A') AS Email,
                COALESCE(ac.ContactNumber, 'N/A') AS ContactNumber,
                COALESCE(ut.UserTypeName, 'N/A') AS UserTypeName,
                COALESCE(rs.Batch, 'N/A') AS Batch,
                COALESCE(c.CourseName, 'N/A') AS CourseName,
                COALESCE(c.CourseAbvr, 'N/A') AS CourseAbvr
            FROM 
                alumniaccount ac
            LEFT JOIN 
                usertype ut ON ac.UserTypeID = ut.UserTypeId
            LEFT JOIN 
                registeredstudents rs ON rs.StudentID = ac.AlumniID
            LEFT JOIN 
                courses c on rs.CourseID = c.CourseID
            WHERE ac.Username = '$req->Username' AND ac.Password = '$req->Password'
            AND ac.DeletedDate is null;
            
        ");

        if(count($data) > 0){
            setcookie("Firstname", $data[0]->FirstName);
            setcookie("Middlename", $data[0]->MiddleName);
            setcookie("Lastname", $data[0]->LastName);
        }


        $dto_alumni = new DTOALumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }

    public function getRegisteredAccount(){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                FirstName,MiddleName,LastName,Suffix,Email,Username,Password,ContactNumber,CourseName,Batch
            FROM alumniaccount a
            INNER JOIN courses c
            on a.CourseID= c.CourseID"
        );

        $dto_alumni = new DTOAlumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }

    public function getLatestID(){
        $data =  DB::connection('mysql')->select(
            "SELECT max(AlumniID) as MaxID FROM alumniaccount"
        );

        $dto_alumni = new DTOAlumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }

    public function checkUsername($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM alumniaccount
            where Username = '$req'"
        );

        $dto_alumni = new DTOAlumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }


    public function checkAdminID($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM alumniaccount
            WHERE AlumniID = $req"
        );

        $dto_alumni = new DTOAlumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }

    public function insertAccount($req,$id){
        $FirstName = strtoupper($req['First Name']);
        $MiddleName = strtoupper($req['Middle Name']);
        $Surname = strtoupper($req['Surname']);
        $Suffix = strtoupper($req['Suffix']);
        $BirthDate = $req['BirthDate'];
        $Age = $req['Age'];
        $Username = $req['Username'];
        $Password = $req['Password'];
        $Email = $req['Email'];
        $ContactNumber = $req['Contact Number'];
        $user = $FirstName." ". $MiddleName." ".$Surname." ".$Suffix;
        DB::connection('mysql')->insert(
            "INSERT INTO alumniaccount(
                AlumniID,
                FirstName,
                MiddleName,
                LastName,
                SUffix,
                BirthDate,
                Age,
                Username,
                Password,
                Email,
                ContactNumber,
                isPrivate,
                UserTypeID,
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
                '$BirthDate',
                $Age,
                '$Username',
                '$Password',
                '$Email',
                '$ContactNumber',
                0,
                2,
                NOW(),
                NULL,
                NOW(),
                '$user'
        )");

        return 'Success';
    }


    public function validate($req){
        $FirstName = $req['First Name'];
        $MiddleName = $req['Middle Name'];
        $LastName = $req['Surname'];
        $data =  DB::connection('mysql')->select(
            "SELECT 
                FirstName,MiddleName,LastName,Suffix,Username
            FROM alumniaccount 
            WHERE (FirstName = '$FirstName'
            AND MiddleName = '$MiddleName'
            AND LastName = '$LastName')"
        
        );

        $dto_alumni = new DTOAlumni();
        $dto_alumni->setDto_alumni($data);
        return $dto_alumni->getDto_alumni();
    }
}

?>