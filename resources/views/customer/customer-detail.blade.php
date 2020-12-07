@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Customer</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Reseller</li>
<li class="breadcrumb-item" style="cursor: pointer" onclick="document.location.href='{{route('reseller-data')}}'"> Reseller Data </li>
<li class="breadcrumb-item" style="cursor: pointer" onclick="document.location.href='{{url('reseller/reseller/'. $customer['reseller_uid'])}}'">Reseller {{$customer['reseller']}}</li>
<li class="breadcrumb-item active">Customer Detail</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12 col-lg-4">
          <div class="card">
              <div class="card-header">
                  <h1>{{$customer['name']}}</h1>
              </div>
              <div class="card-body">
                  {{$customer['address']}}
              </div>
          </div>
      </div>
      <div class="col-md-12 col-lg-8">
        <div class="row">

            {{-- Debt Amount --}}
            <div class="col-md-12 col-lg-6">
                <div class="card o-hidden">
                    <div class="card-body">
                    <div class="ecommerce-widgets media">
                        <div class="media-body">
                        <p class="f-w-500 font-roboto">Debt Amount</p>
                        <h4 class="f-w-500 mb-0 f-26"><span class="counter">{{number_format($customer['debt'],0,',','.')}}</span></h4>
                        </div>
                        <div class="ecommerce-box light-bg-primary bg-danger">Rp</div>
                    </div>
                    </div>
                </div>
            </div>

            {{-- Sale Value --}}
            <div class="col-md-12 col-lg-6">
                <div class="card o-hidden">
                    <div class="card-body">
                    <div class="ecommerce-widgets media">
                        <div class="media-body">
                        <p class="f-w-500 font-roboto">Sale Value</p>
                        <h4 class="f-w-500 mb-0 f-26"><span class="counter">{{number_format($customer['sale_value'],0,',','.')}}</span></h4>
                        </div>
                        <div class="ecommerce-box light-bg-primary bg-warning">Rp</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Invoice Berjalan</h3>
                        <span>Data pesanan yang belum dilunasi </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="unpaid-invoice" class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Nomor Invoice</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah Produk</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Invoice Selesai</h3>
                        <span>Data pesanan yang telah dilunasi </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="paid-invoice" class="table table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Nomor Invoice</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah Produk</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
   </div>
</div>
@endsection

@section('script')
    <script>
        // Unpaid Invoice
        $(function(){
            $('#unpaid-invoice').DataTable({
                ajax: {
                    url : '{{$baseURL.'unpaid-orders-customer-datatable/'.$customer['uid'].'/ongoing'}}',
                    type : 'GET',
                    headers: {
                                "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                            },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'invoice_number', name: 'invoice_number'},
                    { data: 'product', name: 'product'},
                    { data: 'amount', name: 'amount'},
                    { data: 'due_date', name: 'due_date'},
                    { data: 'action', name: 'action'},
                ],
                language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                destroy: true
                },

                // "order": [[ 0, "desc" ]],
                columnDefs:[
                    {
                        "targets" : [0,1,3,4,5],
                        "className": "text-center"
                    },
                ],


                // dom: 'Bfrtip',
                buttons: [
                    {extend:'copy', className: 'bg-info text-white rounded-pill ml-2 border border-white'},
                    {extend:'excel', className: 'bg-success text-white rounded-pill border border-white'},
                    {extend:'pdf', className: 'bg-danger text-white rounded-pill border border-white'},
                    {extend:'print', className: 'bg-warning text-white rounded-pill border border-white'},
                ],
                "bDestroy": true,
                "processing": true,
                "serverSide": true,
            });

        });

        // Paid Invoice
        $(function(){
            $('#paid-invoice').DataTable({
                ajax: {
                    url : '{{$baseURL.'unpaid-orders-customer-datatable/'.$customer['uid'].'/paid'}}',
                    type : 'GET',
                    headers: {
                                "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                            },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'invoice_number', name: 'invoice_number'},
                    { data: 'product', name: 'product'},
                    { data: 'amount', name: 'amount'},
                    { data: 'due_date', name: 'due_date'},
                    { data: 'action', name: 'action'},
                ],
                language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                destroy: true
                },

                // "order": [[ 0, "desc" ]],
                columnDefs:[
                    {
                        "targets" : [0,1,3,4,5],
                        "className": "text-center"
                    },
                ],


                // dom: 'Bfrtip',
                buttons: [
                    {extend:'copy', className: 'bg-info text-white rounded-pill ml-2 border border-white'},
                    {extend:'excel', className: 'bg-success text-white rounded-pill border border-white'},
                    {extend:'pdf', className: 'bg-danger text-white rounded-pill border border-white'},
                    {extend:'print', className: 'bg-warning text-white rounded-pill border border-white'},
                ],
                "bDestroy": true,
                "processing": true,
                "serverSide": true,
            });

        });
    </script>
@endsection
