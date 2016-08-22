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
<!-- BlueIMG -->
<!-- <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script> -->
<script src="<?=base_url().'assets/plugins/blueimp/js/jquery.blueimp-gallery.min.js'?>"></script>
<script src="<?=base_url().'assets/plugins/blueimp/js/bootstrap-image-gallery.js'?>"></script>
<script src="<?=base_url().'assets/plugins/blueimp/js/demo.js'?>"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
    $("#inputBayar").fileinput({
        showUpload: false,
        //showPreview: false,
        allowedFileExtensions: ["jpg|gif|png"],
        layoutTemplates: {
            main1: "{preview}\n" +
            "<div class=\'input-group {class}\'>\n" +
            "   <div class=\'input-group-btn\'>\n" +
            "       {browse}\n" +
            "       {upload}\n" +
            "   </div>\n" +
            "   {caption}\n" +
            "   <div class=\'input-group-btn\'>\n" +
            "       {remove}\n" +
            "   </div>\n" +
            "</div>"
        }
    });
    $("#inputSPB").change(function(){
      var doc_number = $("#inputSPB").val();
      $.ajax({
        url: '<?php echo site_url('ajax/getAmountSPB'); ?>',
        type: 'POST',
        data: "doc_number="+doc_number,
        cache: false,
        success: function(msg){
          $("#amountSPB").val(msg);
        }
      });
      if(doc_number != "")
        $("#sub").prop('disabled', false);
    });
  });
</script>