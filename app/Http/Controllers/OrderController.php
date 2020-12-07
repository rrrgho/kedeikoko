<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BaseUrl;
use App\Service\ConvertMoney;
use Session;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $baseURL, $client, $convertMoney;
    public function __construct(){
        $this->baseURL = new BaseUrl;
        $this->client = new Client();
        $this->convertMoney = new ConvertMoney();
    }
    public function orders(){
        $baseURL = $this->baseURL->get();
        return view('order.orders', compact('baseURL'));
    }
    public function orderDetail($id){
        $baseURL = $this->baseURL->get();
        $order = json_decode($this->client->get($baseURL.'order-detail/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('order.order-detail', compact('order','baseURL'));
    }
    public function ajaxGetOrderForm(){
        $baseURL = $this->baseURL->get();
        $reseller = json_decode($this->client->get($baseURL.'reseller-dataonly', [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        $product = json_decode($this->client->get($baseURL.'product-merk-dataonly', [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('order.ajax-order-form', compact('reseller','product'));
    }
    public function getCustomerWhenResellerSelected(Request $request){
        $baseURL = $this->baseURL->get();
        $customer = json_decode($this->client->post($baseURL.'reseller-customer-dataonly', [
            'form_params' => $request->all(),
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('order.ajax-get-customer-by-reseller', compact('customer'));
    }
    public function addNewOrder(Request $request){
        $baseURL = $this->baseURL->get();
        $productStock = json_decode($this->client->get($baseURL.'product-stock-dataonly/'.$request->productmerk_id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        $requestData = $request->all();
        $requestData['due_date'] = Carbon::now('Asia/Jakarta')->addDays($request->due_date)->format('d-m-y H:m:s');
        $requestData['payment_total'] = ($productStock['buyingprice_in_each'] + $productStock['profit_in_each'] + floatval($request->reseller_profit))*$request->amount;
        $requestData['reseller_profit'] =floatval($request->reseller_profit);
        // SEND NEW ORDER
        $insert = json_decode($this->client->post($baseURL.'new-order', [
            'form_params' => $requestData,
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($insert['error'] == false)
            return redirect($request->this_url)->with('success',$insert['message']);
        return redirect($request->this_url)->with('failed',$insert['message']);
    }
    public function payOrder(Request $request){
        $baseURL = $this->baseURL->get();
        $requestData = $request->all();
        $requestData['amount'] = $this->convertMoney->convert($request->amount);
        $pay_order = json_decode($this->client->post($baseURL.'pay-order', [
            'form_params' => $requestData,
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($pay_order['error'] == false)
            return redirect(url('order/order-detail/'.$request->order_id))->with('success',$pay_order['message']);
        return redirect(url('order/order-detail/'.$request->order_id))->with('failed',$pay_order['message']);
    }
}
