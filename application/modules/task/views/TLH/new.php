<div class="box box-primary" style="min-height: 440px">
  <div class="box-header with-border">
    <h3 class="box-title"><?=$date_now?></h3>
  </div><!-- /.box-header -->
  <form enctype="multipart/form-data" method="POST" action="<?=base_url().'snba/task/create'?>">
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
                  <input type="text" class="form-control pull-right" required placeholder="<?=date('d-m-Y', strtotime('now'))?>" name="inputDate" id="datepicker">
                </div>
		  				</div>
		  				<div class="col-xs-3">
		  					<label>Status</label>
		  					<select class="form-control" required name="inputStatus">
		  						<option value="">Pilih Status</option>
		  						<?php foreach ($status as $stat) { 
		  							echo "<option value='".$stat->stat_id."'>".ucwords($stat->stat_name)."</option>";
	  							} ?>
		  					</select>
		  				</div>
	  				</div>
	  				<br/>
	  				<div class="row">
	  					<div class="col-xs-12">
		  					<label>Nama Aktivitas</label>
		  					<input type="text" name="inputActivity" placeholder="Nama Aktivitas ..." class="form-control input-md" required>
		  				</div>
	  				</div>
	  			</div>
			    <div class="form-group">
			    	<label>Keterangan</label>
			      <textarea id="inputDetActivity" required minlength="30" name="inputDetActivity" class="form-control" style="height: 300px"></textarea>
			    </div>
	  		</div>
	  	</div>
	  </div>
	  <div class="box-footer">
	    <div class="pull-right">
	      <?php /* <a href="<?=base_url().'snba/task/draft'?>" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</a> */ ?>
	      <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-envelope-o"></i> Save</button>
	    </div>
	    <a href="<?=base_url().'snba/task'?>" class="btn btn-default btn-flat">Back</a>
	    <a href="<?=base_url().'snba/task/discard'?>" class="btn btn-default btn-flat"><i class="fa fa-times"></i> Discard</a>
	  </div><!-- /.box-footer -->
  </form>
</div>