<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url().'assets/plugins/select2/select2.min.css'?>">

<div class="col-sm-5 col-sm-offset-1">
  <div class='form-group'>
    <label>Input Number</label>
    <div class="input-group">
      <input type="text" class="form-control" required id="inputNumberN" name="inputNumberN" placeholder="08123456xxx / 02198765xxx">
      <span class="input-group-btn">
        <button class="btn btn-success btn-flat" id="set" type="button">
          <span id="seticon" class="fa fa-check"></span>
        </button>
      </span>
    </div><!-- /input-group -->
  </div>
</div>

<div class="col-sm-7"></div>
<div class="provider2"></div>

<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // $(".provider2").css('display', 'none');
    $('#set').click(function(){
      var number = $('#inputNumberN').val();
      var len    = number.length;
      var set    = $('#seticon').hasClass("fa-check");

      if(number != ""){
        $.ajax({
          url: '<?php echo site_url('ajax/checkNewNumber'); ?>',
          type: 'POST',
          data: "number="+number,
          cache: false,
          success: function(msg){
            if(msg == 'true'){
              if(!$.isNumeric(number) | len < 10 | len > 13){
                alert('Nomor tidak valid!');
                $('#inputNumberN').focus();
              }else{
                if(set){
                  var newNumber = $('#inputNumberN').val();
                  $('#set').removeClass("btn-success").addClass('btn-warning');
                  $('#seticon').removeClass("fa-check").addClass('fa-pencil');
                  $('#inputNumberN').prop('readonly', true);
                  $('#submit').prop('disabled', false);
                  $.ajax({
                    url: '<?php echo site_url('ajax/getProvider'); ?>',
                    type: 'POST',
                    data: "number="+newNumber,
                    cache: false,
                    success: function(abc){
                      $(".provider2").html(abc);
                    }
                  });
                } else {
                  $('#set').removeClass("btn-warning").addClass('btn-success');
                  $('#seticon').removeClass("fa-pencil").addClass('fa-check');
                  $('#inputNumberN').prop('readonly', false);
                  $('#submit').prop('disabled', true);
                }
              }
            }else{
              $('#inputNumberN').prop('readonly', false);
              $('#submit').prop('disabled', true);
              alert('Nomor sudah terdaftar atas user '+msg+'!');
              $('#inputNumberN').focus();
            }
          }
        });
      }else{
        alert('Nomor harus diisi!');
      }
    });
  });
</script>