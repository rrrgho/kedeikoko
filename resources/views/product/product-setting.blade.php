@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Produk</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Produk</li>
<li class="breadcrumb-item text-active">Manajemen Produk</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
       {{-- Product Type --}}
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Jenis Produk</h3>
                    <span>Masukan jenis product baru, contoh : Sabun, Obat - Obatan, dll.</span>
                </div>
                <div class="card-body">
                    <form action="{{url('products/product-type-regist')}}" method="POST">@csrf
                        <div class="form-group">
                            <label for="">Jenis Produk</label>
                            <input required type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group pb-5">
                            <button type="submit" class="btn float-right btn-primary">Simpan</button>
                        </div>
                    </form>
                    <div class="col-mt-4">
                        <h5>Jenis Produk Terdaftar</h5>
                        <span>Atur produk terdaftar pada bagian ini !</span> <hr>
                        <table id="product-type" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Nama Jenis Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Jenis Produk</h3>
                    <span>Masukan jenis product baru, contoh : Sabun, Obat - Obatan, dll.</span>
                </div>
                <div class="card-body">
                    <form action="{{url('products/product-merk-regist')}}" method="POST">@csrf
                        <div class="form-group">
                            <label for="">Jenis Produk</label>
                            <select required name="producttype_id" id="" class="form-control">
                                <option value="" hidden>Pilih Jenis Produk</option>
                                @foreach ($productType as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Merk Produk</label>
                            <input required type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group pb-5">
                            <button type="submit" class="btn float-right btn-primary">Simpan</button>
                        </div>
                    </form>
                    <div class="col-mt-4">
                        <h5>Jenis Produk Terdaftar</h5>
                        <span>Atur produk terdaftar pada bagian ini !</span> <hr>
                        <table id="product-merk" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Merk Produk</th>
                                    <th>Jenis Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Merk --}}
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button data-toggle="modal" data-target="#addNewStock" class="btn btn-pill btn-primary text-active position-absolute" style="right:40px; top:20px;" type="button"><i class="fa fa-plus mr-2"></i>Tambah Stok</button>
                    <h3>Stok Produk</h3>
                    <span>Tambahkan stok produk disini, tambah merk dan jenis terlebih dahulu jika belum tersedia !</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="product-stock">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Merk Produk</th>
                                    <th>Jenis Produk</th>
                                    <th>Jumlah Stok</th>
                                    <th>Estimasi Keuntungan /Stok</th>
                                    <th>Estimasi Modal /Stok</th>
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

{{-- Modal Add New Stock --}}
<div class="modal fade" id="addNewStock" tabindex="-1" role="dialog" aria-labelledby="addNewStockLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addNewStockLabel">Tambah Stok</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <form action="{{route('product-stock-regist')}}" method="post">@csrf
                <div class="row">
                    <div class="col-6">
                        <label for="">Jenis Produk</label>
                        <select required name="productmerk_id" id="" class="form-control">
                            <option value="" hidden>Pilih Jenis Produk</option>
                            @foreach ($productMerk as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="">Jumlah Stok : </label>
                        <input type="text"  required name="stock_amount" required class="form-control">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="">Estimasi Keuntungan / 1 Stok : </label>
                        <input type="text"  name="profit_in_each" class="form-control rupiah">
                    </div>
                    <div class="col-6 mt-3">
                        <label for="">Estimasi Modal / 1 Stok : </label>
                        <input type="text" name="buyingprice_in_each" class="form-control rupiah">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-secondary" id="btnAddNewReseller" type="submit">Save</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Product Type Datatable
    $(function(){
        $('#product-type').DataTable({
            ajax: {
                url : '{{$baseURL.'product-type-datatable'}}',
                type : 'GET',
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'name', name: 'name'},
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
                    "targets" : [0,2],
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

    // Product Merk Datatable
    $(function(){
        $('#product-merk').DataTable({
            ajax: {
                url : '{{$baseURL.'product-merk-datatable'}}',
                type : 'GET',
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'name', name: 'name'},
                { data: 'product_type', name: 'product_type'},
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
                    "targets" : [0,3],
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

    // Product Merk Datatable
    $(function(){
        $('#product-stock').DataTable({
            ajax: {
                url : '{{$baseURL.'product-stock-datatable'}}',
                type : 'GET',
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'product_merk', name: 'product_merk'},
                { data: 'product_type', name: 'product_type'},
                { data: 'stock_amount', name: 'stock_amount'},
                { data: 'profit_in_each', name: 'profit_in_each'},
                { data: 'buyingprice_in_each', name: 'buyingprice_in_each'},
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
                    "targets" : [0,3,6],
                    "className": "text-center"
                },
                {
                    "targets" : [4,5],
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
