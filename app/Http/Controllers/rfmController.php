<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Rfm;
use DB;
class rfmController extends Controller

{

    public function index(){

       
        $data = Rfm::all('RFM');        
        return view ("/dashboard", ["data" => json_encode($data[0]['RFM'])]);
    }
   



}
