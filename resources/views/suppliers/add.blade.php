            <form method="get"  action="" class=" row col-lg-12 mt-3" id="suppliers_form" enctype="multipart/form-data">
              @csrf
              <div class="col-lg-12 col-md-12 col-ms-12">
                
                <div class="form-group">    
                  <label for="nome">{{__('messages._fullname')}}:</label>
                  <input type="text" class="form-control" name="nome" value="" />
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value='' />
                </div>

                <div class="row">
                  
                  <div class="col-lg-6 form-group">
                    <label for="username">{{__('messages._telephone')}}:</label>
                    <input type="text" class="form-control" name="telefone"  value='' />
                  </div>
                  <div class="col-lg-6 form-group">
                      <label for="password">{{__('messages._nuit')}}:</label>
                      <input type="text" class="form-control" name="nuit" value="" />
                  </div>

                </div>
                  
              
              <div class="row mt-3">
                    
                <div class="col-lg-6">
                      
                  {{ csrf_field() }}

                </div>
                  <div class="col-lg-3">
                    <div class="input-group">

                      <button type="button"  id ="cancel_actcolumn" class="form-control btn" style="color:#f00;"><span class="now-ui-icons ui-1_simple-remove"></span> {{__('messages.btn_cancel')}}</button>

                    </div>

                  </div>

                  <div class="col-lg-3">

                    <div class="input-group">

                      <button type="button"  class="form-control btn"  style="background:#ccc; color:#fff;" onclick="add('suppliers')"><span class="now-ui-icons ui-2_disk"></span> {{__('messages.btn_save')}}</button>
                    </div>
                  </div>
                </div>
              </div>
                                      
          </form>