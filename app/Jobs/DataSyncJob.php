<?php

declare(strict_types=1);

use Illuminate\Contracts\Queue\ShouldQueue;

class DataSyncJob implements ShouldQueue
{
    public function handle()
    {
        $syncedResults = $this->guzzleGet();

        Rfm::truncate();
        $rfm = new Rfm();
        /**
         * @var \Illuminate\Database\Eloquent\Model $rfm
         */
        $rfm->save($syncedResults);
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


        $user = Auth::user()->name;
        return view("".$user."/home")->with(['data' => json_encode($aData)]);


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
