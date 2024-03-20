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
      <li id="estatisticas" class="active">
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
        <div class="panel-header panel-header-lg">

          <canvas id="mainChart" class=""></canvas>

        </div>
        <div class="content">

            <div class="row">
              <div class="col-lg-12">
                <div class="card">

                  <div class="card-body col-lg-12">

                    <form name="relatorio_tipo">

                    <div class="row">

                        <div class="col-lg-5 mb-3">

                            <select name="filtro_relatorio"  onchange="previewTable();" id="filtro_relatorio" title="{{__('messages.report_title')}}" data-style="btn-primary" class="selectpicker form-control">

                              <option value="maps"> {{__('messages.maps_option')}}</option>
                              <option value="currentsells"> {{__('messages.currentsells_option')}}</option>
                              <option value="sells"> {{__('messages.sells_option')}}</option>
                              <option value="loans"> {{__('messages.loans_option')}}</option>
                              <option value="devolutions"> {{__('messages.devolutions_option')}}</option>
                              <option value="entries"> {{__('messages.entries_option')}}</option>
                              <option value="products"> {{__('messages.products_option')}}</option>
                              <option value="negativeprods"> {{__('messages.negativeproducts_option')}}</option>
                              <option value="users"> {{__('messages.users_option')}}</option>
                              <option value="clients"> {{__('messages.clients_option')}}</option>

                            </select>

                        </div>

                        <div class="col-lg-5">
                            
                            <div class="row ">

                                <div class="form-group col-lg-3 col-sm-3 col-md-3 col-xs-12 pl-1 forano d-none">

                                    <div class="m-0 p-0" style="font-size:12px; height:12px;">{{__('messages.year_filter')}}</div>
                                    <input type="number" id="de" value="&nbsp;" class="form-control input-sm"  onchange="previewTable();"/>
                                          
                                </div>
                                <div class="form-group col-lg-3 col-sm-3 col-md-3 col-xs-12 p-0 pl-1 forate d-none">

                                    <div class="m-0 p-0" style="font-size:12px; height:12px;">{{__('messages.toyear_filter')}}:</div>
                                    <input type="number" id="a" value="&nbsp;" class="form-control input-sm" onchange="previewTable();" />

                                </div>
                                <div class="form-group col-lg-3 col-sm-3 col-md-3 col-xs-12 p-0 pl-1 formonth d-none">

                                    <div class="m-0 p-0" style="font-size:12px; height:12px;">{{__('messages.month_filter')}}</div>
                                    <input type="number" id="month" value="&nbsp;" class="form-control input-sm" onchange="previewTable();" />

                                </div>

                            </div>
                        </div>
                        
                        <div class="col-lg-2 mt-2">
                            
                            <div class="form-group">

                                <a href="report/printreport" type="button" target="_blank" class="form-control" style="color:#f96332; border-color: #f96332; text-align: center; text-decoration: none;"><span class="now-ui-icons ui-1_eye-17" style="margin-right: 4px;vertical-align: middle;"></span> {{__('messages.btn_printreport')}}</a>

                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-lg-6 col-sm-6 col-md-6 row ml-3">

                            <label class="contentor radio_forreport">{{__('messages.checkreport_general')}}
                                <input type="radio" checked="checked" value="geral" name="radio_invoice" id="relatorio_geral" onclick="justFilter(1)">
                              <span class="checkmark"></span>
                            </label>
                            <label class="contentor radio_forreport">{{__('messages.checkreport_from')}}
                              <input type="radio" name="radio_invoice" value ="doano" id="relatorio_do_ano" onclick="justFilter(2)">
                              <span class="checkmark"></span>
                            </label>
                            <label class="contentor radio_forreport">{{__('messages.checkreport_to')}}
                              <input type="radio" name="radio_invoice" value ="entre" id="relatorio_entre_anos" onclick="justFilter(3)">
                              <span class="checkmark"></span>
                            </label>

                        </div>

                    </div>

                  </form>
                  <div id="fortabelarelatorio" class="row col-lg-12 m-0 p-0" style="min-height: 100px;">
                    
                    
                    
                  </div>
                
                  <div class="row col-lg-12 paginacao justify-content-center" id="paginacao_tabela"></div

                  </div>

                </div>
              </div>
            </div>
        <script type="text/javascript">

          function justFilter(purps) {

              switch(purps) {

                case 1:

                  $('.forano').addClass('d-none');
                  $('.forate').addClass('d-none');
                  $('.formonth').addClass('d-none');

                break;

                case 2:

                  $('.forate').addClass('d-none');
                  $('.forano').removeClass('d-none');
                  $('.formonth').removeClass('d-none');

                break;


                case 3:

                  $('.forate').removeClass('d-none');
                  $('.forano').removeClass('d-none');
                  $('.formonth').removeClass('d-none');

                break;


              }

            }

          $(document).ready(function(){


            function getStatsArray(aims) {

              var results;
              var _token = $('input[name="_token"]').val();

              $.ajax({

                url: "report/getstats/"+aims,
                headers:{

                  'X-CSRF-TOKEN' : _token

                },
                async: false,
                method:"GET",
                dataType: 'json',
                data:{},
                success:function(data){

                  results = data;

                }
              });


              return results 

            }

              var chartmake = {
    
                initMainDashboard: function(){

                  chartColor = "#fff";

                    mainOptionChartConfig = {
                          
                        layout: {
                            padding: {
                                left: 20,
                                right: 20,
                                top: 0,
                                bottom: 0
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            backgroundColor: 'rgba(0,0,0,0.3)',
                            titleFontColor: '#fff',
                            bodyFontColor: '#fff',
                            bodySpacing: 4,
                            xPadding: 12,
                            mode: "nearest",
                            intersect: 0,
                            position: "nearest"
                          },
                        legend: {
                            position: "bottom",
                            fillStyle: "#FFF"
                          },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    fontColor: "rgba(255,255,255,0.4)",
                                    fontStyle: "bold",
                                    beginAtZero: true,
                                    maxTicksLimit: 5,
                                    padding: 10
                                },
                                gridLines: {
                                    drawTicks: true,
                                    drawBorder: false,
                                    display: true,
                                    color: "rgba(255,255,255,0.1)",
                                    zeroLineColor: "transparent"
                                }

                            }],
                            xAxes: [{
                                gridLines: {
                                
                                    zeroLineColor: "transparent",
                                    display: false

                                },
                                ticks: {
                                    padding: 10,
                                    fontColor: "rgba(255,255,255,0.4)",
                                    fontStyle: "bold"
                                }
                            }]
                        }
                        
                    };
                    
                    var allentries = getStatsArray('entriespermonth');
                    var allSells = getStatsArray('sellspermonth');

                    var ctx = document.getElementById('mainChart').getContext("2d");

                    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
                        gradientStroke.addColorStop(0, '#80b6f4');
                        gradientStroke.addColorStop(1, chartColor);

                    var gradientFill = ctx.createLinearGradient(0, 200, 0, 50);
                        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
                        gradientFill.addColorStop(1, "rgba(255, 255, 255, 0.24)");

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["{{__('messages._month_jan')}}", "{{__('messages._month_feb')}}", "{{__('messages._month_mar')}}", "{{__('messages._month_apr')}}", "{{__('messages._month_may')}}", "{{__('messages._month_jun')}}", "{{__('messages._month_jul')}}", "{{__('messages._month_aug')}}", "{{__('messages._month_sep')}}", "{{__('messages._month_oct')}}", "{{__('messages._month_nov')}}", "{{__('messages._month_dec')}}"],
                            datasets: [{
                                label: "{{__('messages.btn_entries')}}",
                                borderColor: chartColor,
                                pointBorderColor: chartColor,
                                pointBackgroundColor: "#1e3d60",
                                pointHoverBackgroundColor: "#1e3d60",
                                pointHoverBorderColor: chartColor,
                                pointBorderWidth: 1,
                                pointHoverRadius: 7,
                                pointHoverBorderWidth: 2,
                                pointRadius: 5,
                                fill: true,
                                backgroundColor: gradientFill,
                                borderWidth: 1,
                                data: [allentries.content['JAN'],allentries.content['FEB'],allentries.content['MAR'],allentries.content['APR'],allentries.content['MAY'],allentries.content['JUN'],allentries.content['JUL'],allentries.content['AUG'],allentries.content['SEP'],allentries.content['OCT'],allentries.content['NOV'],allentries.content['DEC']]
                            },{
                                label: "{{__('messages.btn_sells')}}",
                                backgroundColor: gradientFill,
                                borderColor: "#2CA8FF",
                                pointBorderColor: "#FFF",
                                pointBackgroundColor: "#2CA8FF",
                                pointBorderWidth: 2,
                                pointHoverRadius: 4,
                                pointHoverBorderWidth: 1,
                                pointRadius: 4,
                                fill: true,
                                borderWidth: 1,
                                data: [allSells.content['JAN'],allSells.content['FEB'],allSells.content['MAR'],allSells.content['APR'],allSells.content['MAY'],allSells.content['JUN'],allSells.content['JUL'],allSells.content['AUG'],allSells.content['SEP'],allSells.content['OCT'],allSells.content['NOV'],allSells.content['DEC']]
                            }]
                          },
                          options: mainOptionChartConfig

                    });

                  }


                };

              chartmake.initMainDashboard();

          });

        </script>
        </div>
@endsection