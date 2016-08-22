<?php
	$notice   = "<div class='alert alert-success'>";
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
    <div class="row">
      <form method="GET">
        <div class="col-md-5 col-md-offset-1">
          <div class="form-group">
            <label>List of Partners:</label>
            <div class="input-group">
              <div class="input-group-btn">
                <input type="hidden" name="f" value="<?=''//$f?>">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=''//ucfirst($f)?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=all'?>">All</a></li>
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=settle'?>">Settle</a></li>
                  <li><a href="<?=base_url().'snba/qbaca/transaction?f=pending'?>">Pending</a></li>
                </ul>
              </div><!-- /btn-group -->
              <select class="form-control select2" name="p">
                <option value="">Choose Partner</option>
                <?php
                // $select = "";
                // foreach ($partners as $partner) {
                //   if($partner->partner_id == $p)
                //     $select = "selected";
                //   echo "<option value='".$partner->partner_id."' $select>".ucwords($partner->partner_name)."</option>";
                // }
                ?>
              </select>
            </div><!-- /.input group -->
          </div><!-- /.form group -->
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label>Date range:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" name="date" value="<?=''//$date?>" class="form-control pull-right" id="date_range">
            </div><!-- /.input group -->
          </div>
          <div class="form-group">
            <button class="btn btn-default btn-flat btn-sm pull-right">
              Search
            </button>
          </div> 
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
<div class="box box-solid">
  <!-- <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  <!-- </div> --><!-- /.box-header -->
  <div class="box-body">
		<div class="row">
			<div class="col-xs-3 col-xs-offset-8">
				<p class="pull-right">
					<?php echo anchor('admin/users/new', "New User")?> | 
					<?php echo anchor('admin/role/new', "New Role")?>
				</p>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped">
				<tr>
					<th class="text-center">No</th>
					<th class="text-center"><?php echo lang('index_fname_th');?></th>
					<th class="text-center"><?php echo lang('index_lname_th');?></th>
					<th class="text-center"><?php echo lang('index_email_th');?></th>
					<th class="text-center"><?php echo "Role";?></th>
					<th class="text-center"><?php echo "Services";?></th>
					<th class="text-center"><?php echo lang('index_status_th');?></th>
					<th class="text-center"><?php echo lang('index_action_th');?></th>
				</tr>
				<?php foreach ($users as $no => $user): $no++;?>
					<tr>
						<td class="text-center"><?=$no?></td>
            <td class="text-center"><?php echo ucwords($user->first_name);?></td>
            <td class="text-center"><?php echo ucwords($user->last_name);?></td>
            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
						<td class="text-center">
							<?php foreach ($user->roles as $role):?>
								<?php echo ucwords($role->name);?><br />
			                <?php endforeach?>
						</td>
						<td class="text-center">
							<?php foreach ($user->services as $service):?>
								<?php echo strtoupper($service->name);?><br />
			                <?php endforeach?>
						</td>
						<td class="text-center"><?php echo ($user->active) ? lang('index_active_link') : lang('index_inactive_link');?></td>
						<td class="text-center"><?php echo anchor("admin/users/edit/".$user->id, 'Edit') ;?></td>
					</tr>
				<?php endforeach;?>
			</table>
		</div>