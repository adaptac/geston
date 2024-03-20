@extends('base')

@section('main')

<style type="text/css">
  

.sidepanel{

              position: fixed;
              top: 0;
              height: 100%;
              bottom: 0;
              right: 0;
              z-index: 1030;
              background: #f96332;

            }

            html, body{

               background:#eee;

            }

</style>


  <div class="container">

      <div class="row " style="position:fixed; z-index:2; top:60px; left:60px; min-width: 100%;">
        <div class="col-lg-10">
          <div class="card"  style="min-height:500px;">
              <div class="card-body col-lg-11">

              <div class="row col-lg-10 m-1 ml-3 p-0 justify-content-center" style="min-height: 409px; max-height:410px; border-bottom: 1px solid #eee;">

                  <img src="{{ asset('/img/faviconlogin.png') }}"  style=" max-height:408px;">

              </div>
              <div class="row col-lg-10 m-1 ml-2" style="min-height: 99px; max-height:100px; font-size: 10px;">

                Seja muito bem-vindo a Geston Lab! Este Sistema e um sistema simplificado de gestão de stocks desenvolvido pela Adatec(www.adatec.co.mz). Para mais informações e compartilhamento de sugestões ou criticas, por favor contacte o nosso desenvolvedor chefe pelo email: adaptableman@outlook.com</br>
                
                  
              </div>

            </div>
          </div>
        </div>
      </div>

    <div class="row col-lg-4 col-sm-5 col-md-5 col-xs-12 sidepanel">

      <div class="col-lg-12 m-auto">

        <h1 align="center" style="color:white; font-size: 80px;"><i class="now-ui-icons users_circle-10"></i> </h1>
        
        <form class="register-form" method="get" action="{{ route('users.useraccess')}}">
          <div class="input-group no-border">
              <input type="text" value="" name="username" id="user_email" class="form-control" placeholder="Email..." onchange="">
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="now-ui-icons ui-1_email-83" style="color:white;"></i>
              </div>
            </div>
          </div>
          <div class="input-group no-border">
              <input type="password" value="" name="password" id="user_password" class="form-control" placeholder="Password..." onchange="">
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="now-ui-icons objects_key-26" style="color:white;"></i>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-neutral btn-block btn-round" onclick=""><span class="now-ui-icons ui-1_lock" style=""></span> Login</button>
        </form>
        <p style="color: white;">{{ $response ?? '' }}</p>
      </div>

    </div>

  </div>

  <script type="text/javascript">
  	
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


  </script>


@endsection