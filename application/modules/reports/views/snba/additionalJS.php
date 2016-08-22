<script type="text/javascript">
  $(function () {
  	$('.tableTrxReport').css('display', 'none');
    $('.btn-show-order').click(function(){
      if($('.tableTrxReport').css('display') == 'none'){
        $('.tableTrxReport').show(500);
        $('.btn-show-order').val('Hide Detail Transaction');
      } else {
        $('.tableTrxReport').hide(500);
        $('.btn-show-order').val('Show Detail Transaction');
      }
    });
  })
</script>