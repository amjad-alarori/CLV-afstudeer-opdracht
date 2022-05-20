<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Rfm;
use DB;
use Spatie\Async\Pool;

class rfmController extends Controller

{

    public function index(){

        $pool = Pool::create();

        $pool[] = async(function () {
            return Rfm::all();
        })->then(function ($output) {
            $this->results=$output;
        });

        await($pool);

        return view('/dashboard',['results' => $this->results]);
//        return view ("/dashboard", ["data" => Rfm::all()]);
    }


    public function api(){

        return Rfm::all();
    }

}
