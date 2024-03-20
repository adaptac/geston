@extends('base')

@section('main')

<div class="wrapper ">
  <div class="sidebar" data-color="orange">
  <!--
          
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
      
  -->
  <div class="logo">
          
    <a href="#" class="simple-text logo-mini">
              
      <img src="{{ asset('public/img/favicon.png') }}?>" alt="logo">
          
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

                    <span class="badge badge-danger" id="countcart">{{ count(Session::get('cart')) }}</span>

                    @else

                    <span class="badge badge-danger" id="countcart">0</span>

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
                            <a class="nav-link active"  href="{{ route('sells.index') }}"><span class="now-ui-icons design_shape-circle" style=""></span>  {{__('messages.tabsells_sells')}}</a>
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
                            <a class="nav-link " href="{{ route('devolution.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>

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

                            <div class="col-lg-6 col-md- col-sm-6 mt-3">

                                <div class="input-group no-border">

                                  <input type="text" value="" class="form-control"  id="search_input_" onkeyup="fetchData('prods')" placeholder=" {{__('messages.inputsearch_products')}}">
                                  
                                  <div class="input-group-append">
                                    <div class="input-group-text">
                                      <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </div>
                                  </div>
                                </div>
                                <div id="productsList"  style="cursor: pointer; z-index: 10;position:relative;"></div>
                            </div> 
                            
                            <div class="col-lg-3 mt-3">
                        
                                <div class="input-group no-border">

                                    <input type="text" value="" class="form-control"  id="search_input_cli" onchange="fetchData('clients')" placeholder="{{__('messages.inputsearch_clients')}}">
                                            
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="now-ui-icons ui-1_zoom-bold"></i>
                                        </div>
                                    </div>
                                </div>                                

                            </div>  

                            <div class="col-lg-1 mt-2">
                              
                              
                              
                            </div> 
                            <div class="col-lg-2 mt-3">
                              <button type="button" data-toggle="dropdown" class="btn btn-default form-control dropdown-toggle disabled" style="background: #f96332;color: #fff;">{{__('messages.btn_processsell')}}</button>

                              <div class="dropdown-menu dropdown-menu-left" style="width: auto; padding: 5px;">
                                      
                                  <button type="button" class="dropdown-item" onclick="chooseInvoice()" style="cursor: pointer;"> {{__('messages.sells_sell')}}</button>     
                                  <button type="button" class="dropdown-item" onclick="processsloan()" style="cursor: pointer; text-decoration: none; "> {{__('messages.sells_loan')}}</button> 
                                  <button type="button" class="dropdown-item" onclick="showcotaion()" style="cursor: pointer; text-decoration: none; "> {{__('messages.processcotation_option')}}</button> 
                                      
                              </div>
                
                            </div> 


                        </div>
                        <div class=" col-lg-12">

                          <table class="table table-striped">
                                        
                            <thead>
                              <tr>
                                <th> {{__('messages.sellstable_id')}}</td>
                                <th> {{__('messages.sellstable_description')}}</th>
                                <th> {{__('messages.sellstable_unitprice')}}</th>
                                <th> {{__('messages.sellstable_quantity')}}</th>
                                <th> {{__('messages.sellstable_sobtotal')}}</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="hollowedtable">

                            	@if(count($carts) > 0 )

                            		@foreach($carts as $cart)

                            			<tr>
        								            <td>{{ $cart['id'] }}  </td>
        								            <td>{{ $cart['description'] }}</td>
        								            <td> {{ number_format($cart['price'], 2, '.', ',') }} </td>
        								            <td><input type='text' class='input-sm' id= '{{ $cart['id'] }}' value='{{ $cart['qty'] }}' onchange="updaterow({{ $cart['id'] }})" style='text-align:center;'></td>
        								            <td>{{ number_format($cart['sobtotal'], 2, '.', ',') }}</td>
        								            <td><button onclick="removerow({{ $cart['id'] }})" class="btn btn-round btn-xs mr-1" style="border-color:red; color:red;"><span class="now-ui-icons ui-1_trash"></span> </button></td>
        							            </tr>

                            		@endforeach

                            	@endif
                                            
                            
                            </tbody>
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
              <td>  {{__('messages.sellstable_clientname')}}:</td>
              <td id="forclientname">{{ Session::get('clientname') }}</td>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td>  {{__('messages.sellstable_sobtotal')}}(MZN): </td>
              <td id="fortotaliquido"> {{ number_format(Session::get('totaliquido'), 2, '.', ',') }}</td>
            </tr>
            <tr>
              <td>  {{__('messages.sellstable_clientcontacts')}}: </td>
              <td id="forclientcontact"> {{ Session::get('clientcontacts') }}</td>
              <td></td>
              <td> IVA(MZN): </td><td id="foriva"> {{ number_format(Session::get('iva'), 2, '.', ',') }}</td>
            </tr>
            <tr>
              <td>  {{__('messages.sellstable_clientid')}}: </td>
              <td  id="forclientdocid"> {{ Session::get('clientdocid') }}</td>
              <td></td>
              <td style="font-size: 15pt; font-style: normal;">  {{__('messages.sellstable_total')}}(MZN): </td>
              <td style="font-size: 15pt;" id="fortotal"> {{ number_format(Session::get('total'), 2, '.', ',') }}</td>
            </tr>

        </table>
        <script type="text/javascript">

          var searcher = document.getElementById('search_input_');
          searcher.focus();

          function processsell() {

              var _token = $('input[name="_token"]').val();

              var invoicetype = $('#invoicetype').val();

              var url = "{{route('sells.generatepdf', 0)}}";

              if (invoicetype == 1) {

                  url = "{{route('sells.generatepdf', 1)}}";

              }

              $('.splash').fadeIn(100);
              $.ajax({
              url: url,
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

            function chooseInvoice() {

                newobj = $.dialog({
                    icon: '',
                    closeIcon: true,
                    title: '<span class="now-ui-icons design_shape-circle" style=""></span> ' ,
                    columnClass: 'container row col-lg-5 justify-content-center',
                    content: "<div class='col-lg-12'><div class='input-group'><label for='paidvalue'>{{ __('messages._paidvalue')}}:</label><input type='text' onchange='showChanges()' class='form-control' name='paidvalue' value='' id='paidvalue'/></div><span id='changescontent' class=''><form method='get'  action='' class=' row col-lg-12 mt-3' id = 'processsell_form'></form></span>",
                    buttons: { 

                          },

                    onContentReady: function (e) {
                        

                        $('.jconfirm-holder').css({"position" : 'absolute', "top": 0, "right": 0, "width" : "100%"});

                        var paider = document.getElementById('paidvalue');
                        paider.focus();

                        newobj.setColumnClass(' ');



                    }

                });

            }

            $(document).ready(function(){

                $('[data-toggle="switch"]').bootstrapSwitch();

            });

            $('input[name="foreng"]').on('switchChange.bootstrapSwitch', function(event, state){
    
                var newlang = navigator.language.split('-')[0];

                alert(newlang);

                if (newlang === 'pt') {
                    
                    newlang = "en";
                    
                } else {

                    newlang = 'pt';

                }

                var _token = $('input[name="_token"]').val();

                $.ajax({

                    url: "users/changelan/" +newlang,
                    headers:{

                    'X-CSRF-TOKEN' : _token

                    },
                    method:"get",
                    data:{},
                    success:function(data){


                       location.reload();

                     }
                });
                
            });

            $(document).keydown(function(e){

              if (e.shiftKey) {

                switch(e.keyCode) {

                  case 67:

                    @if(Session::exists('cart') AND count(Session::get('cart')) > 0)

                      showcotaion();

                    @endif

                  break;
                  case 86:

                    @if(Session::exists('cart') AND count(Session::get('cart')) > 0)

                      chooseInvoice();

                    @endif

                  break;

                }

              }


            });

          function updatetotal() {

            var _token = $('input[name="_token"]').val();

            $.ajax({

                  url: "sells/updatetotal",
                  method:"GET",
                  dataType: 'json',
                  data:{_token:_token},
                  success:function(data){

                    $('#fortotal').html(data.comiva);
                    $('#foriva').html(data.iva);
                    $('#fortotaliquido').html(data.totaliquido);
                    $('span#countcart').text('' + data.countcart);


                    if (data.countcart > 0) {

                      $('.btn.btn-default.form-control.dropdown-toggle').removeClass('disabled');

                    } else {

                      $('.btn.btn-default.form-control.dropdown-toggle').addClass('disabled');

                    }

                    var firscol = $('td').find('input');

                    inputer = $('input#' + firscol.attr('id'));

                    if (inputer.attr('value') == 0 || inputer.attr('value') == '') {

                      
                      document.getElementById(firscol.attr('id')).value = '';
                   
                      inputer.focus();

                    } else {

                        var searcher = document.getElementById('search_input_');
                        document.getElementById('search_input_').value = '';
                        searcher.focus();

                    }

                  }
            });

          }
    
          function processsloan() {

            var _token = $('input[name="_token"]').val();
            $('.splash').fadeIn(100);
                      
            $.ajax({
                url: 'loan/generatepdf',
                type: 'GET',
                dataType: 'json',
                success: function(data){           
                          
                    window.open(data.url, "_new");

                    location.reload();


                },
                                      
                error: function(xhr, desc, err) {
                          
                    showError('Please contact the Administrator');   
                          
                    console.log(xhr);
                    console.log('Details ' +desc);
                                  
                  }

            });

          }

        </script>
        {{ csrf_field() }}
@endsection