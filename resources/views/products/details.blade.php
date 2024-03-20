            <div class=" row col-lg-12 mt-3">
              
	            @csrf
	            <div class="col-lg-2 col-md-6 col-ms-12">

	                <img src='{{ $produto->imgURL }}' class="picturessrc form-control" title="" style="width:143px; height:167px; border: 1px solid #ccc;"/>

	            </div>
	            <div class="col-lg-10 col-md-6 col-ms-12">

	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages.sellstable_description')}}:</div>
	                    <div class="col-lg-8">{{$produto->descricao}}</div>
	                </div> 
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages.sellstable_unitprice')}}:</div>
	                    <div class="col-lg-8">{{$produto->precounitario}}</div>
	                </div>     
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages.sellstable_quantity')}}:</div>
	                    <div class="col-lg-8">{{$produto->quantidade}}</div>
	                </div>    
	                <div class="row">
	                    <div class="col-lg-4"> {{__('messages._barcode')}}:</div>
	                    <div class="col-lg-8">{{$produto->codigobarra}}</div>
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