<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BaseUrl;
use Session;

class AuthController extends Controller
{
    protected $baseURL, $client;
    public function __construct(){
        $this->baseURL = new BaseUrl;
        $this->client = new Client();
    }

    public function login(Request $request){
        if(!$request->all())
            return view('auth.login');
        $trylogin = json_decode($this->client->post($this->baseURL->get().'login', ['form_params' => $request->all()])->getBody()->getContents(), true);
        if($trylogin['error'] == true)
            return $trylogin['message'];
        Session::put('CheckAuth', $trylogin['data']);
        return redirect(route('index'));
    }
    public function logout(){
        Session::flush();
        return redirect(route('login'));
    }
}
