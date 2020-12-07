@extends('layouts.dark.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Reseller Data</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Reseller</li>
<li class="breadcrumb-item text-active">Reseller Data</li>
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <button data-toggle="modal" data-target="#addReseller" class="btn btn-pill btn-primary text-active position-absolute" style="right:40px; top:20px;" type="button"><i class="fa fa-plus mr-2"></i> Add New Reseller</button>
               <h5>Sample</h5>
               <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
            </div>
            <div class="card-body">
               <div class="tabler-responsive">
                   <table id="reseller-datatable" class="table table-striped">
                       <thead>
                           <tr class="text-center">
                               <th>Name</th>
                               <th>National ID</th>
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
<div class="modal fade" id="addReseller" tabindex="-1" role="dialog" aria-labelledby="addResellerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addResellerLabel">New Reseller</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <form id="addResellerForm" enctype="multipart/form-data" type="post">@csrf
                <div class="row">
                    <div class="col-6">
                        <label for="">Name : </label>
                        <input type="text" id="name" required class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="">National ID : </label>
                        <input type="number" id="national_id" required class="form-control">
                    </div>
                    <div class="col-12 mt-3">
                        <label for="">Address : </label>
                        <textarea id="address" id="" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <label for="">Upload National ID Card Image : </label>
                        <img id="thumb" style="width:100%; height:300px;" class="img-fluid"
                                src="https://www.pinclipart.com/picdir/middle/174-1745859_health-id-card-credencial-png-clipart.png"
                                alt="">
                        <label for="idcard_image">
                            <div class="btn btn-light position-absolute bg-primary text-white bold py-0 px-3 text-dark position-absolute" style="top:0; right:20px;">Upload</div>
                        </label>
                        <input id="idcard_image" type="file" class="d-none"  onchange="preview()" id="input-avatar">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
          <button class="btn btn-secondary" id="btnAddNewReseller" type="button">Save changes</button>
        </div>
      </div>
    </div>
</div>

{{-- Will be sent from PHP to Javascript --}}
<input type="hidden" id="baseURL" value="{{$baseURL}}">
@endsection

@section('script')
<script>
    // Preview Image
    function preview() {
        thumb.src=URL.createObjectURL(event.target.files[0])
    }

    // Datatable
    $(function(){
        $('#reseller-datatable').DataTable({
            ajax: {
                url : '{{$baseURL.'reseller-datatable'}}',
                "headers": {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'national_id', name: 'national_id'},
                { data: 'address', name: 'address'},
                { data: 'action', name: 'action'},
            ],
            language: {
            searchPlaceholder: 'Search by : Master number, AWB/SMU Number',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },

            "order": [[ 0, "desc" ]],
            columnDefs:[
                {
                    "targets" : [1,3],
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

    // Add New Reseller
    $('#btnAddNewReseller').click(function(){
        let validating = 3
        let execute = false
        var name = $('#name')
        var national_id = $('#national_id')
        var address = $('#address')
        var idcard_image = document.getElementById('idcard_image')
        let validate = [name, national_id, address]
        for(let i=0; i<validate.length; i++){
            if($(validate[i]).val().length < 1){
                $(validate[i]).addClass('is-invalid').attr('title', 'Cannot be empty')
                validating--
            }else{
                $(validate[i]).removeClass('is-invalid').attr('title', 'Validated')
                validating++
            }
        }
        if(validate == 6)
            execute = true
        if(!idcard_image.files[0]){
            $('#thumb').css({'border':'solid 3px red'})
            execute = false
        }else{
            execute = true
        }
        if(execute){
            var formData = new FormData()
            formData.append('idcard_image', idcard_image.files[0])
            formData.append('name', $(name).val())
            formData.append('address', $(address).val())
            formData.append('national_id', $(national_id).val())
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                url: $('#baseURL').val()+'reseller-regist',
                headers: {
                            "Authorization": "Bearer "+"{{Session::get('CheckAuth')['token']}}"
                        },
                data: formData,
                success:function(response){
                    if(response['error'] == false)
                        document.location.href = '{{url('reseller/reseller-data')}}'
                }
            })
        }

    })

</script>
@endsection
