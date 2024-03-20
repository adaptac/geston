            <form method="get"  action="" class=" row col-lg-12 mt-3" id = "users_form" enctype="multipart/form-data">
              @csrf

              <div class="col-lg-3 col-md-6 col-ms-12">

                  <img src="./public/img/default-avatar.png" class="picturessrc form-control" title="" style="width:143px; height:167px; border: 1px solid #ccc;"/>
                  <div class="form-group mt-2">

                    <input type="file" name="archive" id="picture" class="form-control ">
                      <h6> {{__('messages._chooseimage')}}</h6>

                  </div>

              </div>
              <div class="col-lg-9 col-md-6 col-ms-12">
                
                <div class="form-group">    
                  <label for="nome"> {{__('messages._fullname')}}:</label>
                  <input type="text" class="form-control" name="nome" value="" />
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" name="email" value="" />
                </div>

                <div class="row">
                    

                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      
                      <label for="telemovel"> {{__('messages._mobile')}}:</label>
                      <input type="text" class="form-control" name="telemovel"  value="" />

                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                      
                        <label for="level"> {{__('messages._userlevel')}}:</label>
                        <select name="level" class="form-control">
                          <option value="1"> {{__('messages._userlevel_advanced')}}</option>
                          <option value="2"> {{__('messages._userlevel_senior')}}</option>
                          <option value="3"> {{__('messages._userlevel_junior')}}</option>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <label for="username"> {{__('messages._username')}}:</label>
                    <input type="text" class="form-control" name="username"  value="" />
                </div>
                <div class="form-group">
                    <label for="password"> {{__('messages._password')}}:</label>
                    <input type="password" class="form-control" name="password" value="" />
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

                      <button type="button"  id ="save_actcolumn" class="form-control btn"  style="background:#ccc; color:#fff;" onclick="add('users')"><span class="now-ui-icons ui-2_disk"></span>  {{__('messages.btn_save')}}</button>
                    </div>
                  </div>
                </div>
              </div>
                                      
          </form>