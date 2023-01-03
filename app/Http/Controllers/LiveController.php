<?php

namespace App\Http\Controllers;

use Google\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Service\Analytics;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    // public function live()
    // {
    //     $this->index();
    //     //         curl --request POST \
    //     //   'https://analyticsreporting.googleapis.com/v4/userActivity:search?key=[YOUR_API_KEY]' \
    //     //   --header 'Authorization: Bearer [YOUR_ACCESS_TOKEN]' \
    //     //   --header 'Accept: application/json' \
    //     //   --header 'Content-Type: application/json' \
    //     //   --data '{"viewId":"6330463","user":{"type":"CLIENT_ID","userId":"1827522931.1666687986"},"dateRange":{"startDate":"2022-08-01","endDate":"2022-11-23"}}' \
    //     //   --compressed
    // }

    public function getAnalytics(Request $request)
    {
        $apiKey = $request['api_key']; //AIzaSyAOl7DH4APUEK2Sadndvz4T6RI-pr7dMzY
        $accessToken = $request['access_token']; //ya29.a0AeTM1icAkNzX3eFmC0VWTEjJ51SXMNSL402yD13qp2IxacROSr_wIyytBcLrWcHJj8UJGlqq7euwF5RqJ-0gSFf5chIXy_mAOJ4PzI7yWL0ZBAgP5np8Kjfa6hyEpXo2thkSDeb-9zUdHpn3ftICIwK4bEMPaCgYKAdoSARMSFQHWtWOmefk1Tkn9RWfQW9fV0WCNTw0163
        $clientIdForQuery = $request['client_id']; //"546101040.1666105581"
        $propertyId = $request['property_id']; //'6330463'

        /* test data */
        $apiKey = "AIzaSyAOl7DH4APUEK2Sadndvz4T6RI-pr7dMzY";
        $accessToken = "ya29.a0AeTM1icAkNzX3eFmC0VWTEjJ51SXMNSL402yD13qp2IxacROSr_wIyytBcLrWcHJj8UJGlqq7euwF5RqJ-0gSFf5chIXy_mAOJ4PzI7yWL0ZBAgP5np8Kjfa6hyEpXo2thkSDeb-9zUdHpn3ftICIwK4bEMPaCgYKAdoSARMSFQHWtWOmefk1Tkn9RWfQW9fV0WCNTw0163";
        $clientIdForQuery = "546101040.1666105581";
        $propertyId = '6330463';
        /* test data end */


        $apiURL = 'https://analyticsreporting.googleapis.com/v4/userActivity:search?key=' . $apiKey;
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $postInput = [
            'viewId' => $propertyId,
            'user' => ["type" => "CLIENT_ID", "userId" => $clientIdForQuery],
            'dateRange' => ["startDate" => "2022-08-01", "endDate" => "2022-11-23"]
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $statusCode = $response->status();
        Log::info($statusCode);
        if ($statusCode == 401) {
        }
        $responseBody = json_decode($response->getBody(), true);
        dd($responseBody);
    }

    public function getAuthUrl()
    {
        $client = $this->getClient();
        return $client->createAuthUrl();
    }

    public function getTokensByAuthCode(Request $request)
    {
        $client = $this->getClient();
        $client->authenticate($request['code']);
        return $client->getAccessToken();
    }

    private function getClient()
    {
        $client = new Client();
        $path = __DIR__ . '/harshawebmotech.json';
        $client->setAuthConfig($path);
        $redirectUri = 'http://localhost:8000';
        $client->setRedirectUri($redirectUri);
        $client->setAccessType("offline");
        $client->setIncludeGrantedScopes(true);
        $client->addScope(Analytics::ANALYTICS_READONLY);
        // $client->fetchAccessTokenWithAuthCode('c');
        return $client;
    }

    public function auth()
    {
        // $client = new Client();
        // $path = __DIR__ . '/harshawebmotech.json';
        // $client->setAuthConfig($path);
        // $redirectUri = 'http://localhost:8000';
        // $client->setRedirectUri($redirectUri);
        // $client->setAccessType("offline");
        // $client->setIncludeGrantedScopes(true);
        // // $client->setApprovalPrompt('consent');
        // $client->addScope(Analytics::ANALYTICS_READONLY);
        // // $token= $client->fetchAccessTokenWithAuthCode('code hee');
        $client = $this->getClient();
        // $token = $client->createAuthUrl();
        // dd($token);

        // $client->authenticate('4/0AfgeXvuQGBCLWLpFhrhdrJb8HoBUPpcqTNM5oxoDKP3iO0OeE1xhidzvQ8paMrALnweNxA');
        $client->authenticate('4/0AfgeXvuHPTMQGUqhoaWF2_nOWQ3hy4KRyxiICLQcksMJmKFj_1VuK25snJqg3-Sm4mjHbw');
        $access_token = $client->getAccessToken();
        dd($access_token);

        // $client->setAccessToken('ya29.a0AeTM1icAkNzX3eFmC0VWTEjJ51SXMNSL402yD13qp2IxacROSr_wIyytBcLrWcHJj8UJGlqq7euwF5RqJ-0gSFf5chIXy_mAOJ4PzI7yWL0ZBAgP5np8Kjfa6hyEpXo2thkSDeb-9zUdHpn3ftICIwK4bEMPaCgYKAdoSARMSFQHWtWOmefk1Tkn9RWfQW9fV0WCNTw0163');

    }

    // public function refresh(){
    //     $client = new Client();
    //     $client->setApplicationName("Client_Library_Examples");
    //     $client->setDeveloperKey("AIzaSyAOl7DH4APUEK2Sadndvz4T6RI-pr7dMzY");

    //     $service = new Analytics($client);
    //     $query = '';
    //     $optParams = [
    //     'filter' => '',
    //     ];
    //     $results = $service->volumes->listVolumes($query, $optParams);

    //     foreach ($results->getItems() as $item) {
    //     echo $item;
    //     }
    // }
}
