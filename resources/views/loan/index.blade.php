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
                            <a class="nav-link"  href="{{ route('sells.index') }}"><span class="now-ui-icons design_shape-circle" style=""></span> {{__('messages.tabsells_sells')}}</a>
                          </li>
                          <li class="nav-item linkpaging">
                            <a class="nav-link " href="{{ route('cotation.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span> {{__('messages.tabsells_cotation')}}</a>
                          </li>
                          @if(\Session::has('level'))
                          @if(\Session::get('level') == 2 OR \Session::get('level') == 1)
                          <li class="nav-item linkpaging">
                            <a class="nav-link active" href="{{ route('loan.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>

                                @if (Session::exists('totalloans'))

                                    <span class="badge badge-danger">{{ Session::get('totalloans') }}</span>

                                @endif
                                {{__('messages.tabsells_loan')}}

                           </a>
                          </li>
                          <li class="nav-item linkpaging">
                            <a class="nav-link" href="{{ route('devolution.index') }}" ><span class="now-ui-icons design_shape-circle" style=""></span>

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
                      <div class="tab-pane" id="selling" role="tabpanel">

                      </div>
                      <div class="tab-pane active" role="tabpanel">

                        <div class="row col-lg-12 mt-3">

                          <div class="col-lg-6 col-md-6 col-sm-6 mt-3">

                            <div class="input-group no-border">

                              <input type="text" value="" class="form-control"  id="search_input_" onkeyup="searchTable()" placeholder=" {{__('messages.inputsearch_loan')}}">
                              
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <i class="now-ui-icons ui-1_zoom-bold"></i>
                                </div>
                              </div>
                            </div>

                          </div>                                                      

                        </div>
                        <div class=" col-lg-12">

                          <table class="table table-striped">
                                        
                            <thead>
                              <tr>
                                <th>ID</th>
                                <th>{{__('messages.sellscotationtable_reference')}}</th>
                                <th>{{__('messages._operatedby')}}</th>
                                <th>{{__('messages.sellstable_clientname')}}</th>
                                <th>{{__('messages.sellstable_clientid')}}</th>
                                <th>{{__('messages._moneytopay')}}</th>
                                <th>{{__('messages._debt')}}</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="hollowedtable">

                              @foreach($activeloans as $log)

                                <tr>
                                <td>{{$log->id}}</td>
                                <td>{{$log->reference}}</td>
                                <td>{{$log->operator}} </td>
                                <td>{{$log->clientname}}</td>
                                <td>{{$log->clientid}}</td>
                                <td>{{$log->moneytopay}}</td>
                                <td>{{$log->debt}}</td>
                                <td align="right">

                                  <button type="submit" data-toggle="tooltip" data-placement="left" title=" {{__('messages.loanstable_logsstips')}}" class="btn btn-round btn-xs mr-1"  onclick=" showloanlogs({{$log->id}})"><span class="now-ui-icons design_bullet-list-67"></span> </button>
                                  <button  data-toggle="tooltip" data-placement="left" title="{{__('messages.loanstable_paymenttips')}}" class="btn btn-round btn-xs mr-1" onclick=" updateloanpayment({{$log->id}})"><span class="now-ui-icons ui-1_edit-74"></span> </button>
                                </td>
                              </tr>

                              @endforeach
                                            
                            
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

<script type="text/javascript">
  
    function showloanlogs(id_loan) {

        var _token = $('input[name="_token"]').val();
                      
        $.ajax({
                
            url: 'loan/showlogs/' + id_loan,
            type: 'GET',
            success: function(data){           
                          
                $.dialog({
                    icon: '',
                    closeIcon: true,
                    title: '',
                    columnClass: 'col-lg-6 justify-content-center',
                    content: ' ' + data,
                    buttons: { 

                          },

                    onContentReady: function (e) {
                        

                        $('.jconfirm-holder').css({"position" : 'absolute', "top": 0, "right": 0, "width" : "100%"});

                        newobj.setColumnClass(' ');



                    }

                });

             },
                                      
            error: function(xhr, desc, err) {
                          
                showError('Please contact the Administrator');   
                          
                console.log(xhr);
                console.log('Details ' +desc);
                                  
            }

        });

    } 

    function updateloanpayment(id_loan) {

        newobj = $.dialog({
            icon: '',
            closeIcon: true,
            columnClass: 'col-lg-5 justify-content-center',
            content: "<div class='row col-lg-12'><div class='input-group'><label for='paidvalue'>{{ __('messages._paidvalue')}}:</label><input type='text' onchange='pay("+id_loan+")' class='form-control' name='paidvalue' value='' id='paidvalue'/></div>",
            buttons: { 

            },

            onContentReady: function (e) {
                            
                $('.jconfirm-holder').css({"position" : 'absolute', "top": 0, "right": 0, "width" : "100%"});

                

                newobj.setColumnClass(' ');

            }

        });

    } 

    function pay(id_loan) {

        var _token = $('input[name="_token"]').val();
        var money = $('input[name="paidvalue"]').val();
                                
        $.ajax({
                            
            url: 'loan/pay/' + id_loan + '/' + money,
            type: 'GET',
            dataType: 'json',
            success: function(data){           
                                      
                if (data.code == 1) {

                    showPush(data.message);

                    location.reload();

                }  else {

                    showError(data.message);

                }       

            },
                                                  
            error: function(xhr, desc, err) {
                                      
                showError('Please contact the Administrator');   
                                      
                console.log(xhr);
                console.log('Details ' +desc);
                                              
            }

        });

    }

</script>