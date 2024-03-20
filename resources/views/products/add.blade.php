            <form method="get"  action="" class=" row col-lg-12 mt-3" id = "products_form" enctype="multipart/form-data">
              @csrf

              <div class="col-lg-3 col-md-6 col-ms-12">

                  <img src="./public/img/default-avatar.png" class="picturessrc form-control" title="" style="width:143px; height:167px; border: 1px solid #ccc;"/>
                  <div class="form-group mt-2">

                    <input type="file" name="archive" id="picture" class="form-control ">
                      <h6> {{__('messages._coverimage')}}</h6>

                  </div>

              </div>
              <div class="col-lg-9 col-md-6 col-ms-12">
                
                <div class=" row form-group">    
                  <label for="nome"> {{__('messages.sellstable_description')}}:</label>
                  <input type="text" class="form-control" name="descricao" value="" />
                </div>

                <div class="row form-group">
                    

                    <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                      
                      <label for="telemovel"> {{__('messages.sellstable_unitprice')}}:</label>
                      <input type="text" class="form-control" name="precounitario"  value="" />

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                      
                      <label for="telemovel"> {{__('messages.sellstable_quantity')}}:</label>
                      <input type="text" class="form-control" name="quantidade"  value="" />

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      
                      <label for="Category"> {{__('messages._category')}}:</label>
                      <select name="category" class="form-control">
                      	@foreach($data['cats'] as $cat)
                      	
                      	<option value="{{$cat->id}}">{{$cat->descricao}}</option>

                      	@endforeach

                      </select>
                      

                    </div>
                </div>
                <div class="row">
                    

                    <div class="col-lg-4 col-md-4 col-sm-12 form-group">
                      
                      	<label for="telemovel"> {{__('messages._barcode')}}:</label>
                    	<input type="text" class="form-control" name="codigobarra"  value="" />

                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                      
                      <label for="Category"> {{__('messages._istributable')}}:</label>
                      <select name="istributable" class="form-control">
                        
                        <option value="1">{{__('messages._istributableyes')}}</option>
                        <option value="0">{{__('messages._istributableno')}}</option>

                      </select>
                      

                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 form-group">
                      
                      <label for="suppliers"> {{__('messages.tabproducts_suplliers')}}:</label>
                      <select name ='suppliers[]' class="form-control" multiple>
                      	@foreach($data['suppliers'] as $sup)
                      	
                      	<option value="{{$sup->id}}">{{$sup->nome_completo}}</option>

                      	@endforeach

                      </select>
                      

                    </div>
                </div> 
              
              <div class="row mt-3">
                    
                <div class="col-lg-6">
                      
                  {{ csrf_field() }}

                </div>
                  <div class="col-lg-3">
                    <div class="input-group">

                      <button type="button"  id ="cancel_actcolumn" class="form-control btn" style="color:#f00;"><span class="now-ui-icons ui-1_simple-remove"></span>{{__('messages.btn_cancel')}}</button>

                    </div>

                  </div>

                  <div class="col-lg-3">

                    <div class="input-group">

                      <button type="button"  id ="save_actcolumn"  class="form-control btn"  style="background:#ccc; color:#fff;" onclick="add('products')"><span class="now-ui-icons ui-2_disk"></span> {{__('messages.btn_save')}}</button>
                    </div>
                  </div>
                </div>
              </div>
                                      
          </form>