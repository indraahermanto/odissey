<!-- date picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?=base_url().'assets/plugins/daterangepicker/daterangepicker.js'?>"></script>
<script type="text/javascript">
  $(function () {
    //Date range picker
    $('#date_range').daterangepicker({
      locale: {
        format: 'MM/DD/YYYY',
      },
      "minDate": "<?=date('m/d/Y', strtotime('01/01/2015'))?>",
      "maxDate": "<?=date('m/d/Y', strtotime('-1 day'))?>",
    }, 
    function(start, end, label) {
      
    });
  });
</script>