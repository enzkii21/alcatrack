<?php
namespace App\DAO;

use App\DTO\DTOAccountSetting;
use Illuminate\Support\Facades\DB;


class DAOAccountSetting{


    public function getAccount($req){
        $data =  DB::connection('mysql')->select(
            "SELECT 
                ac.AlumniID,
                ac.FirstName,
                ac.MiddleName,
                ac.LastName,
                ac.Suffix,
                ac.BirthDate,
                ac.Age,
                ac.Username,
                ac.Password,
                ac.Email,
                ac.ContactNumber,
                COALESCE(c.CourseName, 'N/A') as CourseName,
                ac.isPrivate
            from alumniaccount ac
            LEFT JOIN 
                registeredstudents rs on rs.StudentID = ac.AlumniID
            LEFT JOIN 
                courses c on rs.CourseID = c.CourseID
            WHERE ac.AlumniID =  '$req->ID'
            AND ac.DeletedDate is null"
        );

        $dto_account_setting = new DTOAccountSetting();
        $dto_account_setting->setDto_account_setting($data);
        return $dto_account_setting->getDto_account_setting();
    }


    public function getCareer($req){
        $data =  DB::connection('mysql')->select(
            "SELECT * FROM careerinfo
            WHERE AlumniID = '$req->ID'
            ORDER by StartDate desc"
        );

        $dto_account_setting = new DTOAccountSetting();
        $dto_account_setting->setDto_account_setting($data);
        return $dto_account_setting->getDto_account_setting();
    }

    public function getPictures($req){
        $data =  DB::connection('mysql')->select(
            "SELECT AlumniID,ImageID, ImageName as img, isProfile  from imagelist
            WHERE DeletedDate is null
            AND AlumniID = '$req->userID'
            ORDER BY ImageID desc"
        );

        $dto_account_setting = new DTOAccountSetting();
        $dto_account_setting->setDto_account_setting($data);
        return $dto_account_setting->getDto_account_setting();
    }


    public function updateOldPic($oldPic,$id){
        DB::connection('mysql') ->update(
            "UPDATE imagelist
            SET isProfile = 0,
            UpdatedDate = NOW(),
            UpdatedBy = '$id'
            WHERE ImageName = '$oldPic'"
        );
    }


    public function updateProfilePic($newPic, $id){
        DB::connection('mysql') ->update(
            "UPDATE imagelist
            SET isProfile = 1,
            UpdatedDate = NOW(),
            UpdatedBy = '$id'
            WHERE ImageID = '$newPic'"
        );

        return 'success';
    }

    public function updateAge($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET Age = $data,
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID = '$id'
            "
        );
    }

    public function updateBirthDate($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET BirthDate = '$data',
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID = '$id'
            "
        );
        return 'Birth Date and Age updated!';
    }

    public function updateUsername($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET Username = '$data',
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID = '$id'
            "
        );
        return 'Username updated!';
    }

    public function updatePasword($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET Password = '$data',
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID ='$id'
            "
        );
        return 'Password updated!';
    }

    public function updateEmail($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET Email = '$data',
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID = '$id'
            "
        );
        return 'Email updated!';
    }

    public function updateContactNumber($data, $id){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET ContactNumber = '$data',
            UpdatedDate = CURDATE(),
            UpdatedBy = '$user'
            where AlumniID = '$id'
            "
        );
        return 'Contact Number updated!';
    }


    public function updateJobInfo($req){
        DB::connection('mysql')->update(
            "UPDATE careerinfo
            SET JobTitle = '$req->JobTitle',
            CompanyName = '$req->CompanyName',
            CompanyAddress = '$req->CompanyAddress',
            StartDate = '$req->StartDate',
            EndDate = '$req->EndDate',
            LengthOfService = '$req->LOS',
            isRelated = $req->IsRelated,
            UpdatedDate = CURDATE(),
            UpdatedBy = $req->userID
            where AlumniID = '$req->userID'
            and InfoID = $req->InfoID
            "
        );

        return 'updated';
    }


    public function deleteImage($req){
        DB::connection('mysql')->update(
            "UPDATE imagelist
            SET DeletedDate = CURDATE(),
            UpdatedDate = CURDATE(),
            UpdatedBy = $req->userID
            where ImageID = '$req->ImgID'
            "
        );

        return 'deleted';
    }


    public function updateCurrentJob($req){
        DB::connection('mysql')->update(
            "UPDATE careerinfo
            SET isCurrentJob = 0,
            UpdatedDate = CURDATE(),
            UpdatedBy = $req->userID
            where AlumniID =  '$req->userID'
            "
        );
    }




    public function insertJobProfile($req , $MaxIDCareerInfo){
        $MaxIDCareerInfo++;
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        $jobTitle = strtoupper($req->JobTitle);
        $companyName = strtoupper($req->CompanyName);
        $companyAddress = strtoupper($req->CompanyAddress);
        // $los = strtoupper($req->LOS);
        $isRelated = $req->isRelated;

        DB::connection('mysql')->insert(
            "INSERT INTO careerinfo(
                InfoID,
                AlumniID,
                JobTitle,
                CompanyName,
                CompanyAddress,
                StartDate,
                EndDate,
                LengthOfService,
                IsRelated,
                isCurrentJob,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            )VALUES(
                $MaxIDCareerInfo,
                $req->userID,
                '$jobTitle',
                '$companyName',
                '$companyAddress',
                '$req->StartDate',
                'N/A',
                'N/A',
                $isRelated,
                1,
                CURDATE(),
                NULL,
                CURDATE(),
                $req->userID
        )");

        return 'success';
    }


    public function priavteAccount($req){
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET isPrivate = 1,
            UpdatedDate = NOW(),
            UpdatedBy = $req->AlumniID
            where AlumniID =  '$req->AlumniID'
            "
        );
        return 'success';
    }


    public function publicAccount($req){
        DB::connection('mysql')->update(
            "UPDATE alumniaccount
            SET isPrivate = 0,
            UpdatedDate = NOW(),
            UpdatedBy = $req->AlumniID
            where AlumniID =  '$req->AlumniID'
            "
        );
        return 'success';
    }
}

?>