<!-- Select2 -->
<script src="<?=base_url().'assets/plugins/select2/select2.full.min.js'?>"></script>
<!-- Krajee File-Input -->
<!-- canvas-to-blob.min.js is only needed if you wish to resize images before upload.
     This must be loaded before fileinput.min.js -->
<script src="<?=base_url().'assets/plugins/krajee-fileinput/js/plugins/canvas-to-blob.min.js'?>" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
     This must be loaded before fileinput.min.js -->
<script src="<?=base_url().'assets/plugins/krajee-fileinput/js/plugins/sortable.min.js'?>" type="text/javascript"></script>
<!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
     This must be loaded before fileinput.min.js -->
<script src="<?=base_url().'assets/plugins/krajee-fileinput/js/plugins/purify.min.js'?>" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="<?=base_url().'assets/plugins/krajee-fileinput/js/fileinput.min.js'?>"></script>

<script>
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
    
    //Initialize Select2 Elements
    $(".select2").select2();
    $("#inputFP").fileinput({
        showUpload: false,
        showPreview: false,
        allowedFileExtensions: ["pdf"],
        layoutTemplates: {
            main1: "{preview}\n" +
            "<div class=\'input-group {class}\'>\n" +
            "   <div class=\'input-group-btn\'>\n" +
            "       {browse}\n" +
            "       {upload}\n" +
            "       {remove}\n" +
            "   </div>\n" +
            "   {caption}\n" +
            "</div>"
        }
    });
    $("#inputReport").change(function(){
      var doc_number = $("#inputReport").val();
      $.ajax({
        url: '<?php echo site_url('ajax/getAmountReport'); ?>',
        type: 'POST',
        data: "doc_number="+doc_number,
        cache: false,
        success: function(msg){
          $("#amountReport").val(msg);
        }
      });
      if(doc_number != "")
        $("#sub").prop('disabled', false);
    });
  });
</script>