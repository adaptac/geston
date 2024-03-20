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
      <li id="sells" class="active">
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
        <div class="panel-header panel-header-sm justify-content-center">

          

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
                            <a class="nav-link"  href="{{ route('sells.index') }}"><span class="now-ui-icons design_shape-circle" style=""></span>  {{__('messages.tabsells_sells')}}</a>
                          </li>
                          <li class="nav-item linkpaging">
                            <a class="nav-link" href="{{ route('cotation.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>  {{__('messages.tabsells_cotation')}}</a>
                          </li>
                          @if(\Session::has('level'))
                          @if(\Session::get('level') == 2 OR \Session::get('level') == 1)
                          <li class="nav-item linkpaging">
                            <a class="nav-link " href="{{ route('loan.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>

                                @if (Session::exists('totalloans'))

                                    <span class="badge badge-danger">{{ Session::get('totalloans') }}</span>

                                @endif
                                {{__('messages.tabsells_loan')}}

                           </a>
                          </li>
                          <li class="nav-item linkpaging">
                            <a class="nav-link active" href="{{ route('devolution.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>

                                @if (Session::exists('totaldevolutio'))

                                    <span class="badge badge-danger">{{ count(Session::get('totaldevolutio')) }}</span>

                                @endif

                              {{__('messages.tabsells_devolution')}}

                            </a>
                          </li>
                          @endif
                          @endif
                        </ul>
                      </div>
                    </div>
                    <div id="" class="tab-content text-center">
                      <div class="tab-pane active" id="selling" role="tabpanel">

                        <div class="row col-lg-12 mt-3">

                            <div class="col-lg-4 col-md- col-sm-6 mt-3">

                                <div class="input-group no-border">

                                  <input type="text" value="" class="form-control"  name="search_input_" onchange="fetchInvoice()" placeholder=" {{__('messages.inputsearch_invoice')}}">
                                  
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </div>
                                  </div>
                                </div>
                            </div> 
                            
                            <div class="col-lg-3 mt-3">
                        
                                                               

                            </div>   
                            <div class="col-lg-3 mt-3">

                              @if(Session::has('devolutionreference'))
                              <button type="button" class="btn btn-default form-control" style="background: #f96332;color: #fff;" onclick="showdevolution()">__('messages.btn_printreport')</button>
                              @endif
                            </div> 


                        </div>
                        <div class=" col-lg-12">

                          <table class="table table-striped">
                                        
                            <thead>';

                                <th>ID</th>
                                <th>{{__('messages._operatedby')}}</th>
                                <th>{{__('messages.sellstable_clientname')}}</th>
                                <th>{{__('messages.sellstable_clientid')}}</th>
                                <th>{{__('messages._productdescription')}}</th>
                                <th>{{__('messages._systemqty')}}</th>
                                <th>{{__('messages._takenbackqty')}}</th>
                                <th>{{__('messages._payback')}}</th>
                                <th></th>

                            </thead>
                            @if(Session::has('devolutionreference') )
                            <tbody id="hollowedtable">

                            	@if(count($carts) > 0 )

                            		@foreach($carts as $cart)

                            			<tr>
        								            <td>{{ $cart['id'] }}  </td>
                                    <td>{{ $cart['operator'] }}  </td>
                                    <td>{{ $cart['clientname'] }}  </td>
                                    <td>{{ $cart['clientid'] }}  </td>
        								            <td>{{ $cart['description'] }}</td>
        								            <td> {{ $cart['systemqty'] }} </td>
        								            <td><input type='text' class='input-sm' name='takebackqty' id= '{{ $cart['productsid'] }}' value='0' onchange="takeback({{ $cart['idsells'] }}, {{ $cart['productsid'] }},{{ $cart['unitprice'] }})" style='text-align:center;'></td>
        								            <td>{{ $cart['takeback'] }}</td>
        								            <td><button onclick="takebackall({{ $cart['idsells'] }}, {{ $cart['productsid'] }},{{ $cart['unitprice'] }})" title=" {{__('messages.devolutionstable_backalltips')}}" class="btn btn-round btn-xs mr-1" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button></td>
        							            </tr>

                            		@endforeach

                            	@endif                
                            
                            </tbody>
                            @endif
                          </table>

                        </div>
                        <div class="row col-lg-12 paginacao justify-content-center" id="paginacao_tabela"></div>

                      </div>

              
                    </div><!--Fim da seccao-->

                      </div>
                      <div class="tab-pane" id="cots" role="tabpanel">

                        <div class="row col-lg-12 mt-3">

                        </div>
                        <div class="row col-lg-12">

                            

                        </div>
                        <div class="row col-lg-12 paginacao justify-content-center" id=""></div>

                      </div>

                      </div>

                  </div>

                </div>
              </div>
            </div>
          
        
        </div>
        <table cellpadding="3" style="position: absolute; top: 20px; left: 600px; color: white;">
             
            <tr>
              <td></td>
              <td style="font-size: 15pt; font-style: normal;">  {{__('messages._paybacktotal')}}(MZN): </td>
              <td style="font-size: 15pt;" id="fortotal"> {{ number_format(Session::get('devolutiontotal') ?? 0, 2, '.', '') }}</td>
            </tr>

        </table>
        <script type="text/javascript">

          function fetchInvoice() {

            var _token = $('input[name="_token"]').val();

            var reference = $('input[name="search_input_"]').val();
                      
            $.ajax({
                url: 'devolution/findcart/' + reference +'/true',
                type: 'GET',
                success: function(data){           
                          
                    location.reload();

                },
                                      
                error: function(xhr, desc, err) {
                          
                    showError('Please contact the Administrator');   
                          
                    console.log(xhr);
                    console.log('Details ' +desc);
                                  
                  }

            });

          }

          function takebackall(id_sells, id_product, unitprice) {

              var _token = $('input[name="_token"]').val();

              var qty = $('#' + id_product ).val(); 
                      
              $.ajax({

                  url: 'devolution/takebackall/' + id_sells + '/' + id_product + '/' + unitprice,
                  type: 'GET',
                  dataType: 'json',
                  success: function(data){           
                            
                      $('#hollowedtable').html(data.rows);
                      $('#fortotal').html(data.total);
                      setTimeout(function(){

                          $("#paginacao_tabela").jPages({   
                                  
                              containerID : "hollowedtable",
                              previous : "←",
                              next : "→",
                              perPage : 10,
                              delay : 50
                          });

                        }, 50);

                  },
                                        
                  error: function(xhr, desc, err) {
                            
                      showError('Please contact the Administrator');   
                            
                      console.log(xhr);
                      console.log('Details ' +desc);
                                    
                    }

              });

          }

          function takeback(id_sells, id_product, unitprice) {

              var _token = $('input[name="_token"]').val();

              var qty = $('input[name="takebackqty"]').val(); 
                      
              $.ajax({

                  url: 'devolution/takeback/' + id_sells +'/'+ id_product +'/'+ unitprice + '/' + qty,
                  type: 'GET',
                  dataType: 'json',
                  success: function(data){           
                            
                      $('#hollowedtable').html(data.rows);
                      $('#fortotal').html(data.total);
                      setTimeout(function(){

                          $("#paginacao_tabela").jPages({   
                                  
                              containerID : "hollowedtable",
                              previous : "←",
                              next : "→",
                              perPage : 10,
                              delay : 50
                          });

                        }, 50);

                  },
                                        
                  error: function(xhr, desc, err) {
                            
                      showError('Please contact the Administrator');   
                            
                      console.log(xhr);
                      console.log('Details ' +desc);
                                    
                    }

              });

          }

          function showdevolution(){

            $('.splash').fadeIn(100);
              
              $.ajax({
                                 
                  url: 'devolution/generatepdf',
                  type: 'GET',
                  dataType: 'json',
                  success: function(data){ 
                      
                      window.open(data.url, "_new");

                      location.reload(); 

                  },
                                  
                  error: function(xhr, desc, err) {
                      
                      showError('Um problema na insersacao de dados, se persistir contacto o administrador');   
                      
                      console.log(xhr);
                      console.log('Details ' +desc);
                              
                  }
                                   
              });
              
          }

        </script>
        {{ csrf_field() }}
@endsection