<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
<!-- Font Awesome-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}">
<!-- ico-font-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}">
<!-- Themify icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/themify.css')}}">
<!-- Flag icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/flag-icon.css')}}">
<!-- Feather icon-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/feather-icon.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.css')}}">
<!-- Plugins css start-->
@yield('css')
<!-- Plugins css Ends-->
<!-- Bootstrap css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
<!-- App css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
<link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen">
<!-- Responsive css-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
<link rel="stylesheet" media="all" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!-- Custome RIAN DEVELOPER CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-rrrgho-dev.css')}}">
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button{
    padding: 6px;
    line-height: 20px;
    border:none;
    background:rgb(243, 45, 45) !important;
    color:#000 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #06f;
    color: black!important;
    border-radius: 4px;
    border: 1px solid #828282;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active {
    background: none;
    color: black!important;
    }

    .active{
        background: rgb(252,18,18) !important;
        background: linear-gradient(90deg, rgba(252,18,18,1) 0%, rgba(255,231,0,1) 100%) !important;
    }

    .text-active{
        color:#ffe700 !important;
    }
</style>
