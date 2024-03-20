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
      <li id="materials" class="active">
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
      <li id="entries">
        <a href="{{ route('entries.index') }}">
          <i class="now-ui-icons education_books-46"></i>
          <p>Entradas</p>
        </a>
      </li>
      <li id="sells">
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
                      <span class="d-lg-none d-md-block">Usuario</span>
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

          <div id="usuario" class="tabbody container m-0 p-0 card"  data-pagination-number="4" data-istable="false"><!--Seccao para visualizacao de resusltado de pesquisa no sistema-->
            <div class="row col-lg-12 mt-3">

              <div class="col-lg-6 col-md-6 col-sm-6 mt-3">

                <div class="input-group no-border">

                  <input type="text" value="" class="form-control"  id="search_input_" onkeyup="searchTable()" placeholder="Search...">
                  
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                    </div>
                  </div>
                </div>

                <div id="userList" class="ml-3 col-lg-6 col-sm-6">
              </div>

              </div>
              
                
                <div class="col-lg-4 col-md-4 col-sm-4">

                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">

                  <div class="form-group">

                    <label for=""></label>
                    <button type="button"  onclick="getForm('users', null);" class="btn form-control" style="background: #f96332; color: #fff; font-size: 14px;"><span class="now-ui-icons ui-1_circle-add"></span> adicionar</button>

                  </div>

                </div>

              </div>
              <div class=" col-lg-12">

                <table class="table table-striped">
                              
                  <thead>
                    <tr>
                      <th>ID</td>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Telemovel</th>
                      <th>Username</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="hollowedtable">
                                  
                  @foreach($usuarios as $usuario)
                    <tr>
                      <td>{{$usuario->id}}</td>
                      <td>{{$usuario->nome_completo}} </td>
                      <td>{{$usuario->email}}</td>
                      <td>{{$usuario->telemovel}}</td>
                      <td>{{$usuario->username}}</td>
                      <td align="right">
                        <button  data-toggle="tooltip" data-placement="left" title="click here to view user details" class="btn btn-round btn-xs mr-1" onclick="getDetails('users', {{$usuario->id}})"><span class="now-ui-icons design_bullet-list-67"></span> </button>

                        @csrf
                        @method('DELETE')
                        <button  data-toggle="tooltip" data-placement="left" title="click here to remove user data" class="btn btn-round btn-xs mr-1" onclick="confirmRemotion('users', {{$usuario->id}})" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button>
                        <button  data-toggle="tooltip" data-placement="left" title="click here to edit user data" class="btn btn-round btn-xs mr-1" onclick="getForm('users', {{$usuario->id}})"><span class="now-ui-icons ui-1_edit-74"></span> </button>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>

              </div>
              <div class="row col-lg-12 paginacao justify-content-center" id="paginacao_tabela"></div>

            </div>

            {{ csrf_field() }}
              
            <script type="text/javascript"> var msg = '';</script>
              @if(session()->get('success'))
              <script>

                msg = "{{ session()->get('success') }}";

              </script> 
              @endif

              
          </div><!--Fim da seccao-->
          
        
        </div>
@endsection