@extends('base')

@section('main')

<div class="wrapper ">
  <div class="sidebar" data-color="orange">
  <!--
          
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      
  -->
  <div class="logo">
          
    <a href="#" class="simple-text logo-mini">
              
      <img src="{{ asset('img/favicon.png') }}?>" alt="logo">
          
    </a>
    <a href="#" class="simple-text logo-normal">
            geston
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav mainnav">

      <li id="estatisticas">
        <a href="{{ route('report.index') }}">
          <i class="now-ui-icons business_chart-bar-33"></i>
          <p>Reports</p>
        </a>
      </li>
      <li id="materials">
        <a href="{{ route('products.index') }}">
          <i class="now-ui-icons shopping_bag-20"></i>
          <p>Products</p>
        </a>
      </li>
      <li id="usuarios">
        <a href="{{ route('users.index') }}">
                
          <i class="now-ui-icons users_multiple-11"></i>
          <p>Usuarios</p>
              
        </a>
      </li>
      <li id="clientes">
        <a href="{{ route('clients.index') }}">
                
          <i class="now-ui-icons users_mobile-contact"></i>
          <p>Clientes</p>
              
        </a>
      </li>
      <li id="entries">
        <a href="{{ route('entries.index') }}">
          <i class="now-ui-icons education_books-46"></i>
          <p>Entradas</p>
        </a>
      </li>
      <li id="sells" class="active">
        <a href="{{ route('sells.index') }}">
          <i class="now-ui-icons arrows-1_share-66"></i>
          <p>Vendas</p>
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
                  <a class="nav-link disabled" href="#">
                    <i class="now-ui-icons shopping_cart-simple"></i>
                    <span class="badge badge-danger">0</span>
                    <p>
                      <span class="d-lg-none d-md-block">Carrinha</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link disabled" href="#">
                    <i class="now-ui-icons ui-1_bell-53"></i>
                    <span class="badge badge-danger">0</span>
                    <p>
                      <span class="d-lg-none d-md-block">Notificacao</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                    <a id="losettings" onclick="#">
                      <i class="">
                          
                          <img src="{{ asset('img/default-avatar.png') }} ?>" class="img-circle" width="40" height="40"/>
                          
                      </i>
                    <p>
                      <span class="d-lg-none d-md-block">Users</span>
                    </p>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
        <div class="panel-header panel-header-sm">

        </div>
        <div class="content">

            <div class="row">
              <div class="col-lg-12">
                <div class="card">

                  <div class="card-body col-lg-12">

                    <div class="nav-tabs-navigation">
                      <div class="nav-tabs-wrapper">
                        <ul id="usertabs" class="nav nav-tabs" role="tablist">
                          <li class="nav-item linkpaging">
                            <a class="nav-link"  href="{{ route('sells.index') }}"><span class="now-ui-icons design_shape-circle" style=""></span> Sells</a>
                          </li>
                          <li class="nav-item linkpaging">
                            <a class="nav-link active" href="{{ route('sells/cotation') }}" ><span class="now-ui-icons design_shape-circle" style=""></span> Cotation</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div id="" class="tab-content text-center">
                      <div class="tab-pane" id="selling" role="tabpanel">

                      </div>
                      <div class="tab-pane active" id="cots" role="tabpanel">

                        <div class="row col-lg-12 mt-3">

                                                      

                        </div>
                        <div class=" col-lg-12">

                          <table class="table table-striped">
                                        
                            <thead>
                              <tr>
                                <th>ID</td>
                                <th>Description</th>
                                <th>Unit price</th>
                                <th>Quantity</th>
                                <th>Sub total</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="hollowedtable">
                                            
                            
                            </tbody>
                          </table>

                        </div>
                        <div class="row col-lg-12 paginacao justify-content-center" id="paginacao_tabela"></div>

                      </div>

                      </div>

                  </div>

                </div>
              </div>
            </div>
          
        
        </div>
        {{ csrf_field() }}
@endsection