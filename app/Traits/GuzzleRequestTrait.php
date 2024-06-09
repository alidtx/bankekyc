<?php

namespace App\Traits;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait GuzzleRequestTrait
{
    public function guzzlePost(string $base, string $api, array $formParams = [])
    {
        $formParams['debug'] = FALSE;
        $client = new Client(['base_uri' => $base]);
     
        return $client->post($api, $formParams);
    }

    public function guzzlePostCustom(string $base, string $api, array $formParams)
    {
        $client = new Client(['base_uri' => $base]);
        $response = $client->post($api, [
            'debug' => FALSE,
            'form_params' => $formParams,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
        return $response;
    }


    public function guzzlePostGaze(string $base, string $api, $file1, $file2 = '')
    {
        $client = new Client(['base_uri' => $base]);
        if ($api == 'verify') {
            $multipart = [
                [
                    'name' => 'nid_img',
                    'contents' => fopen($file1, 'r')
                ],
                [
                    'name' => 'photo',
                    'contents' => fopen($file2, 'r')
                ]
            ];
        } else {
            $multipart = [
                [
                    'name' => 'nid_front', //document ai middle tier
                    //                    'name' => 'image', // gaze
                    'contents' => fopen($file1, 'r')
                ]
            ];
        }

        $nid_img = base64_encode(file_get_contents(public_path($file1)));
        $photo = base64_encode(file_get_contents(public_path($file2)));
        //$requestBody = '{"nid_img": "' . $nid_img . '","photo": "' . $photo . '"}';
    

        $response = Http::withoutVerifying()->post($base . $api, [
            'nid_img' => $nid_img,
            'photo' => $photo
        ]);
        return $response;
    }

    
    public function guzzlePostGazeCopy(string $base, string $api, $file1, $file2 = '')
    {
        $client = new Client(['base_uri' => $base]);
        $nid_img = base64_encode(file_get_contents(public_path($file1)));
        $photo = base64_encode(file_get_contents(public_path($file2)));
      
        // Log::info('api:'. $base . $api);
        // $response = Http::withoutVerifying()->post($base . $api, [
        //     'source' => 101,
        //     'file_type' => 'jpg',
        //     'file' => $nid_img,
        // ]);
        // Log::info('curl'. json_encode($response));
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onlinemerchdocver.sslwireless.com/nid',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "source": 101,
            "file_type": "jpg",
            "file": "'.$nid_img.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
       // echo $response;
        Log::info("CURL response".$response);
        return $response;
    }

    public function guzzleGet(string $base, string $api, array $formParams)
    {
        Log::debug("in guzzle request: " . print_r($formParams, true));

        $client = new Client(['base_uri' => $base]);
        
        $response = $client->get($api, [
            'debug' => FALSE,
            'query' => $formParams,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        return $response;
    }

    public function requestResponseLogCreate($transaction_id, $user_id, $requested_at, $request_params, $url, $status = 'processing')
    {
        //        $requestResponseLog = RequestResponseLog::create([
        //            'transaction_id' => $transaction_id,
        //            'user_id' => $user_id,
        //            'requested_at' => $requested_at,
        //            'request_params' => $request_params,
        //            'status' => $status,
        //            'url' => $url
        //        ]);

        //        return $requestResponseLog ? true : false;
    }

    public function requestReponseLogUpdate($transaction_id, $response_at, $response_params, $status)
    {
        //        $requestResponseLog = RequestResponseLog::where('transaction_id', $transaction_id)->first();
        //        if ($requestResponseLog)
        //            $requestResponseLog = $requestResponseLog->update([
        //                'response_at' => $response_at,
        //                'response_params' => $response_params,
        //                'status' => $status,
        //            ]);
        //        return $requestResponseLog ? true : false;
    }
}