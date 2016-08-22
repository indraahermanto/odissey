<?php /*
<script type="text/javascript">

	$(document).ready(function(){
		$('.pay-debt').click(function(){
			var name = $("#inputUserName").val();
			$.ajax({
        url: '<?php echo site_url('ajax/modalPayment'); ?>',
        type: 'POST',
        data: "username="+name,
        cache: false,
        success: function(msg){
          $(".modal-payments-content").html(msg);
        }
      });
		});
	});
</script>
*/
?>



<script type="text/javascript">

var isOldSafari=(navigator.userAgent.search(/Safari\/(85|1\d\d)\D/i)!=-1);

function dss_addEvent(el,etype,fn) {
  var tN = el.tagName?el.tagName.toLowerCase():'';
  if(el.addEventListener && (!window.opera || opera.version) &&
  (etype!='load') &&(!isOldSafari || ((tN!='input') && (tN!='textarea')))) {
    el.addEventListener(etype,fn,false);
  } else if(el.attachEvent) {
    el.attachEvent('on'+etype,fn);
  } else {
    var tempFunc;
    if(typeof el['on'+etype] == "function") tempFunc=el['on'+etype];
    el['on'+etype] = function() {
      if(typeof tempFunc == "function") tempFunc();
      if(typeof fn == "function") fn();
    }
  }
}

if(typeof(Number)!='undefined'&&typeof(Number.prototype)!='undefined'){
  if(typeof(Number.prototype.toFixed)=='undefined'){
  // for IE versions older than 5.5 and Netscape 4.x
  // for this script it's only used in IE5.x, though because of the DOM1 
  // support requirement
    Number.prototype.toFixed=function(d){
      var n=this;
      d=(d||((d==0)&&(typeof(d)=='number')))?d:2;
      var f=Math.pow(10,d);
      n=((Math.round(n*f)/f)+Math.pow(10,-(d+1)))+'';
      return n.substring(0,(d==0)?n.indexOf('.'):n.indexOf('.')+d+1);
    }
  }
}

var checkboxItemValue = {
  <?php
  foreach ($orders as $key => $order) {
    echo "'price".$key."':'".$order->rest_amount."',";
  }
  ?>
};

function updateTotal() {
  if(!document.getElementsByTagName || !document.createTextNode) return;
  var cbs = document.getElementById('priceGroup').getElementsByTagName('input');
  var total = 0,num;
  for(var i=0;i<cbs.length;i++) {
    if(cbs[i].checked) {
      num=parseFloat(checkboxItemValue[cbs[i].id]);
      if(!isNaN(num)) total += num;
      $('#payThis').prop('disabled', false);
    }
  }
  var b = document.getElementById('priceGroupTotal');
  while(b.firstChild) b.removeChild(b.firstChild); // removes children of "b"
  // b.appendChild(document.createTextNode('Total:  '+total.toFixed(2)));
  $('#InputAmountPay').val(total.toFixed(0));
}

function addEventsToCBGroup1() {
  if(!document.getElementsByTagName || !document.createTextNode) return;
  var cbs = document.getElementById('priceGroup').getElementsByTagName('input');
  for(var i=0;i<cbs.length;i++) {
    dss_addEvent(cbs[i],'click',updateTotal);
  }
}

// IE5+/Win, Firefox, Netscape 6+, Opera 7+, Safari, IE5/Mac, iCab 3
dss_addEvent(window,'load',addEventsToCBGroup1);
dss_addEvent(window,'load',updateTotal);
// -->

$(document).ready(function(){

  $('#payThis').prop('disabled', 'true');
  $('#selectAll').click(function() {
    var totalAmount = $('#totalAmount').val();
    if($('#selectAll').val() == 'All') {
      $('.checkbox').each(function() {
          this.checked = true;
      })
      $('#selectAll').val('Undo');
      $('#payThis').prop('disabled', false);
      $('#InputAmountPay').val(totalAmount);
    }else{
      $('.checkbox').each(function() {
          this.checked = false;
      });
      $('#selectAll').val('All');
      $('#payThis').prop('disabled', true);
      $('#InputAmountPay').val('0');
    }
  });

  $('#paymentForm').submit(function(){
    // var wallet = 0;
    // var totalPayment = $('#paymentAmount').val();
    // if(totalPayment > wallet){
    //   alert('Gagal: Saldo wallet hanya '+wallet+'.');
    //   return false;
    // }
    // var amount = $('#InputAmount').val();
    // var totalPayment = $('#InputAmountPay').val();
    // if(amount > wallet){
    //   alert('Gagal: Saldo wallet hanya '+wallet+'.');
    //   return false;
    // }
  });
});
</script>