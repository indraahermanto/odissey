<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title?></title>
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
    <?php $this->load->view($additionalCSS) ?>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?=base_url()?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>O</b>S</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>O</b>dissey</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                          page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel" style="height: 70px">
            <div class="pull-left image">
              <!-- <img src="" class="img-circle" alt="User Image"> -->
            </div>
            <div class="pull-left info">
              <p><?=ucwords($user->first_name." ".$user->last_name)?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">Main Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="<?php if(!isset($url[2]) && $url[1] == 'snba') echo 'active' ?>">
              <a href="<?=base_url().'snba'?>"><i class="fa fa-home"></i> <span>Home</span></a>
            </li>
            <?=$adv_menu
            /*
            <li class="<?php if(substr_count($left_side, 'orders') > 0) echo 'active' ?>">
              <a href="<?=base_url().'orders'?>"><i class="fa fa-barcode"></i> <span>Orders</span></a>
            </li>
            <li class="<?php if(isset($url[2]) && $url[2] == 'payments') echo 'active' ?>">
              <a href="<?=base_url().'payments'?>"><i class="fa fa-credit-card"></i> <span>Payments</span></a>
            </li>
            <li class="<?php if(substr_count($left_side, 'reports') > 0) echo 'active' ?>">
              <a href="<?=base_url().'reports'?>"><i class="fa fa-bookmark"></i> <span>Reports</span></a>
            </li>
            <li class="<?php if(substr_count($left_side, 'member') > 0) echo 'active' ?>">
              <a href="<?=base_url().'member'?>"><i class="fa fa-user"></i> <span>Profile</span></a>
            </li>
            <li><a href="#"><i class="fa fa-cogs"></i> <span>Setting</span></a></li>
            */
            ?>
            <li><a href="<?=base_url().'main/logout'?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?=$page_header?>
            <small><?=$description?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=base_url()?>"><i class="fa fa-home"></i> Home</a></li>
            <?php
            $countUrl = substr_count($left_side, '/');

            foreach ($url as $key_side => $val_side) {
              if($key_side > 1){
                if($countUrl == ($key_side-1))
                  $sideActive = 'active';
                else $sideActive = '';
                if(strlen($val_side) < 20)
                  echo '<li class="'.$sideActive.'">'.ucfirst($val_side).'</li>';
              }
            }
            ?>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php $this->load->view($content_view); ?>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          <small>Server process time <strong>{elapsed_time}</strong> seconds.</small>
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="http://10.11.23.93/odissey">Odissey [dot] com</a>.</strong><br/>All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <?php /*
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript::;">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
            </ul><!-- /.control-sidebar-menu -->

          </div><!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
                <p>
                  Some information about this general settings option
                </p>
              </div><!-- /.form-group -->
            </form>
          </div><!-- /.tab-pane -->
        </div>
      </aside><!-- /.control-sidebar -->
      */?>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url().'assets/plugins/jQuery/jQuery-2.1.4.min.js'?>"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=base_url().'assets/bootstrap/js/bootstrap.min.js'?>"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url().'assets/dist/js/app.min.js'?>"></script>
    <!-- Custom by Me -->
    <script src="<?=base_url().'assets/plugins/custom/js/main.js'?>"></script>
    <?php $this->load->view($additionalJS) ?>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
  </body>
</html>
