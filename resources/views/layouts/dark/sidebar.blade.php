<header class="main-nav ">
    <div class=""><a href=""><img class="img-fluid ml-4 mt-2" src="{{asset('assets/images/kedeikoko-logo.png')}}" alt=""></a></div>
    <div class="logo-icon-wrapper"><a href=""><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
    <nav>
      <div class="main-navbar">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="mainnav">
          <ul class="nav-menu custom-scrollbar">
            <li class="back-btn">
              <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
            </li>
            <li class="dropdown">
              <a  class="nav-link menu-title {{ in_array(Route::currentRouteName(), ['index']) ? 'active' : '' }}" href="{{route('index')}}"><i data-feather="home"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
                <a href="{{route('orders')}}" class="nav-link menu-title {{request()->route()->getPrefix() == '/order' ? 'active' : '' }}" href="#"><i data-feather="file-text"></i><span>Data Penjualan</span></a>
              </li>
            {{-- <li class="dropdown">
              <a class="nav-link menu-title {{request()->route()->getPrefix() == '/supplier' ? 'active' : '' }}" href="#"><i data-feather="file-text"></i><span>Supplier</span>
                  <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/supplier' ? 'down' : 'right' }}"></i></div>
              </a>
              <ul class="nav-submenu menu-content" style="display: {{request()->route()->getPrefix() == '/supplier' ? 'block;' : 'none;' }}">
                <li>
                  <a href="{{route('supplier-data')}}" class="submenu-title {{ in_array(Route::currentRouteName(), ['supplier-data']) ? 'active' : '' }}" href="">Supplier Data
                  </a>
                </li>
              </ul>
            </li> --}}
            <li class="dropdown">
              <a class="nav-link menu-title {{request()->route()->getPrefix() == '/reseller' ? 'active' : '' }}" href="{{route('reseller-data')}}"><i data-feather="users"></i><span>Reseller</span></a>
            </li>
            <li class="dropdown">
              <a class="nav-link menu-title {{request()->route()->getPrefix() == '/products' ? 'active' : '' }}" href="{{route('product-setting')}}"><i data-feather="target"></i><span>Manajemen Produk</span></a>
            </li>
            <li class="dropdown">
              <a class="nav-link menu-title {{request()->route()->getPrefix() == '/financial' ? 'active' : '' }}" href="#"><i data-feather="dollar-sign"></i><span>Keuangan</span>
                  <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/financial' ? 'down' : 'right' }}"></i></div>
              </a>
              <ul class="nav-submenu menu-content" style="display: {{request()->route()->getPrefix() == '/financial' ? 'block;' : 'none;' }}">
                <li>
                  <a href="{{route('bank-account-info')}}" class="submenu-title {{ in_array(Route::currentRouteName(), ['bank-account-info']) ? 'text-active' : '' }}" href="">Rekening Bank
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </div>
    </nav>
</header>
