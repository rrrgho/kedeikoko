@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Bank Account Info</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Financial</li>
<li class="breadcrumb-item text-text-active">Bank Account Info</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach ($bankAccount as $item)
            <div class="col-md-12 col-lg-6">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="ecommerce-widgets media">
                            <div class="media-body">
                                <p class="f-w-500 font-roboto" style="cursor: pointer;" onclick="document.location.href='{{url('financial/bank-account-info/'.$item['id'])}}'">{{$item['holder_name']}}<span class="badge pill-badge-primary ml-3">{{$item['account_number']}}</span></p>
                                <h4 class="f-w-500 mb-0 f-26"><span class="counter">Rp. {{number_format($item['cash_total'],2,',','.')}}</span></h4>
                            </div>
                            <div class="ecommerce-box light-bg-primary bg-success topUp"  value="{{$item['id']}}" style="cursor: pointer" data-toggle="modal" data-target="#topUp"><i class="fa fa-plus"></i>/<i class="fa fa-minus"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Modal Add New Reseller --}}
<div class="modal fade" id="topUp" tabindex="-1" role="dialog" aria-labelledby="topUpLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="topUpLabel">Top Up Dana</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <form action="{{route('top-up')}}" method="post">@csrf
                <input type="hidden" name="id" id="bankaccount_id" value="">
                <div class="row">
                    <div class="col-12">
                        <label for="">Jumlah Dana : </label>
                        <input type="text"  required name="cash_total" required class="form-control rupiah">
                    </div>
                    <div class="col-12 mt-4">
                        <label for="">Jenis Transaksi : </label>
                        <select name="type" required id="transaction" class="form-control">
                            <option value="" hidden>Pilih jenis transaksi</option>
                            <option value="topup">Top Up</option>
                            <option value="cut">Potong Dana</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4 d-none" id="destination_bank">
                        <label for="">Akun Kas Tujuan : </label>
                        <select name="joinbank_id" required id="" disabled class="form-control">
                            <option value="" hidden>Pilih Akun Kas Tujuan</option>
                            @foreach ($bankAccount as $item)
                                <option value="{{$item['id']}}">{{$item['holder_name']}} | {{$item['account_number']}} | {{$item['bank_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mt-4 d-none" id="transfer_type">
                        <label for="">Jenis Transfer : </label>
                        <select name="transfer_type" required id="" disabled class="form-control">
                            <option value="" hidden>Pilih Jenis Transfer</option>
                            <option value="transfer_only">Hanya Transfer</option>
                            <option value="giving_loan">Memberi Pinjaman Dana</option>
                        </select>
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
        var topUp = document.querySelectorAll('.topUp');
        $(topUp).click(function(){
            $('#bankaccount_id').val($(this).attr('value'));
        })

        $('#transaction').on('change', function(){
            if($(this).val() == 'transfer'){
                $('#destination_bank').removeClass('d-none')
                $('#destination_bank select').removeAttr('disabled')
                $('#transfer_type').removeClass('d-none')
                $('#transfer_type select').removeAttr('disabled')
            }else{
                $('#destination_bank').addClass('d-none')
                $('#destination_bank select').attr('disabled','disabled')
                $('#transfer_type').addClass('d-none')
                $('#transfer_type select').attr('disabled','disabled')
            }
        })
    </script>
@endsection
