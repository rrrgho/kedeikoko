@if(count($customer)>0)
@foreach ($customer as $item)
    <option value="{{$item['uid']}}">{{$item['name']}}</option>
@endforeach
@else
<option value="" hidden>Tidak ada customer untuk reseller ini !</option>
@endif
