<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-2 col-sm-offset-1">
            
          </div>
          <div class="col-sm-2">
            
          </div>
          <div class="col-sm-2">
            
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 pull-right">
            <a class="btn btn-primary" href="<?=base_url().'admin/users/new'?>">
              <i class="fa fa-user-plus"></i>
              &nbsp;Add PIC Partner
            </a>
            <a class="btn btn-success" href="<?=base_url().'admin/partners/new'?>">
              <i class="fa fa-plus-circle"></i>
              &nbsp;New Partner
            </a>
          </div>
        </div>
        <br/>
        <div class="table-responsive">
          <table id="" class="table table-hover table-striped table-bordered">
            <thead>
              <th class="text-center">#</th>
              <th class="text-center">Name</th>
              <th class="text-center">Website</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </thead>
            <tbody>
            <!-- Content of table -->
            <?php
            if(!isset($url[3]))
              $no = 1;
            else $no = $index+1;
            foreach ($partners as $key => $partner) {
              if($partner->partner_status == 1){
                $status = "active";
                $btnActive    = "<a class='btn btn-flat' href=".base_url().'admin/partners/deactivate/'.$partner->partner_id.">";
                $btnActive   .= "<span class='fa fa-toggle-off'></span></a>";
              }else {
                $status = "not active";
                $btnActive    = "<a class='btn btn-flat' href=".base_url().'admin/partners/activate/'.$partner->partner_id.">";
                $btnActive   .= "<span class='fa fa-toggle-on'></span></a>";
              }
              
            ?>
            <tr>
              <td class="text-center"><?=number_format($no, 0, ',', '.')?></td>
              <td class="text-center"><?=strtoupper($partner->partner_name)?></td>
              <td class="text-center"><?=$partner->partner_website?></td>
              <td class="text-center"><?=ucwords($status)?></td>
              <td class="text-center">
                <a class="btn btn-flat btn-warning" href="<?=base_url().'admin/partners/edit/'.$partner->partner_id?>">
                  <span class="fa fa-pencil"></span> 
                </a>
                <?=$btnActive?>
              </td>
            </tr>
            <?php $no++; } ?>
            </tbody>
          </table>
          <?=$this->pagination->create_links();?>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
</div>