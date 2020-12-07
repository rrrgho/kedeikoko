@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Reseller Detail | <span class="bg-warning text-dark bold pl-2 pr-2">{{$reseller['name']}}</span></h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Reseller</li>
<li class="breadcrumb-item" style="cursor: pointer" onclick="document.location.href='{{route('reseller-data')}}'"> Reseller Data </li>
<li class="breadcrumb-item text-active">Reseller Detail | {{$reseller['name']}}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">

        {{-- Debt Amount --}}
        <div class="col-xl-4 box-col-3 col-lg-12 col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                <div class="ecommerce-widgets media">
                    <div class="media-body">
                    <p class="f-w-500 font-roboto">Debt Amount<span class="badge pill-badge-primary ml-3">New</span></p>
                    <h4 class="f-w-500 mb-0 f-26"><span class="counter">{{number_format($reseller['debt'],0,',','.')}}</span></h4>
                    </div>
                    <div class="ecommerce-box light-bg-primary bg-danger">Rp</div>
                </div>
                </div>
            </div>
        </div>

        {{-- Income Amount --}}
        <div class="col-xl-4 box-col-3 col-lg-12 col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                <div class="ecommerce-widgets media">
                    <div class="media-body">
                    <p class="f-w-500 font-roboto">Amount Income<span class="badge pill-badge-primary ml-3">New</span></p>
                    <h4 class="f-w-500 mb-0 f-26"><span class="counter">{{number_format($reseller['income'],0,',','.')}}</span></h4>
                    </div>
                    <div class="ecommerce-box light-bg-primary bg-success">Rp</div>
                </div>
                </div>
            </div>
        </div>

        {{-- Sale Value --}}
        <div class="col-xl-4 box-col-3 col-lg-12 col-md-4">
            <div class="card o-hidden">
                <div class="card-body">
                <div class="ecommerce-widgets media">
                    <div class="media-body">
                    <p class="f-w-500 font-roboto">Sale Value<span class="badge pill-badge-primary ml-3">New</span></p>
                    <h4 class="f-w-500 mb-0 f-26"><span class="counter">{{number_format($reseller['sale_value'],0,',','.')}}</span></h4>
                    </div>
                    <div class="ecommerce-box light-bg-primary bg-warning">Rp</div>
                </div>
                </div>
            </div>
        </div>
    </div>
   <div class="row">
        {{-- Customer Total --}}
        <div class="col-xl-3 box-col-3 col-lg-12 col-md-3">
            <div class="card o-hidden">
                <div class="card-body">
                <div class="ecommerce-widgets media">
                    <div class="media-body">
                    <p class="f-w-500 font-roboto">Customers<span class="badge pill-badge-primary ml-3"></span></p>
                    <h4 class="f-w-500 mb-0 f-26">{{$reseller['customers']}}</h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 box-col-3 col-lg-12 col-md-9">
            <div class="card">
                <div class="card-header">
                    <button data-toggle="modal" data-target="#addCustomer" class="btn btn-pill btn-primary text-active position-absolute" style="right:40px; top:20px;" type="button"><i class="fa fa-plus mr-2"></i> Add New Customer</button>
                <h5>{{$reseller['name']}}'s Customer</h5>
                <span>Manage {{$reseller['name']}}'s customer right here !</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reseller-customer-datatable" class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>

{{-- Modal Add New Reseller --}}
<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCustomerLabel">New Customer</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <form action="{{route('reseller-addcustomer')}}" method="post">@csrf
                <input type="hidden" name="reseller_uid" value="{{$reseller['uid']}}">
                <div class="row">
                    <div class="col-6">
                        <label for="">Name : </label>
                        <input type="text"  required name="name" required class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="">National ID : </label>
                        <input type="number"  required name="national_id" required class="form-control">
                    </div>
                    <div class="col-12 mt-3">
                        <label for="">Address : </label>
                        <textarea  required name="address" id="" cols="30" rows="5" class="form-control"></textarea>
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

{{-- Data from PHP will be sent to Javascript --}}
<input type="hidden" id="reseller_uid" value="{{$reseller['uid']}}">
@endsection

@section('script')
<script>
    $(function(){
        $('#reseller-customer-datatable').DataTable({
            ajax: {
                url : '{{$baseURL.'reseller-customer-datatable'}}',
                type : 'POST',
                data: {
                    reseller_uid : $('#reseller_uid').val()
                },
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'name', name: 'name'},
                { data: 'address', name: 'address'},
                { data: 'action', name: 'action'},
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
                    "targets" : [3],
                    "className": "text-center"
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
