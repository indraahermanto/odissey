<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>
<!-- Compose -->
<script src="<?=base_url().'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'?>"></script>
<!-- date picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=base_url().'assets/plugins/datepicker/bootstrap-datepicker.js'?>"></script>
<script src="<?=base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>


<script>
  $(function () {
    //Add text editor
    $("#inputDetActivity").wysihtml5();
    $(".select2").select2();
    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "dd-mm-yyyy",
        startDate: "01-01-2016",
        todayBtn: "linked"
    });

    <?php
    if(!isset($date)) $date = "";
    if($date == ""){
        $dateJSFrom = date('m')."/1/".date('Y');
        $dateJSTo   = date('m/d/Y', strtotime('now'));
    }else{
        $d = explode(' - ', $date);
        $dateJSFrom = $d[0];
        $dateJSTo = $d[1];
    }
    ?>
    $('#date_range').daterangepicker({
        "startDate": "<?=$dateJSFrom?>",
        "endDate": "<?=$dateJSTo?>",
        "minDate": "<?=date('m/d/Y', strtotime('01/01/2015'))?>",
        "maxDate": "<?=date('m/d/Y', strtotime('today'))?>",
    }, function(start, end, label) {
      console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });
  });
</script>