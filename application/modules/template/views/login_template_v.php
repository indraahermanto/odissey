<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?=base_url().'assets/bootstrap/css/bootstrap.min.css'?>">
		<!-- Font Awesome -->
		<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
		<link rel="stylesheet" href="<?=base_url().'assets/plugins/font-awesome-4.5/css/font-awesome.css'?>">
		<!-- Ionicons -->
		<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
		<link rel="stylesheet" href="<?=base_url().'assets/plugins/ionicons-2.0.1/css/ionicons.css'?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?=base_url().'assets/dist/css/AdminLTE.min.css'?>">
		<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
					page. However, you can choose any other skin. Make sure you
					apply the skin class to the body tag so the changes take effect.
		-->
		<link rel="stylesheet" href="<?=base_url().'assets/dist/css/skins/skin-blue.min.css'?>">
		<link rel="stylesheet" href="<?=base_url().'assets/plugins/custom/css/style.css'?>">
		<!-- Custom CSS -->
		<link href="<?=base_url().'assets/plugins/landing/css/stylish-portfolio.css'?>" rel="stylesheet">
</head>
<body>

<title><?=$title?></title>
<style type="text/css">
		.login{
				background: url('<?php echo base_url()."assets/img/login/background.png"?>') no-repeat fixed;
				background-size: 100% 100%;
				min-height:680px;
		}
		.col-xs-4.col-sm-2{
				background: url('<?php echo base_url()."assets/img/login/logo.png"?>') no-repeat;
				background-size: 60% 60%;
				min-height:100px;
				max-height:100px;
				padding-right: -100px;
		}
		.bg_login{
				background: url('<?php echo base_url()."assets/img/login/bg_login.png"?>') no-repeat;
				background-size: 100% 100%;
				min-height:400px;
				max-height:400px;
		}
		.row {
				margin-right: 0px;
				margin-left: 0px;
		}
		.odissey-logo{ height: 60px; }
		.odissey-text{ height: 40px; }
		.login-form{ padding-top:145px; }
		.line{ height:20px; }
		@media screen and (max-width: 600px) { /* Specific to this particular image */
			.login{ min-height:500px; }
			.bg_login{
				min-height: 200px;
				max-height: 200px;
			}
			.login-form{ padding-top:65px; }
			.line{ height:10px; }
		}

		@media screen and (max-width: 320px) { /* Specific to this particular image */
			.login{ min-height:500px; }
			.odissey-logo{ height: 40px; }
				.odissey-text{ height: 20px; }
				.bg_login{ min-height: 200px; max-height: 200px; }
		}
</style>

<div class="login">
		<br/><br/>
		<div class="row">
				<div class="col-xs-8 col-sm-10"></div>
				<div class="col-xs-4 col-sm-2"></div>
		</div>

		<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<?php if(isset($message)){ ?>
					<div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?=$message?>
          </div>
					<?php } ?>
				</div>
		</div>
		<div class="row">
				<div class="col-xs-12">
						<div class="row">
								<div class="col-xs-3 col-sm-4 col-md-5"></div>
								<div class="col-xs-6 col-sm-4 col-md-2">
										<img src="<?php echo base_url()."assets/img/login/logo_odissey.png"?>" class="img-responsive odissey-logo text-center">
								</div>
								<div class="col-xs-3 col-sm-4 col-xs-5"></div>
						</div>
						<div class="row">
								<div class="col-xs-1 col-sm-4 col-md-4"></div>
								<div class="col-xs-10 col-sm-4 col-md-4">
										<img src="<?php echo base_url()."assets/img/login/online_digital.png"?>" class="img-responsive odissey-text text-center">
								</div>
								<div class="col-xs-1 col-sm-4 col-md-4"></div>
						</div>
				</div>
		</div>
		<div class="row">
				<div class="col-xs-2 col-sm-3 col-lg-4"></div>
				<div class="col-xs-8 col-sm-6 col-lg-4 bg_login">
						<form method="post" action="<?=base_url().'main/login'?>" class="login-form">
								<div class="row">
										<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
											<div class="form-group has-feedback">
												<input type="text" name="identity" id="identity" class="form-control" placeholder="Email/Username">
												<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
											</div>
										</div>
								</div>
								<div class="line"></div>
								<div class="row">
										<div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3">
											<div class="form-group has-feedback">
												<input type="password" name="password" id="password" class="form-control" placeholder="Password">
												<span class="glyphicon glyphicon-lock form-control-feedback"></span>
											</div>
										</div>
								</div>
								<div class="row text-center">
										<input type="submit" class="btn btn-default btn-sm" value="Login">
								</div>
						</form>
				</div>
				<div class="col-xs-2 col-sm-3 col-lg-4"></div>
		</div>
</div>
		<!-- jQuery -->
		<script src="<?=base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js'?>"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="<?=base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
		<!-- iCheck -->
		<script src="<?=base_url().'assets/plugins/iCheck/icheck.min.js'?>"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
				});
			});
		</script>
</body>

</html>
