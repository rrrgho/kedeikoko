<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BaseUrl;
use App\Service\ConvertMoney;
use Session;

class ProductController extends Controller
{
    protected $baseURL, $client, $convertMoney;
    public function __construct(){
        $this->baseURL = new BaseUrl;
        $this->client = new Client();
        $this->convertMoney = new ConvertMoney();
    }

    public function ProductStock(){
        return view('product.product-stock');
    }
    public function ProductSetting(){
        $baseURL = $this->baseURL->get();
        $productType = json_decode($this->client->get($baseURL.'product-type-dataonly', [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        $productMerk = json_decode($this->client->get($baseURL.'product-merk-dataonly', [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true)['data'];
        return view('product.product-setting', compact('baseURL','productType','productMerk'));
    }
    public function ProductTypeRegist(Request $request){
        $insert = json_decode($this->client->post($this->baseURL->get().'product-type-regist', [
            'form_params' => $request->all(),
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(), true);
        if($insert['error'] == false)
            return redirect(route('product-setting'))->with('success', $insert['message']);
        return redirect(route('product-setting'))->with('failed', $insert['message']);
    }
    public function ProductTypeDelete($id){
        $baseURL = $this->baseURL->get();
        $productType = json_decode($this->client->get($baseURL.'product-type-delete/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($productType['error'] == false)
            return redirect(route('product-setting'))->with('success', $productType['message']);
        return redirect(route('product-setting'))->with('failed', $productType['message']);
    }

    // Produk Merk
    public function ProductMerkRegist(Request $request){
        $insert = json_decode($this->client->post($this->baseURL->get().'product-merk-regist', [
            'form_params' => $request->all(),
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(), true);
        if($insert['error'] == false)
            return redirect(route('product-setting'))->with('success', $insert['message']);
        return redirect(route('product-setting'))->with('failed', $insert['message']);
    }
    public function ProductMerkDelete($id){
        $baseURL = $this->baseURL->get();
        $productMerk = json_decode($this->client->get($baseURL.'product-merk-delete/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($productMerk['error'] == false)
            return redirect(route('product-setting'))->with('success', $productMerk['message']);
        return redirect(route('product-setting'))->with('failed', $productMerk['message']);
    }

    // Product Stock
    public function ProductStockRegist(Request $request){
        $requestData = $request->all();
        $requestData['profit_in_each'] = $this->convertMoney->convert($request->profit_in_each);
        $requestData['buyingprice_in_each'] = $this->convertMoney->convert($request->buyingprice_in_each);

        $insertLogData['total'] = $requestData['buyingprice_in_each']*$requestData['stock_amount'];
        $insertLogData['status'] = 'CREDIT';
        $insertLogData['description'] = 'Pembelian produk untuk stok sebanyak '.$request->stock_amount.' dengan harga Rp. '.number_format($requestData['buyingprice_in_each'],'0',',','.');
        $insertLog = json_decode($this->client->post($this->baseURL->get().'bankaccount-log', [
            'form_params' => $insertLogData,
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(), true);
        if($insertLog['error'] != true){
            $insert = json_decode($this->client->post($this->baseURL->get().'product-stock-regist', [
                'form_params' => $requestData,
                'headers' => [
                    'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
                ]
            ])->getBody()->getContents(), true);
            if($insert['error'] == false)
                return redirect(route('product-setting'))->with('success', $insert['message']);
        }
        return redirect(route('product-setting'))->with('failed', $insertLog['message']);
    }
    public function ProductStockDelete($id){
        $baseURL = $this->baseURL->get();
        $productMerk = json_decode($this->client->get($baseURL.'product-stock-delete/'.$id, [
            'headers' => [
                'Authorization' => 'Bearer '.Session::get('CheckAuth')['token']
            ]
        ])->getBody()->getContents(),true);
        if($productMerk['error'] == false)
            return redirect(route('product-setting'))->with('success', $productMerk['message']);
        return redirect(route('product-setting'))->with('failed', $productMerk['message']);
    }
}
