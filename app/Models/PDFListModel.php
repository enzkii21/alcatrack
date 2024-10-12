<?php

namespace App\Models;

use App\DAO\DAOPDFList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PDFListModel extends Model
{
    public function insertPDF($req){
        $dao_pdflist = new DAOPDFList();
        $latestID = $dao_pdflist->getLatestPdfID();
        $validate = $dao_pdflist->validatePDF($req);
        if($validate){
            $reupload_text = $req->text;
            $reupload_filename =  $req->filename;
            return  $dao_pdflist->reuploadPDF($reupload_filename,$reupload_text);
        }else{
            if(!$latestID[0]->MaxID ){
                $id = 'PDF-0001';
                $filename = $req->filename;
                $text = $req->text;
                return  $dao_pdflist->insertPDF( $id,$filename,$text);
            }else{
                $numericPart = substr($latestID[0]->MaxID, 4); // Start after 'PDF-'
            
                // Convert to integer and increment
                $incrementedNumeric = intval($numericPart) + 1;
                
                // Format the incremented ID
                $newId = sprintf('PDF-%04d', $incrementedNumeric);
                
                $filename = $req->filename;
                $text = $req->text;
                return $dao_pdflist->insertPDF($newId, $filename, $text);
            }
        }
        
        
    }


    public function getPDFList($req){
        $dao_pdflist = new DAOPDFList();
        if($req->REQUEST == 'WITH_PARAM'){
            return $dao_pdflist->checkExistingPDF($req);
        }else{
            return $dao_pdflist->getPDFList();
        }

    }


    public function updateDeletePDF($req){
        $dao_pdflist = new DAOPDFList();
        return $dao_pdflist->updateDeletePDF($req);
    }
}
