<title>Odissey: Login Page</title>
<div class="login-box">
  <div class="login-logo">
    <a href="<?=base_url()?>"><b>Odi</b>ssey</a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <div id="infoMessage"><?php echo $message;?></div>
    <?php echo form_open("main/login");?>
      <div class="form-group has-feedback">
        <input type="text" name="identity" id="identity" class="form-control" placeholder="Email/Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <p>
            <?php echo lang('login_remember_label', 'remember');?>
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
          </p>
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div><!-- /.col -->
      </div>
    </form>

    <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
    <!-- <a href="register.html" class="text-center">Register a new membership</a> -->

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->