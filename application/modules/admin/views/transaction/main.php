<div class="box box-success">
  <div class="box-header with-border">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
      <form method="GET">
        <div class="row">
          <div class="col-md-5 col-md-offset-1">
            <input type="text" name="date" class="form-control pull-right" placeholder="Date Range ..." id="date_range">
          </div>
          <div class="col-md-5">
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
                <input type="text" name="key" class="form-control pull-right" placeholder="Keyword ...">
              </div><!-- /.input group -->
            </div><!-- /.form group -->  
          </div>
        </div>
        <div class="row">
          <div class="col-xs-3 col-md-2 col-xs-offset-8 col-md-offset-9">
            <div class="form-group">
              <button style="max-width:120px" class="btn btn-primary btn-flat form-control">Search&nbsp;&nbsp;&nbsp;<i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </form>
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
                <th>Order ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?=$tableTrx?>
            </tbody>
          </table>
          <?=$this->pagination->create_links();?>
        </div>
      </div>
    </div>
  </div>
</div>