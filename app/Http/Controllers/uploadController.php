<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;



class uploadController extends Controller
{



  public function createForm(){
    return view('file-upload');
  }



  public function fileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:20048'
        ]);
       
        $fileModel = new File;
        if($req->file()) {
            $fileName = $req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->name = $req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();

           
    
            $process = new Process(['python', '../storage/app/public/COMBINED_CSV_MAPPER.py', $fileName]);
            $process->run();

            // error handling
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            $output_data = $process->getOutput();
            // Delete dataset from storage
            unlink(storage_path('app/public/uploads/'.$fileName));
            
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }
}