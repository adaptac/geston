@extends('base')

@section('main')

<div class="wrapper ">
  <div class="sidebar" data-color="orange">
  <!--
          
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      
  -->
  <div class="logo">
          
    <a href="#" class="simple-text logo-mini">
              
      <img src="{{ asset('/img/favicon.png') }}?>" alt="logo">
          
    </a>
    <a href="#" class="simple-text logo-normal">
            geston lab
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav mainnav">
      @if(\Session::has('level'))
      @if(\Session::get('level') == 1)
      <li id="estatisticas">
        <a href="{{ route('report.index') }}">
          <i class="now-ui-icons business_chart-bar-33"></i>
          <p>{{__('messages.btn_report')}}</p>
        </a>
      </li>
      @endif
      @endif
      @if(\Session::has('level'))
      @if(\Session::get('level') == 2 OR \Session::get('level') == 1)
      <li id="materials">
        <a href="{{ route('products.index') }}">
          <i class="now-ui-icons shopping_bag-20"></i>
          <p>{{__('messages.btn_products')}}</p>
        </a>
      </li>
      @endif
      @endif
      @if(\Session::has('level'))
      @if(\Session::get('level') == 1)
      <li id="usuarios">
        <a href="{{ route('users.index') }}">
                
          <i class="now-ui-icons users_multiple-11"></i>
          <p>{{__('messages.btn_users')}}</p>
              
        </a>
      </li>
      @endif
      @endif
      <li id="clientes">
        <a href="{{ route('clients.index') }}">
                
          <i class="now-ui-icons users_mobile-contact"></i>
          <p>{{__('messages.btn_clients')}}</p>
              
        </a>
      </li>
      @if(\Session::has('level'))
      @if(\Session::get('level') == 2 OR \Session::get('level') == 1)
      <li id="entries">
        <a href="{{ route('entries.index') }}">
          <i class="now-ui-icons education_books-46"></i>
          <p>{{__('messages.btn_entries')}}</p>
        </a>
      </li>
      @endif
      @endif
      <li id="sells">
        <a href="{{ route('sells.index') }}">
          <i class="now-ui-icons arrows-1_share-66"></i>
          <p>{{__('messages.btn_sells')}}</p>
        </a>
      </li>
      
    </ul>
  </div>
</div>
<div class="main-panel" id="principal">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-bar navbar-kebab"></span>
              <span class="navbar-toggler-bar navbar-kebab"></span>
              <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <ul class="navbar-nav mainnav" id="mainnav">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('sells.index') }}">
                    <i class="now-ui-icons shopping_cart-simple"></i>

                    @if (Session::exists('cart'))

                    <span class="badge badge-danger">{{ count(Session::get('cart')) }}</span>

                    @else

                    <span class="badge badge-danger">0</span>

                    @endif

                    <p>
                      <span class="d-lg-none d-md-block">{{__('messages.btn_cart')}}</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="{{route('notification.index') }}">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <span class="badge badge-danger">{{Session::get('notificationcount') ?? 0}}</span>
                    <p>
                      <span class="d-lg-none d-md-block">{{__('messages.btn_notifications')}}</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                    <span id="losettings">
                      <i class="dropdown">
                          
                            @if(Session::exists('username'))

                                <img src="{{ Session::get('perfil_photo') }}" class="img-circle dropdown-toggle" data-toggle="dropdown" width="40" height="40"/>

                            @else

                                <img src="{{ asset('img/default-avatar.png') }} ?>" class="img-circle dropdown-toggle" data-toggle="dropdown" width="40" height="40"/>

                            @endif
                            <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">
                                
                                <div class="row pb-0">

                                        <div class="col-lg-4">

                                            <div class="m-2" style="width:80px; height:80px;">

                                                <img src= "{{ Session::get('perfil_photo') }}" width="100%" height="100%" title=""/>

                                            </div>

                                        </div>
                                        <div class="col-lg-8">

                                            <p style="font-size:11px; vertical-align: middle;" class="p-0 mt-3"><b>{{ Session::get('username') }}</b></br>
                                            <span style="font-size:11px; margin-top:0; padding-top:0;font-weight: normal;"><i>{{ Session::get('useremail') }}</i></span></p>

                                        </div>

                                    </div>
                                <div class="row p-3 pb-0 pt-0">

                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <a id="logout" class="btn btn-outline-danger btn-round form-control btn-sm" style="font-size:11px;" href="users/logout" ><i class="now-ui-icons media-1_flash-off-23"></i> {{__('messages.btn_logout')}}</a>

                                        </div>

                                    </div>
                                
                            </div>
                          
                      </i>
                    <p>
                      <span class="d-lg-none d-md-block">{{__('messages.btn_user')}}</span>
                    </p>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">

        </div>
        <div class="content">

          <div class="tabbody container m-0 p-0 card" data-istable="false"><!--Seccao -->
            <div class="row col-lg-12 mt-3">
              <div class=" col-lg-12">

                <table class="table table-striped">

                  <tbody id="hollowedtable">

                    <tr>
                      <th>NOTIFICATIONS</th>
                    </tr>
                                  
                  @foreach($notifications as $notification)
                    <tr>
                      
                        <td style="font-size:12px; vertical-align: middle;"><span class="now-ui-icons ui-1_bell-53 p-1" style="font-size:16px;" ></span> The {{$notification->object}} {{$notification->name}} {{$notification->state}}</td>

                    </tr>
                  @endforeach
                  </tbody>
                </table>

              </div>
              <div class="row col-lg-12 paginacao justify-content-center" id="paginacao_tabela"></div>

            </div>
              
          </div><!--Fim da seccao-->
          
        
        </div>
@endsection