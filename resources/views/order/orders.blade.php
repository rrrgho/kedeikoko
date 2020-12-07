@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Data Penjualan</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item text-active">Data Penjualan</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <h5>Penjualan Belum Dilunasi </h5>
               <span>Menampilkan seluruh penjualan yang belum dilunasi</span>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                   <table id="unpaid-invoice" class="table table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nomor Invoice</th>
                                <th>Reseller</th>
                                <th>Pembeli</th>
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
@endsection

@section('script')
    <script>
        // Unpaid Invoice
        $(function(){
            $('#unpaid-invoice').DataTable({
                ajax: {
                    url : '{{$baseURL.'unpaid-orders-datatable'}}',
                    type : 'GET',
                    headers: {
                                "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                            },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'invoice_number', name: 'invoice_number'},
                    { data: 'reseller', name: 'reseller'},
                    { data: 'customer', name: 'customer'},
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
                        "targets" : [0,4,5,6,7],
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
