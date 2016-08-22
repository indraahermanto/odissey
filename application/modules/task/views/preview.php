<div class="box box-primary" style="min-height: 440px">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$this->convnumber->indonesian_date(strtotime($task->task_date),'l, d F Y', "")?></h3>
  </div><!-- /.box-header -->
  <?php //<form enctype="multipart/form-data" method="POST" action="<?=base_url().'snba/task/create'">?>
	  <div class="box-body">
	  	<div class="row">
	  		<div class="col-xs-10 col-xs-offset-1">
	  			<div class="form-group">
	  				<div style="height:150px">
	  					<div class="row">
		  					<div class="col-xs-4" style="height:75px">
		  						<label>Tanggal Aktivitas</label>
			  					<div class="input-group date">
	                  <div class="input-group-addon">
	                    <i class="fa fa-calendar"></i>
	                  </div>
	                  <input type="text" class="form-control pull-right" disabled value="<?=date('d-m-Y', strtotime($task->task_date))?>" name="inputDate" id="datepicker">
	                </div>
			  				</div>
			  				<div class="col-xs-4" style="height:75px">
			  					<label>Waktu Entry</label>
			  					<input type="text" disabled class="form-control" value="<?=$this->convnumber->indonesian_date(strtotime($task->task_created),'d F Y H:m ')?>">
		  					</div>
		  					<div class="col-xs-4" style="height:75px">
		  						<?php
		  						if($task->task_rev_stat == 1){
		  							// $noteReview = $task->task_review;
		  							$textReview = "<textarea disabled style='height:110px;max-height:110px;max-width:272px' name='noteReview' class='form-control'>$review_date\r\n".$task->task_review.'</textarea>';
		  						}else {
		  							// $noteReview = "";
		  							if($reviewUser == 1){
		  								$textReview = '<textarea style="height:75px;max-height:110px;max-width:272px" name="noteReview" class="form-control"></textarea>';
		  							}else{
		  								$textReview = '<textarea disabled style="height:110px;max-height:110px;max-width:272px" name="noteReview" class="form-control"></textarea>';
		  							}
		  							
		  						}
		  						?>
		  						<form method="POST" action="<?=base_url().'snba/task/review/'.$url[4]?>">
		  							<label>Review <?=$reviewer?></label>
		  							<?php ?>
			  						<?=$textReview?>
			  						<?=$buttReview?>
		  						</form>
		  					</div>
		  				</div>

		  				<div class="row">
		  					<div class="col-xs-4">
			  					<label>Nama Aktivitas</label>
			  					<input type="text" disabled id="inputActivity" name="inputActivity" value="<?=$task->task_activity?>" placeholder="Nama Aktivitas ..." class="form-control input-md" required>
			  				</div>
			  				<div class="col-xs-4">
			  					<label>Status</label>
			  					<select class="form-control" disabled required id="inputStatus" name="inputStatus">
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
	  				</div>
	  			</div>
			    <div class="form-group">
			    	<label>Keterangan</label>
			      <textarea id="inputDetActivity" disabled required minlength="30" name="inputDetActivity" class="form-control" style="height: 300px"><?=$task->task_content?></textarea>
			    </div>
	  		</div>
	  	</div>
	  </div>
	  <div class="box-footer">
	    <div class="pull-right">
	      <?php /* <a href="<?=base_url().'snba/task/draft'?>" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</a> 
	      <button type="submit" id="buttSave" class="btn btn-primary btn-flat" disabled><i class="fa fa-envelope-o"></i> Save</button> */ ?>
	    </div>
	    <a href="<?=base_url().'snba/task'?>" class="btn btn-default btn-flat">Back</a>
	    <?php /* <a href="<?=base_url().'snba/task/discard'?>" class="btn btn-default btn-flat"><i class="fa fa-times"></i> Discard</a> */ ?>
	  </div><!-- /.box-footer -->
  <!-- </form> -->
</div>