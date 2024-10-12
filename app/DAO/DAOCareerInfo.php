<?php

namespace App\DAO;

use App\DTO\DTOCareerInfo;
use Illuminate\Support\Facades\DB;


class DAOCareerInfo{


    public function getLatestID(){
        $data =  DB::connection('mysql')->select(
            "SELECT max(InfoID) as MaxID FROM careerinfo"
        );

        $dto_careerinfo = new DTOCareerInfo();
        $dto_careerinfo->setDto_careerinfo($data);
        return $dto_careerinfo->getDto_careerinfo();
    }
    

    public function getMaxInfoID(){
        $data =  DB::connection('mysql')->select(
            "SELECT max(InfoID) as MaxID FROM careerinfo"
        );

        $dto_careerinfo = new DTOCareerInfo();
        $dto_careerinfo->setDto_careerinfo($data);
        return $dto_careerinfo->getDto_careerinfo();
    }

    public function insertCareerInfo($req,$id,$MaxIDCareerInfo){
        $MaxIDCareerInfo++;
        $CompanyName = strtoupper($req['Company Name']);
        $CompanyAdd = strtoupper($req['Company Address']);
        $JobTitle = strtoupper($req['Job Title']);
        $startDate = $req['StartDate'];
        // $endDate = $req['EndDate'];
        // $lengthOfService = strtoupper($req['LOS']);
        $isRelated = $req['isRelated'] == 'yes' ? 1 : 2;
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
                '$id',
                '$JobTitle',
                '$CompanyName',
                '$CompanyAdd',
                '$startDate',
                'N/A',
                'N/A',
                $isRelated,
                1,
                CURDATE(),
                NULL,
                CURDATE(),
                $id
        )");

        return 'success';
    }


    public function insertAdminCareerInfo($infoID,$id){
        $infoID++;
        $id++;
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
                $infoID,
                '$id',
                'N/A',
                'N/A',
                'N/A',
                'N/A',
                'N/A',
                'N/A',
                0,
                0,
                CURDATE(),
                NULL,
                CURDATE(),
                $id
        )");
    }


}

?>