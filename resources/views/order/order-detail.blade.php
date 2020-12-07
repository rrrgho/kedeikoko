@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Detail Penjualan</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Penjualan</li>
<li class="breadcrumb-item text-active">Detail Penjualan</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-uppercase">{{ $order['invoice_number'] }}</h3>
                    <span>Detail penjualan untuk invoice <span
                            class="text-uppercase">{{ $order['invoice_number'] }}</span></span>
                </div>
                <div class="card-body">
                    <h6 class="text-uppercase">Reseller : <a class="bold" style="cursor: pointer;" href="{{url('reseller/reseller/'.$order['reseller_appends']['uid'])}}">{{ $order['reseller'] }}</a></h6>
                    <span>{{ $order['reseller_appends']['address'] }}</span>
                    <p></p>
                    <h6 class="text-uppercase">Customer : <a class="bold" style="cursor: pointer;" href="{{url('reseller/reseller-customer-detail/'.$order['customer_appends']['uid'])}}">{{ $order['customer'] }}</a></h6>
                    <span>{{ $order['customer_appends']['address'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="card">
                @if($order['need_to_be_paid'] > 0)
                <div class="card-header">
                    <div class="alert alert-danger"><i class="fa fa-warning pr-3"></i> Masih harus melunasi sebesar Rp . {{number_format($order['need_to_be_paid'],0,',','.')}}</div>
                </div>
                <div class="card-body">
                    <form action="{{route('pay-order')}}" method="POST">@csrf
                    <div class="row">
                        <input type="hidden" name="order_id" value="{{$order['id']}}">
                        <div class="col-5">
                            <input type="text" name="amount" required class="form-control rupiah" value="{{$order['need_to_be_paid']}}">
                        </div>
                        <div class="col-7"><button type="submit" class="btn btn-danger">Bayar Sekarang</button></div>
                    </div>
                    </form>
                </div>
                @else
                    <div class="card-header">
                        <div class="alert alert-success">
                            <i class="fa fa-check"></i> <span class="ml-2">Sudah dilunasi !</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Log Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="payment-log" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-center">Jumlah Pembayaran</th>
                                    <th>Tanggal Pembayaran</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Paid Invoice
    $(function(){
        $('#payment-log').DataTable({
            ajax: {
                url : '{{$baseURL.'order-payment-log-datatable/'.$order['id']}}',
                type : 'GET',
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'amount', name: 'amount'},
                { data: 'created_at', name: 'created_at'},
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
                    "targets" : [0],
                    "className": "text-center"
                },
                {
                    "targets" : [1],
                    "className": "text-right"
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
