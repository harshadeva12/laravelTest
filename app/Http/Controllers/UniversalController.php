<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UniversalController extends Controller
{
    public function universal(){
        $trackingId = '343340271';
        $baseUri = 'http://www.google-analytics.com/';
        $client = new Client(['base_uri' => $baseUri]);
        $formData = [
            'v' => '1',  # API Version.
            'tid' => $trackingId,  # Tracking ID / Property ID.
            # Anonymous Client Identifier. Ideally, this should be a UUID that
            # is associated with particular user, device, or browser instance.
            'cid' => '555',
            't' => 'event',  # Event hit type.
            'ec' => 'Poker',  # Event category.
            'ea' => 'Royal Flush',  # Event action.
            'el' => 'Hearts',  # Event label.
            'ev' => 0,  # Event value, must be an integer
        ];
        $gaResponse = $client->request('POST', 'collect', ['form_params' => $formData]);
        dd($gaResponse);
    }
}
