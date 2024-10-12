<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadPDF(Request $req){
        $file = $req->file('file');
        $originalFilename = $file->getClientOriginalName();
        $filePath = $file->storeAs('/UploadPDF',$originalFilename,'public');
        return 'Success';

    }



}
