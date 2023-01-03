<?php

namespace App\Http\Controllers;

use Exception;
use Google\Client;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    public function getAuthUrl()
    {
        $client = $this->getClient();
        return $client->createAuthUrl();
    }

    public function getTokensByAuthCode(Request $request)
    {
        try {
            $client = $this->getClient();
            $client->authenticate($request['code']);
            return $client->getAccessToken();
        } catch (Exception $e) {
            dd($e);
        }
    }

    private function getClient()
    {
        try {
            $client = new Client();
            $path = __DIR__ . '/medispa.json';
            $client->setAuthConfig($path);
            $redirectUri = 'http://localhost:8000';
            $client->setRedirectUri($redirectUri);
            $client->setAccessType("offline");
            $client->setIncludeGrantedScopes(true);
            $client->addScope("https://www.googleapis.com/auth/adwords");
            return $client;
        } catch (Exception $e) {
            dd($e);
        }
    }
}
