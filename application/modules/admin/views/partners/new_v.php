
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
          <!--      Wizard container        -->   
          <div class=""> 
            <div class="card wizard-card ct-wizard-green" id="wizard">
              <form action="" id="step" method="POST">
                <ul>
                  <li><a href="#account" data-toggle="tab">Account</a></li>
                  <li><a href="#about" data-toggle="tab">About</a></li>
                  <li><a href="#preview" data-toggle="tab">Preview</a></li>
                </ul>
                      
                <div class="tab-content">
                  <div class="tab-pane" id="account">
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>Corporate Name</label>
                          <input type="text" class="form-control" name="InputCorpName" id="InputCorpName" placeholder="PT ABC XYZ ...">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label>&nbsp;</label>
                          <div class="form-group form-animate-checkbox" style="padding-top: 5px">
                            <input type="checkbox" name="InputTaxStat" value="1" id="checkNPWP" class="checkbox">
                            <label style="margin-top: -5px">&nbsp;<small>Have NPWP ?</small></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group" id="noNPWP">
                          <label>NPWP Number</label>
                          <input type="text" class="form-control" name="InputTaxNo" id="InputTaxNo" data-inputmask="'mask': ['99.999.999.9-999.999']" data-mask>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>Service Code</label>
                          <select name="InputServiceID" id="InputServiceID" class="form-control">
                            <option value="">Choose Service</option>
                            <?=$selectService?>;
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-md-offset-1">
                        <h4>PIC Account</h4>
                      </div>
                      <div class="col-md-10 col-md-offset-1" style="margin-top: -15px"><hr></div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" class="form-control" name="InputPicEmail" id="InputPicEmail" placeholder="user@domain.com">
                          <p><small style="color:#888">* As Username</small></p>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Firstname</label>
                          <input type="text" class="form-control" name="InputPicFName" id="InputPicFName" placeholder="Budi">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Lastname</label>
                          <input type="text" class="form-control" name="InputPicLName" id="InputPicLName" placeholder="Santoso">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                          <label>Role</label>
                          <select class="form-control" name="InputRole">
                            <option value="">Choose Role</option>
                            <option value="pn-vwr">Viewer</option>
                            <option value="pn-mak">Maker</option>
                            <option value="pn-app">Approval</option>
                            <option value="pn-map">Maker & Approval</option>
                          </select>
                          <small class="text-danger"><?php echo form_error('InputRole') ?>&nbsp;</small>
                        </div>
                      </div>
                      <div class="col-md-1"></div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="InputPicPass" id="InputPicPass" class="form-control" placeholder="Password">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Password Confirmation</label>
                          <input type="password" name="InputPicConfPass" id="InputPicConfPass" class="form-control" placeholder="Confirm Password">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                          <label>Phone Number</label>
                          <input type="text" name="InputPicPhone" id="InputPicPhone" data-inputmask="'mask': ['9999-999999999']" data-mask class="form-control">
                          <p><small style="color:#888">* 6281-123456</small></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="about">
                    <div class="row">
                      <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                          <label>Address</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-home"></i></span>
                            <input type="text" class="form-control" name="InputCorpAddress" id="InputCorpAddress" placeholder="Jl. Kebon Sirih">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Office Phone</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" name="InputCorpPhone" id="InputCorpPhone" data-inputmask="'mask': ['(999) 99999999']" data-mask>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>Website</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                            <input type="text" class="form-control" name="InputCorpWeb" id="InputCorpWeb" placeholder="www.domain.com">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>City</label>
                          <input type="text" class="form-control" name="InputCorpCity" id="InputCorpCity" placeholder="Jakarta Pusat">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Country</label>
                          <input type="text" class="form-control" name="InputCorpCountry" id="InputCorpCountry" placeholder="Indonesia">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="preview">
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>Corporate Name</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-building-o"></i></span>
                            <input type="text" disabled class="form-control" id="InputCorpNameP">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-envelope"></i></span>
                            <input type="email" disabled class="form-control" id="InputPicEmailP">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-md-offset-1">
                        <div class="form-group">
                          <label>Firstname</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-user"></i></span>
                            <input type="text" disabled class="form-control" id="InputPicFNameP">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Lastname</label>
                          <input type="text" disabled class="form-control" id="InputPicLNameP">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Phone Number</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-mobile-phone"></i></span>
                            <input type="text" disabled class="form-control" id="InputPicPhoneP">
                          </div>
                        </div>
                      </div>
                    </div><div class="row">
                      <div class="col-md-6 col-md-offset-1">
                        <div class="form-group">
                          <label>Address</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-home"></i></span>
                            <input type="text" disabled class="form-control" id="InputCorpAddressP" placeholder="Jl. Kebon Sirih">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Office Phone</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-phone"></i></span>
                            <input type="text" disabled class="form-control" id="InputCorpPhoneP" data-inputmask="'mask': ['(999) 99999999']" data-mask>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4 col-md-offset-1">
                        <div class="form-group">
                          <label>NPWP Number</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-balance-scale"></i></span>
                            <input type="text" disabled id="InputTaxNoP" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Website</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background: #efefef"><i class="fa fa-globe"></i></span>
                            <input type="text" disabled id="InputCorpWebP" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>City</label>
                          <input type="text" disabled id="InputCorpCityP" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="wizard-footer">
                  <div class="pull-right">
                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd btn-sm btn-flat' name='next' value='Next' />
                    <input type='button' class='btn btn-finish btn-fill btn-success btn-wd btn-sm btn-flat' name='finish' value='Finish' />
                  </div>
                  <div class="pull-left">
                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm btn-flat' name='previous' value='Previous' />
                  </div>
                  <div class="clearfix"></div>
                </div>  
              </form>
            </div>
          </div> <!-- wizard container -->
        </div>
      </div> <!-- row -->
    </div><!-- /.box -->
  </div>
</div>