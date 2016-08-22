<div class="box box-primary" style="min-height: 440px">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$this->convnumber->indonesian_date(strtotime($task->task_date),'l, d F Y', "")?></h3>
  </div><!-- /.box-header -->
  <form enctype="multipart/form-data" method="POST" action="<?=base_url().'snba/task/save'?>">
	  <div class="box-body">
	  	<div class="row">
	  		<div class="col-xs-10 col-xs-offset-1">
	  			<div class="form-group">
	  				<div class="row">
	  					<div class="col-xs-3">
	  						<label>Tanggal Aktivitas</label>
		  					<div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" disabled class="form-control pull-right" value="<?=date('d-m-Y', strtotime($task->task_date))?>" name="inputDate" id="datepicker">
                </div>
		  				</div>
		  				<div class="col-xs-3">
		  					<label>Waktu Entry</label>
		  					<input type="text" disabled class="form-control" value="<?=$this->convnumber->indonesian_date(strtotime($task->task_created),'d F Y H:m ')?>">
	  					</div>
		  				<div class="col-xs-3">
		  					<label>Status</label>
		  					<select class="form-control" required id="inputStatus" name="inputStatus">
		  						<option value="">Pilih Status</option>
		  						<?php foreach ($status as $stat) { 
		  							if($task->task_status == $stat->stat_id)
		  								$select = "SELECTED";
		  							else $select = "";
		  							echo "<option $select value='".$stat->stat_id."'>".ucwords($stat->stat_name)."</option>";
	  							} ?>
		  					</select>
		  				</div>
	  				</div>
	  				<br/>
	  				<div class="row">
	  					<div class="col-xs-12">
		  					<label>Nama Aktivitas</label>
		  					<input type="text" id="inputActivity" name="inputActivity" value="<?=$task->task_activity?>" placeholder="Nama Aktivitas ..." class="form-control input-md" required>
		  				</div>
	  				</div>
	  			</div>
			    <div class="form-group">
			    	<label>Keterangan</label>
			      <textarea id="inputDetActivity" required minlength="30" name="inputDetActivity" class="form-control" style="height: 300px"><?=$task->task_content?></textarea>
			    </div>
	  		</div>
	  	</div>
	  </div>
	  <div class="box-footer">
	    <div class="pull-right">
	      <?php /* <a href="<?=base_url().'snba/task/draft'?>" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</a> */ ?>
	      <input type="hidden" name="taskID" value="<?=sha1($this->config->item('salt').$task->task_id)?>">
	      <button type="submit" id="buttSave" class="btn btn-primary btn-flat"><i class="fa fa-envelope-o"></i> Simpan</button>
	    </div>
	    <a href="<?=base_url().'snba/task'?>" class="btn btn-default btn-flat">Kembali</a>
	  </div><!-- /.box-footer -->
  </form>
</div>