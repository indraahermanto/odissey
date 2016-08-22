<!-- InputMask -->
<script src="<?=base_url().'assets/plugins/input-mask/jquery.inputmask.js'?>"></script>
<script src="<?=base_url().'assets/plugins/input-mask/jquery.inputmask.date.extensions.js'?>"></script>
<script src="<?=base_url().'assets/plugins/input-mask/jquery.inputmask.extensions.js'?>"></script>

<!-- DataTables -->
<script src="<?=base_url().'assets/plugins/datatables/jquery.dataTables.min.js'?>"></script>
<script src="<?=base_url().'assets/plugins/datatables/dataTables.bootstrap.min.js'?>"></script>
<script>
  $(document).ready(function(){
    $(".partnersSelect").select2();
    $("[data-mask]").inputmask();
  });
</script>