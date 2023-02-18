<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KlaviyoController extends Controller
{
    public function test()
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://a.klaviyo.com/api/profiles/', [
            'body' => '{"data":{"type":"profile","attributes":{"email":"maicanvlad1998@gmail.com","phone_number":"0764334890","external_id":"63f64a2b-c6bf-40c7-b81f-bed08162edbe","first_name":"Vlad","last_name":"Maican","organization":"Klaviyo","title":"Engineer","image":"https://images.pexels.com/photos/3760854/pexels-photo-3760854.jpeg","location":{"address1":"89 E 42nd St","address2":"1st floor","city":"New York","country":"United States","region":"NY","zip":"10017","timezone":"America/New_York"},"properties":{"newKey":"New Value"}}}}',
            'headers' => [
                'Authorization' => 'Klaviyo-API-Key pk_e9ded1d0811b0d2ba73aa132f0f9340b69',
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'revision' => '2023-01-24',
            ],
        ]);

        echo $response->getBody();
    }
}
