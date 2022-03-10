<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class rfmController extends Controller
{
    public function guzzleGet()
    {
        $client = new \GuzzleHttp\Client();
        $token = 'DupfBNXkBdKZXasfnDKsfcPWuFa7dH1bMZfwY68Qjxd';
        $response = $client->request('GET', 'https://data.beneath.dev/v1/amjadalarori/rfm/rfm-results', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
            'query' => [
                'limit' => 1000
                ]
        ]);
        
        if ($response->getBody()) {
            $json = $response->getBody();
            $arr = json_decode($json, true);

            return $arr;
            // JSON string: { ... }
        }
       
        
        
    }
}
