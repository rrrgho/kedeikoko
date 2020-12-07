<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BaseUrl;
use App\Service\ConvertMoney;
use Session;

class FinancialController extends Controller
{
    protected $baseURL, $client, $convertMoney;
    public function __construct(){
        $this->baseURL = new BaseUrl;
        $this->client = new Client();
        $this->convertMoney = new ConvertMoney();
    }
    public function BankAccount(){
        $baseURL = $this->baseURL->get();
        $bankAccount = json_decode($this->client->get($baseURL.'bankaccount-dataonly', [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('financial.bank-account', compact('bankAccount'));
    }
    public function BankAccountDetail($id){
        $baseURL = $this->baseURL->get();
        $bankAccount = json_decode($this->client->get($baseURL.'bankaccount-data/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('financial.bank-account-detail', compact('baseURL','bankAccount'));
    }
    public function BankAccountTopUp(Request $request){
        $requestData = $request->all();
        $requestData['cash_total'] = $this->convertMoney->convert($request->cash_total);
        $insert = json_decode($this->client->post($this->baseURL->get().'bankaccount-topup', [
            'form_params' => $requestData,
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(), true);
        if($insert['error'] == false)
            return redirect(route('bank-account-info'))->with('success', $insert['message']);
        return redirect(route('bank-account-info'))->with('failed', $insert['message']);
    }
    public function Credit(){
        return view('financial.credit');
    }
    public function Debit(){
        return view('financial.debit');
    }
}
