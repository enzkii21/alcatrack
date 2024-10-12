<?php
namespace App\DAO;

use App\DTO\DTOPDFList;
use Illuminate\Support\Facades\DB;

class DAOPDFList{
    
    public function getPDFList(){

        $data = DB::connection('mysql')->select(
            "SELECT * FROM pdflist where DeletedDate is null"
        );

        $dto_pdflist = new DTOPDFList();
        $dto_pdflist->setDto_pdflist($data);
        return $dto_pdflist->getDto_pdflist();

    }


    public function checkExistingPDF($req){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM pdflist where PdfName = '$req->PDFName'"
        );

        $dto_pdflist = new DTOPDFList();
        $dto_pdflist->setDto_pdflist($data);
        return $dto_pdflist->getDto_pdflist();
    }



    public function getLatestPdfID(){
        $data = DB::connection('mysql')->select(
            "SELECT max(pdfID) as MaxID FROM pdflist"
        );

        $dto_pdflist = new DTOPDFList();
        $dto_pdflist->setDto_pdflist($data);
        return $dto_pdflist->getDto_pdflist();
    }

    public function insertPDF($id,$filename,$text){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->insert(
            "INSERT INTO pdflist(
                PdfID,
                PdfName,
                Description,
                CreatedDate,
                DeletedDate,
                UpdatedDate,
                UpdatedBy
            ) VALUES(
                '$id',
                '$filename',
                '$text',
                CURDATE(),
                null,
                CURDATE(),
                '$user'
            )"
        );

        return 'Success';
    }


    public function validatePDF($req){
        $data = DB::connection('mysql')->select(
            "SELECT * FROM pdflist
            WHERE  PdfName = '$req->filename'"
        );

        $dto_pdflist = new DTOPDFList();
        $dto_pdflist->setDto_pdflist($data);
        return $dto_pdflist->getDto_pdflist();
    }

    public function reuploadPDF($filename,$text){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE pdflist
            SET Description = '$text',
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            where PdfName = '$filename'"
        );

        return 'Successfully changed!';
    }

    public function updateDeletePDF($req){
        $user = $_COOKIE['Firstname']." ".$_COOKIE['Middlename']." ".$_COOKIE['Lastname'];
        DB::connection('mysql')->update(
            "UPDATE pdflist
            SET DeletedDate = CURDATE(),
                UpdatedDate = CURDATE(),
                UpdatedBy = '$user'
            where PdfID = '$req->data'"
        );

        return 'Deleted';
    }
}

?>