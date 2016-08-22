<?php
if(isset($_SESSION['note'])){
    $alert    = "";
    $mess     = "";
    switch ($_SESSION['note']) {
      case 'disTask':
        $alert    = "alert-danger";
        $mess     = "Aktivitas berhasil dihapus.";
      break;
      case 'succTask':
        $alert    = "alert-success";
        $mess     = "Aktivitas berhasil dibuat.";
      break;
      case 'drafTask':
        $alert    = "alert-success";
        $mess     = "Aktivitas disimpan di dalam draft.";
      break;
      case 'succSaveTask':
        $alert    = "alert-success";
        $mess     = "The  successfully submitted.";
      break;
      case 'succSubSPB':
        $alert    = "alert-success";
        $mess     = "Bukti Bayar has been uploaded.";
      break;
      case 'appSucceed':
        $alert    = "alert-success";
        $mess     = "Invoices has been approved.";
      break;
    }
    $notice   = "<div class='alert ".$alert."'>";
    $notice  .= "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    $notice  .= "<span aria-hidden='true'>&times;</span>";
    $notice  .= "</button>".$mess."</div>";
    unset($_SESSION['note']);
    echo $notice;
  }
?>
<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
    <div class="row">
      <form method="GET">
        <div class="col-md-5 col-md-offset-1">
          
          <div class="form-group">
            <label>Status</label>
            <div class="input-group">
              <div class="input-group-btn">
                <input type="hidden" name="f" value="<?=$fw?>">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=ucwords($f)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'snba/task/?f=all'?>">All</a></li>
                  <?php
                  foreach ($listStatus as $status) {
                    echo "<li><a href='".base_url()."snba/task/?f=$status->stat_id'>".ucwords($status->stat_name)."</a></li>";
                  }
                  ?>
                </ul>
              </div><!-- /btn-group -->
              <input type="text" class="form-control" readonly value="<?=$key?>" placeholder="Keyword of activity ..." name="key">
            </div><!-- /.input group -->
          </div><!-- /.form group -->
        </div>
        <div class="col-md-5">
          <label>Rentang Tanggal</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="date" value="<?=''?>" class="form-control pull-right" id="date_range">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-flat btn-default" value="Search">
            </div>
          </div>
        </div>
      </form>
    </div><br/>
    <div class="row">
      <div class="col-md-2 col-md-offset-9">
        <a href="<?=base_url().'snba/task/new'?>" class="btn btn-flat btn-sm btn-primary">
          Aktivitas Baru
        </a>
      </div>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->

<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php // echo $_GET['f']." s ".$pbank_name ?>
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center" width="50px">No</th>
                <th class="text-center" width="200px">Nama Lengkap</th>
                <th class="text-center" width="150px">Tanggal Kegiatan</th>
                <th class="text-center">Aktivitas</th>
                <th class="text-center" width="150px">Status</th>
                <th class="text-center" width="100px">Tindakan</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks as $key => $task) { $no = $key+1; ?>
              <tr>
                <td class="text-left"><?=number_format($no, 0, ',', '.')?></td>
                <td class="text-center"><?=ucwords($task->first_name." ".$task->last_name)?></td>
                <td class="text-center"><?=$this->convnumber->indonesian_date(strtotime(date($task->task_date)),'d F  Y', '');?></td>
                <td><?=$task->task_activity?></td>
                <td class="text-center"><?=ucwords($task->stat_name)?></td>
                <td class="text-center">
                  <a href="<?=base_url()."snba/task/preview/".sha1($this->config->item('salt').$task->task_id)?>">Lihat</a>
                  <?php /*
                   | <a href="<?=base_url()."snba/task/edit/".sha1($this->config->item('salt').$task->task_id)?>">Edit</a> */ ?>
                </td>
              </tr>
            <?php } ?>
            </tbody>
            <tfoot>
              
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>