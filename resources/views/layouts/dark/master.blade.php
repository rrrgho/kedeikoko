<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('assets/images/kedeikoko.png')}}" type="image/x-icon">
    <title>Kedei Koko</title>
    @include('layouts.dark.css')
    @yield('style')
  </head>
  <body class="dark-only" main-theme-layout="ltr">
    <!-- Loader starts-->
    {{-- <div class="loader-wrapper">
      <div class="loader-index"><span></span></div>
      <svg>
        <defs></defs>
        <filter id="goo">
          <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
          <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">    </fecolormatrix>
        </filter>
      </svg>
    </div> --}}
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      @include('layouts.dark.header')
      <!-- Page Header Ends  -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper sidebar-icon">
        <!-- Page Sidebar Start-->
        @include('layouts.dark.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-header">
              <div class="row">
                <div class="col-lg-6">
                  @yield('breadcrumb-title')
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""><i data-feather="home"></i></a></li>
                    @yield('breadcrumb-items')
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('layouts.dark.footer')
      </div>
    </div>

    {{-- Floating Main Button --}}
    <div class="order" onclick="getOrderForm()" data-toggle="modal" data-target="#addNewOrder">
        <i class="fa fa-pencil"></i>
    </div>
    {{-- Modal Add New Order --}}
    <div class="modal fade" id="addNewOrder" tabindex="-1" role="dialog" aria-labelledby="addNewOrderLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addNewOrderLabel">Tambah Order Baru</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="order-form">

            </div>
        </div>
        </div>
    </div>
    @include('layouts.dark.script')
    @if(session('success'))
    <script>alertSuccess('{{session('success')}}')</script>
    @endif
    @if(session('failed'))
    <script>alertFailed('{{session('failed')}}')</script>
    @endif
  </body>
</html>
<script>
    let getOrderForm = () =>{
        $.ajax({
            url: '{{route('get-order-form')}}',
            type: 'GET',
            success:function(response){
                $('#order-form').html(response)
                $('#url').val('{{Request::url()}}')
                $('#reseller_id').on('change', function(){
                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        url: '{{route('get-customer')}}',
                        type: 'POST',
                        data: {
                            reseller_uid : $(this).val()
                        },
                        success:function(response){
                            $('#customer').html(response)
                        }
                    })
                })
            }
        })
    }
</script>
