<!-- date picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
<script type="text/javascript">
  $(function () {
    //Date range picker
    <?php
    if($date == ''){
        $dateJSFrom = date('m')."/1/".date('Y');
        $dateJSTo   = date('m/d/Y', strtotime('-1 day'));
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
        "maxDate": "<?=date('m/d/Y', strtotime('-1 day'))?>",
    }, function(start, end, label) {
      console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });
  });
</script>