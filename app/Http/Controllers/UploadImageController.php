<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    public function uploadProfile(Request $req){
        // $userFolder = $req->user;
        // $file = $req->file('file');
        // $originalFilename = $file->getClientOriginalName();
        // $filePath = $file->storeAs('/UploadImage',$originalFilename,'public');
        // return 'Success';

        
        // ini_set('upload_max_size', '64M');
        $userFolder = $req->user;
        
        // Ensure the directory exists
        if (!Storage::disk('local')->exists("UploadImage/{$userFolder}")) {
            // Storage::disk('local')->makeDirectory("UploadImage/{$userFolder}");
            Storage::disk('local')->getAdapter()->getPathPrefix() . "UploadImage/{$userFolder}";
        }
             $result = Storage::disk('local')->exists("UploadImage/{$userFolder}");
        
        if($result){
            $file = $req->file('file');
            $originalFilename = $file->getClientOriginalName();
          
            $filePath = $file->storeAs("UploadImage/{$userFolder}", $originalFilename, 'public');
            
            return 'Success';
        }
        // $file = $req->file('file');
        // $originalFilename = $file->getClientOriginalName();
        // $filePath = $file->storeAs("public/storage/UploadImage/{$userFolder}", $originalFilename, 'public');
        
        // return 'Success';
    }
}
