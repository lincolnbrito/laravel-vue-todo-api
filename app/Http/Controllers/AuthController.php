<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        try {

            $response = $http->post('http://laravel-vue-todo-api.local/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'gPK7gzblJcSm3vXDnZoWN74e5gTEJcLqJPpwAGOU',
                    'username' => $request->username,
                    'password' => $request->password
                ],
                'exceptions' => false,
            ]);

            return $response->getBody();

        }catch(\GuzzleHttp\Exception\BadRequestException $e) {
            if($e->getCode == 400 ){
                return response()->jsogn('Invalid Request. Please enter a username or a password', $e->getCode());
            }else if($e->getCode == 401 ){
                return response()->jsogn('Your credentials are incorrect. Please tray again', $e->getCode());
            }

            return response()->json('Something went wrong on ther server.'. $e->getCode());
        }
    }
}
