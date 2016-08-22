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
        <div class="col-md-4 col-md-offset-4">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-btn">
                <input type="hidden" name="f">
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                  <?=ucfirst('all')?>&nbsp;&nbsp;<span class="fa fa-caret-down"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="<?=base_url().'qbaca/orders/?f=all'?>">All</a></li>
                  <li><a href="<?=base_url().'qbaca/orders/?f=settle'?>">Settle</a></li>
                  <li><a href="<?=base_url().'qbaca/orders/?f=pending'?>">Pending</a></li>
                </ul>
              </div><!-- /btn-group -->
              <input type="text" name="date" class="form-control pull-right" placeholder="Date Range ..." id="date_range">
              <div class="input-group-btn">
                <button class="btn btn-default btn-flat"><i class="fa fa-search"></i></button>
              </div>
            </div><!-- /.input group -->
          </div><!-- /.form group -->  
        </div>
      </form>
    </div>
  </div><!-- /.box-body -->
</div><!-- /.box -->
<div class="box box-solid">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="ordersTable" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Email Pembaca</th>
                <th>Book Name</th>
                <th>Price</th>
                <th>Date</th>
                <th>Status</th>
                <th>Status Rekon</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
          
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>