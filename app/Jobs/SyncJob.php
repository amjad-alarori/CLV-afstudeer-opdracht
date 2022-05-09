<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use App\Models\Rfm;
use DB;

class SyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $syncedResults = $this->guzzleGet();
        Rfm::truncate();
        
        /**
         * @var \Illuminate\Database\Eloquent\Model $rfm
         */
        DB::table('rfms')->insert(['RFM' => json_encode($syncedResults), "created_at" =>  date('Y-m-d H:i:s'),
        "updated_at" => date('Y-m-d H:i:s')]);
 
    }

    public function guzzleGet()
    {
        $aData = [];
        $sCursor = null;

        while($aResponse = $this->guzzleGetData($sCursor))
        {
            if(empty($aResponse['data']))
            {
                break;
            }
            else
            {

                $aData = array_merge($aData, $aResponse['data']);


                if(empty($aResponse['meta']['next_cursor']))
                {
                    break;
                }
                else
                {
                    $sCursor = $aResponse['meta']['next_cursor'];
                }
            }
        }
        

        
        return $aData;
        // $user = Auth::user()->name;
        // return view("admin/home")->with(['data' => json_encode($aData)]);


    }
    

    protected function guzzleGetData($sCursor = null)
    {
        $client = new \GuzzleHttp\Client();
        $token = 'DupfBNXkBdKZXasfnDKsfcPWuFa7dH1bMZfwY68Qjxd';

        $response = $client->request('GET', 'https://data.beneath.dev/v1/amjadalarori/rfm/rfm-results', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
            'query' => [
                'limit' => 1000,
                'cursor' => $sCursor
            ]
        ]);

        if($response->getBody())
        {
            return json_decode($response->getBody(), true) ?: [];
        }

        return [];
    }
}
