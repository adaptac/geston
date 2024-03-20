<!DOCTYPE html>
<html>
   <head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<title>GESTON LAB</title>
    	<meta name="description" content="">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="robots" content="all,follow">
    	<!-- Bootstrap CSS-->
    	<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    	<!-- Font Awesome CSS-->
    	<!--link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"-->
    	<!-- Google fonts - Popppins for copy-->
    	<!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800"-->
    	<!-- orion icons-->
    	<link rel="stylesheet" href="{{ asset('/css/now-ui-dashboard.css') }}">
    	
    	<link rel="stylesheet" href="{{ asset('/css/bootstrap-select.css') }}" id="theme-stylesheet">
        <link rel="stylesheet" href="{{ asset('/css/jquery-confirm.css') }}" >
    	<!-- Custom stylesheet - for your changes-->
    	<link rel="stylesheet" href="{{ asset('/css/mark10_css.css') }}">
    	<!-- Favicon-->
    	<link rel="shortcut icon" href="{{ asset('/img/glogon.png') }}?3">
    	<!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
       	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <script src="{{ asset('/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/js/moment.min.js') }}"> </script>
        <script src="{{ asset('/js/popper.js') }}"> </script>
        <script src="{{ asset('/js/moment.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/perfect-scrollbar.jquery.min.js') }}"></script>
        <script src="{{ asset('/js/now-ui-dashboard.js') }}?v=1.1.0"></script>
        <script src="{{ asset('/js/chartjs.min.js') }}"> </script>
        <script src="{{ asset('/js/bootstrap-switch.min.js') }}"> </script>
   </head>
   <body>

    <div class="splash row col-lg-12 m-0 p-0 justify-content-center" style="background: rgba(255,255,255,0.99); position: fixed; width: 100%; min-height: 100%;left: 0; top: 0;z-index: 999999999999999999999;">
            
            <img src="{{ asset('/img/loadertwo.gif') }}" width="64" height="64" style="position: absolute; top: 45%;">
            
        </div>

   @yield('main')

   {{ csrf_field() }}

	<!-- JavaScript files-->
    	
        <script>
            
            $(window).on('load', function(){

                $('.splash').fadeOut(800);

            });

        </script>
    	
        <script src="{{ asset('/js/jquery-confirm.js') }}"></script>
        <script src="{{ asset('/js/bootstrap-select.js') }}"></script>
        
        <script src="{{ asset('/js/jquery.backstretch.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap-notify.js') }}"></script>

        <script src="{{ asset('/js/jPages.js') }}"></script>
        
    	<script src="{{ asset('/js/app.js') }}"></script>

         @if(Session::has('username'))

        <script type="text/javascript">

          var idletime = 0;

            $(document).ready(function(){

                  setInterval(function(){

                    idletime = idletime + 1;

                        $(this).mousemove(function(e){

                        idletime = 0;

                    });

                    $(this).keypress(function(e){

                        idletime = 0;

                    });

                    if (idletime > 150) {

                      location.href = 'users/logout';
                      location.reload();


                    } 

                      var _token = $('input[name="_token"]').val();

                      $.ajax({

                          url: "notification/getnotification",
                          headers:{

                          'X-CSRF-TOKEN' : _token

                          },
                          method:"get",
                          dataType:'json',
                          data:{},
                          success:function(data){

                            if(data != 0 ) {
                              
                                $.notify({
                                          
                                    icon: "",
                                    message: data.info
                                                    
                                }, {
                                                      
                                    type: 'info',
                                    timer: 2000,
                                    placement: {
                                                        
                                        from: 'bottom',
                                        align: 'right'
                                                      
                                    }
                                                    
                                });

                            } 



                          }
                      });

                  }, 2000);

            });

        </script>
        @endif
    </body>
</html>