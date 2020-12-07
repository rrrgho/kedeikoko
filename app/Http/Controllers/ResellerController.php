<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BaseUrl;
use Session;

class ResellerController extends Controller
{
    protected $baseURL, $client;
    public function __construct(){
        $this->baseURL = new BaseUrl;
        $this->client = new Client();
    }
    public function ResellerData(){
        $baseURL = $this->baseURL->get();
        return view('reseller.reseller-data', compact('baseURL'));
    }
    public function Reseller($uid){
        $baseURL = $this->baseURL->get();
        $reseller = json_decode($this->client->get($baseURL.'reseller-data/'.$uid, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('reseller.reseller', compact('baseURL','reseller'));
    }
    public function ResellerDelete($uid){
        $baseURL = $this->baseURL->get();
        $reseller = json_decode($this->client->get($baseURL.'reseller-delete/'.$uid, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($reseller['error'] == false)
            return redirect(route('reseller-data'))->with('success', $reseller['message']);
        return redirect(route('reseller-data'))->with('failed', $reseller['message']);
    }

    // Customer
    public function ResellerAddCustomer(Request $request){
        $insert = json_decode($this->client->post($this->baseURL->get().'reseller-customer-regist', [
            'form_params' => $request->all(),
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
            ])->getBody()->getContents(), true);
        if($insert['error'] == false)
            return redirect(url('reseller/reseller/'.$request->reseller_uid))->with('success', $insert['message']);
        return redirect(url('reseller/reseller/'.$request->reseller_uid))->with('failed', $insert['message']);
    }
    public function ResellerCustomerDelete($uid,$reseller_uid){
        $baseURL = $this->baseURL->get();
        $reseller = json_decode($this->client->get($baseURL.'reseller-customer-delete/'.$uid, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($reseller['error'] == false)
            return redirect(url('reseller/reseller/'.$reseller_uid))->with('success', $reseller['message']);
        return redirect(url('reseller/reseller/'.$reseller_uid))->with('failed', $reseller['message']);
    }
    public function ResellerCustomerDetail($uid){
        $baseURL = $this->baseURL->get();
        $customer = json_decode($this->client->get($this->baseURL->get().'reseller-customer-detail/'.$uid, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(), true)['data'];
        return view('customer.customer-detail', compact('customer','baseURL'));
    }
}
