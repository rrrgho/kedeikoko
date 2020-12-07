@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Akun kas {{$bankAccount['holder_name']}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Akun kas {{$bankAccount['holder_name']}}</li>
<li class="breadcrumb-item" style="cursor: pointer" onclick="document.location.href='{{route('bank-account-info')}}'"> Bank Account </li>
<li class="breadcrumb-item text-active">Bank Account Detail | {{$bankAccount['holder_name']}}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h3>Transaksi Keluar</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-transaction-out" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Tujuan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h3>Transaksi Masuk</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-transaction-in" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Dari</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
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
                    <h3>Transaksi Jual Beli</h3>
                    <span>History transaksi pembelian stok barang dan lainnya</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-buy-sell-log" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th class="text-center">Total</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Created At</th>
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
    $(function(){
        $('#table-transaction-out').DataTable({
            ajax: {
                url : '{{$baseURL.'bankaccount-transaction-out-datatable'}}',
                type : 'POST',
                data: {
                    thisbank_id : '{{$bankAccount['id']}}',
                },
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'destination', name: 'destination'},
                { data: 'amount', name: 'amount'},
                { data: 'status', name: 'status'},
                { data: 'type', name: 'type'},
                { data: 'about', name: 'about'},
                { data: 'created_at', name: 'created_at'},
            ],
            language: {
            searchPlaceholder: 'Search by : Master number, AWB/SMU Number',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },

            // "order": [[ 0, "desc" ]],
            columnDefs:[
                {
                    "targets" : [1,3,4,5,6],
                    "className": "text-center"
                },
                {
                    "targets" : [2],
                    "className": "text-right"
                },
            ],


            dom: 'Bfrtip',
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

    $(function(){
        $('#table-transaction-in').DataTable({
            ajax: {
                url : '{{$baseURL.'bankaccount-transaction-in-datatable'}}',
                type : 'POST',
                data: {
                    thisbank_id : '{{$bankAccount['id']}}',
                },
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'from', name: 'from'},
                { data: 'amount', name: 'amount'},
                { data: 'about', name: 'about'},
                { data: 'created_at', name: 'created_at'},
            ],
            language: {
            searchPlaceholder: 'Search by : Master number, AWB/SMU Number',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },

            // "order": [[ 0, "desc" ]],
            columnDefs:[
                {
                    "targets" : [1,3,4],
                    "className": "text-center"
                },
                {
                    "targets" : [2],
                    "className": "text-right"
                },
            ],


            dom: 'Bfrtip',
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

    $(function(){
        $('#table-buy-sell-log').DataTable({
            ajax: {
                url : '{{$baseURL.'bankaccount-buy-sell-log-datatable'}}',
                type : 'POST',
                data: {
                    bankaccount_id : '{{$bankAccount['id']}}',
                },
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'total', name: 'total'},
                { data: 'status', name: 'status'},
                { data: 'description', name: 'description'},
                { data: 'created_at', name: 'created_at'},
            ],
            language: {
            searchPlaceholder: 'Search by : Master number, AWB/SMU Number',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },

            // "order": [[ 0, "desc" ]],
            columnDefs:[
                {
                    "targets" : [0,2,4],
                    "className": "text-center"
                },
                {
                    "targets" : [1],
                    "className": "text-right"
                },
            ],


            dom: 'Bfrtip',
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
