<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
            <div class="col-md-4 col-md-offset-1">
              <div class="form-group">
                <label>Corporate Name</label>
                <input type="text" class="form-control" name="InputCorpName" id="InputCorpName" placeholder="PT ABC XYZ ...">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Service Code</label>
                <select name="InputServiceID" id="InputServiceID" class="form-control">
                  <option value="">Choose Service</option>
                  <?='selectService'?>;
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-md-offset-1">
              <h4>PIC Account</h4>
            </div>
            <div class="col-md-10 col-md-offset-1" style="margin-top: -15px"><hr></div>
          </div>
          <div class="row">
            <div class="col-md-4 col-md-offset-1">
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="InputPicEmail" id="InputPicEmail" placeholder="user@domain.com">
                <p><small style="color:#888">* As Username</small></p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" name="InputPicFName" id="InputPicFName" placeholder="Budi">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Lastname</label>
                <input type="text" class="form-control" name="InputPicLName" id="InputPicLName" placeholder="Santoso">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-md-offset-1">
              <div class="form-group">
                <label>Role</label>
                <select class="form-control" name="InputRole">
                  <option value="">Choose Role</option>
                  <option value="pn-vwr">Viewer</option>
                  <option value="pn-mak">Maker</option>
                  <option value="pn-app">Approval</option>
                  <option value="pn-map">Maker & Approval</option>
                </select>
                <small class="text-danger"><?php echo form_error('InputRole') ?>&nbsp;</small>
              </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="InputPicPass" id="InputPicPass" class="form-control" placeholder="Password">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Password Confirmation</label>
                <input type="password" name="InputPicConfPass" id="InputPicConfPass" class="form-control" placeholder="Confirm Password">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-md-offset-1">
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="InputPicPhone" id="InputPicPhone" data-inputmask="'mask': ['9999-9999999999']" data-mask class="form-control">
                <p><small style="color:#888">*6281-123456</small></p>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- row -->
    <?php
    /*

    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open("admin/member/create_user");?>
      <div class="col-xs-offset-1 col-xs-5">
        <div class="form-group">
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
        </div>
        <div class="form-group">
              <?php echo lang('create_user_lname_label', 'last_name');?> <br />
              <?php echo form_input($last_name);?>
        </div>
        <div class="form-group">
          <?php
          if($identity_column!=='email') {
              echo '<div class="form-group">';
              echo lang('create_user_identity_label', 'identity');
              echo '<br />';
              echo form_error('identity');
              echo form_input($identity);
              echo '</div>';
          }
          ?>
        </div>

        <div class="form-group">
              <?php echo lang('create_user_email_label', 'email');?> <br />
              <?php echo form_input($email);?>
        </div>
      </div>

      <div class="col-xs-5">
        <div class="form-group">
              <?php echo lang('create_user_phone_label', 'phone');?> <br />
              <?php echo form_input($phone);?>
        </div>

        <div class="form-group">
              <?php echo lang('create_user_password_label', 'password');?> <br />
              <?php echo form_input($password);?>
        </div>

        <div class="form-group">
              <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
              <?php echo form_input($password_confirm);?>
        </div>
      </div>
      <div class="col-xs-2 col-xs-offset-8">
        <div class="form-group"><?php echo form_submit('submit', lang('create_user_submit_btn'));?></div>
      </div>
    <?php */ echo form_close();?>
  </div>
</div>