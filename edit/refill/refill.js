$(document).ready(function() {

  $(".update").on('click', function(event) {
    event.preventDefault();

    var gid = $(this).val();
    var uid = $("."+gid).val();
    /*End of fetching goodsID and userID*/

    var quantity = $(".input"+gid).val();

    $.ajax({
      url:"refill.inc.php",
      method:"POST",
      data:{gid:gid, uid:uid, quantity:quantity},
      success:function(data){
        $("#date"+gid).html("成功");
        $("#quantity"+gid).html(quantity);

      }
    });
  });
});
