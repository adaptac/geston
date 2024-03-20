            <div class=" row col-lg-12 mt-3">
              
	            @csrf
	            <div class="col-lg-2 col-md-6 col-ms-12">

	                <img src='{{ $usuario->imgURL }}' class="picturessrc form-control" title="" style="width:143px; height:167px; border: 1px solid #ccc;"/>

	            </div>
	            <div class="col-lg-10 col-md-6 col-ms-12">

	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages._fullname')}}:</div>
	                    <div class="col-lg-8">{{$usuario->nome_completo}}</div>
	                </div> 
	                <div class="row">
	                    <div class="col-lg-4">Email:</div>
	                    <div class="col-lg-8">{{$usuario->email}}</div>
	                </div>     
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages._mobile')}}:</div>
	                    <div class="col-lg-8">{{$usuario->telemovel}}</div>
	                </div>    
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages._userlevel')}}:</div>
	                    <div class="col-lg-8">{{$usuario->level}}</div>
	                </div>
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages._username')}}:</div>
	                    <div class="col-lg-8">{{$usuario->username}}</div>
	                </div>
	              
	              	<div class="row mt-3">
	                    
	                	<div class="col-lg-9">
	                      

	                	</div>
	                  	<div class="col-lg-3">
	                    	<div class="input-group">

	                      		<button type="button"  id ="cancel_actcolumn" class="form-control btn" style="color:#f00;"><span class="now-ui-icons ui-1_check-circle-08"></span> OK</button>

	                    	</div>

	                  	</div>
	                </div>
	            </div>
            </div>                          
          </div>