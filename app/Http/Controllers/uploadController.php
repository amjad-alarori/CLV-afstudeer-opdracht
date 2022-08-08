<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class uploadController extends Controller
{



  public function createForm(){
    return view('file-upload');
  }



  public function fileUpload(Request $req){
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $fileModel = new File;
        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();

            $process = new Process(['python', 'COMBINED_CSV_MAPPER.py']);
            $process->run();

            // error handling
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output_data = $process->getOutput();
            dd($output_data);


            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }
}