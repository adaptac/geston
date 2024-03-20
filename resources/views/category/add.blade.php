            <form method="get"  action="" class=" row col-lg-12 mt-3" id = "category_form" enctype="multipart/form-data">
              @csrf
              <div class="col-lg-12 col-md-12 col-ms-12">
                
                <div class=" row form-group">    
                  <label for="nome"> {{__('messages.sellstable_description')}}:</label>
                  <input type="text" class="form-control" name="descricao" value="" />
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

                      <button type="button"  id ="save_actcolumn"  class="form-control btn"  style="background:#ccc; color:#fff;" onclick="add('category')"><span class="now-ui-icons ui-2_disk"></span>  {{__('messages.btn_save')}}</button>
                    </div>
                  </div>
                </div>
              </div>
                                      
          </form>