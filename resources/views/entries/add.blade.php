            <form method="get"  action="" class=" row col-lg-12 mt-3" id = "entries_form" enctype="multipart/form-data">
              @csrf
              <div class="col-lg-12 col-md-12 col-ms-12"> 

                <div class="row">
                    

                    <div class="col-lg-9 col-md-9 col-sm-9 form-group">
                      <label for="suppliers"> {{__('messages.tabproducts_product')}}:</label>
                      <select name ='id_products' class="form-control">
                        @foreach($data['products'] as $prod)
                        
                        <option value="{{$prod->id}}">{{$prod->descricao}}</option>

                        @endforeach

                      </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                      
                      <label for="telemovel"> {{__('messages.sellstable_quantity')}}:</label>
                      <input type="text" class="form-control" name="quantity"  value="" />

                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-lg-9 col-md-9 col-sm-12 form-group">
                      
                      <label for="suppliers"> {{__('messages.tabproducts_suplliers')}}:</label>
                      <select name ='id_suppliers' class="form-control">
                        @foreach($data['suppliers'] as $sup)
                        
                        <option value="{{$sup->id}}">{{$sup->nome_completo}}</option>

                        @endforeach

                      </select>
                      

                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                      
                      	<label for="telemovel"> {{__('messages._buyprice')}}:</label>
                    	<input type="text" class="form-control" name="buy_price"  value="" />

                    </div>
                    
                </div> 
              
              <div class="row mt-3">
                    
                <div class="col-lg-6">
                      
                  {{ csrf_field() }}

                </div>
                  <div class="col-lg-3">
                    <div class="input-group">

                      <button type="button"  id ="cancel_actcolumn" class="form-control btn" style="color:#f00;"><span class="now-ui-icons ui-1_simple-remove"></span>  {{__('messages.btn_cancel')}}</button>

                    </div>

                  </div>

                  <div class="col-lg-3">

                    <div class="input-group">

                      <button type="button"  id ="save_actcolumn"  class="form-control btn"  style="background:#ccc; color:#fff;" onclick="add('entries')"><span class="now-ui-icons ui-2_disk"></span>  {{__('messages.btn_save')}}</button>
                    </div>
                  </div>
                </div>
              </div>
                                      
          </form>