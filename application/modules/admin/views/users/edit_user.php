<?php
  $notice   = "<div class='alert alert-danger'>";
  $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
  $notice  .= "<span aria-hidden='true'>&times;</span>";
  $notice  .= "</button>".$message."</div>";
  
  if(isset($message)) echo $notice;
  
?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div id="infoMessage"></div>
    <?php echo form_open(uri_string());?>
    <div class="col-xs-offset-1 col-xs-5">
      <div class="form-group">
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </div>

      <div class="form-group">
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </div>
      
    </div>

    <div class="col-xs-5">
      <div class="form-group">
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
      </div>

      <div class="form-group">
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm);?>
      </div>
    </div>

    <div class="col-xs-10 col-xs-offset-1">
        <?php if ($this->ion_auth->is_admin()): ?>
            <h3><?php echo lang('edit_user_groups_heading');?></h3>
            <ul class="list-unstyled list-inline">
            <?php foreach ($groups as $group):?>
              <li>
                
                  <?php
                      $gID=$group['id'];
                      $checked = null;
                      $item = null;
                      foreach($currentGroups as $grp) {
                          if ($gID == $grp->id) {
                              $checked= ' checked="checked"';
                          break;
                          }
                      }
                  ?>
                  
                    <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                    <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                
              </li>
            <?php endforeach?>
            </ul>

        <?php endif ?>
    </div>

     <!--  <div>
            <?php // echo lang('edit_user_company_label', 'company');?> <br />
            <?php // echo form_input($company);?>
      </div> -->

      <!-- <div>
            <?php // echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php // echo form_input($phone);?>
      </div> -->

      

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <div class="col-xs-1 col-xs-offset-9">
        <?php echo form_submit(array('type' => 'submit', 'class' => 'btn btn-success btn-flat btn-sm'), lang('edit_user_submit_btn'));?>
      </div>

<?php echo form_close();?>
