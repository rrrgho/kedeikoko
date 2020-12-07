<form action="{{route('new-order')}}" method="post">@csrf
    <div class="row">
        <div class="col-12">
            <label for="">Reseller</label>
            <select required  id="reseller_id" class="form-control" name="reseller_uid">
                <option value="" hidden>Pilih Reseller</option>
                @foreach ($reseller as $item)
                    <option value="{{$item['uid']}}">{{$item['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 mt-3">
            <label for="">Customer</label>
            <select required  id="customer" class="form-control" name="customer_uid">
                <option value="" hidden>Pilih reseller terlebih dahulu !</option>
            </select>
        </div>
        <div class="col-12 mt-3">
            <label for="">Pilih Produk</label>
            <select required  id="" class="form-control" name="productmerk_id">
                <option value="" hidden>Pilih produk</option>
                @foreach ($product as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3 mt-3">
            <label for="">Jumlah</label>
            <input type="number" name="amount" class="form-control">
        </div>
        <div class="col-3 mt-3">
            <label for="">Jangka waktu</label>
            <input type="number" name="due_date" class="form-control">
        </div>
        <div class="col-6 mt-3">
            <label for="">Keuntungan Reseller</label>
            <input type="text" name="reseller_profit" id="reseller_profit" class="form-control">
        </div>
        <input type="hidden" name="this_url" id="url">
        {{-- <div class="col-12 mt-3">
            <div class="alert alert-warning">
                Harga modal dari produk : <span id="harga-modal"></span> <br>
                Keuntungan perusahaan dari produk : <span id="company-profit"></span> <br>
                Total harga ditambah keuntungan Reseller : <span id="payment-total"></span>
            </div>
        </div> --}}
    </div>
    <div class="modal-footer mt-4">
        <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-secondary" id="btnAddNewReseller" type="submit">Save</button>
    </div>
</form>
