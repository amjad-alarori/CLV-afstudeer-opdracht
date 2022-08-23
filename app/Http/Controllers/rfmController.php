<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use App\Models\Rfm;
use DB;
use Spatie\Async\Pool;
use \stdClass;

class rfmController extends Controller

{
    public function index(){

        return view ("/dashboard");

    }


 


    public function api(){

        $pool = Pool::create();

        $pool[] = async(function () {
            return Rfm::all();
        })->then(function ($output) {
            $this->results=$output;
        });

        await($pool);


        return $this->results;

//        return Rfm::all();
    }

}
