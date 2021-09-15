$(document).ready(function() {

  var email = $("#email_ajax").attr('value');
  var uid = $("#uid_ajax").attr('value');
  /* Get the value of user email*/
  var page = 1;
  load_data(page,email);
  /*function postID() {

    $.ajax({
      url:"include/pagination.inc.php",
      method:"POST",
      data:{id:id},
    });

  }*/
  function load_data(page,email)
  {
       $.ajax({
            url:"like-pagination.inc.php",
            method:"POST",
            data:{page:page, email:email, uid:uid},
            success:function(data){
                 $('#pagination_data').html(data);
            }
       });
  }

  function totalPages(uid)
  {
    /*var smallest = 1;
    var largest = 1;*/
      $.ajax({
          async:false,
          //做成同步
          url:"like-count-rows.inc.php",
          data: {uid:uid},
          method:"POST",
          dataType:"TEXT",
          success:function(data){
            result = data;
            }
          });
          return result;

  }

  $(document).on('click', '.prev', function() {
      var page = $(this).attr("id") ;

      if(page == 0) {
        return false;
      } else {
      load_data(page,email);
      }
  });

  $(document).on('click', '.next', function() {
      var page = $(this).attr("id") ;

      totalPages(uid);
      if(page > result) {
        return false;
      } else {
      load_data(page,email);
      }
  });

/*End of pagination*/
/*-------------------------------------------------------------------------------------------------------*/
/*Start of like system*/

$(document).on('click', '.latest-like-img', function() {
  var goodsID_check = $(this).attr('value');
  var status = $('#'+goodsID_check).attr('value');
  var src = $('#'+goodsID_check).attr('src');

  like_amount_a = $("#quantity"+goodsID_check).attr('value');
  like_amount = Number(like_amount_a);
  /*If there is no session*/
  if (status == 'login_first') {

    window.location.href = "https://www.gaakzei.com/INCLUDES/login?error=nologin";
    /*End of no session*/

/*---------------------------------------------------------------------------------------------------*/

    /*Start of non-liked*/
  } else if (src == 'https://www.gaakzei.com/like-inc/heart.svg') {

    var goodsID = $(this).attr('value');
    var email = $('#'+goodsID).attr('value');
    var change = $("#change"+goodsID).attr('value');

    $.ajax({
      url:"https://www.gaakzei.com/like-inc/like.inc.php",
      method:"POST",
      async:false,
      data:{goodsID0:goodsID, email0:email},
      success:function(){
        $("#"+goodsID).attr('src', 'https://www.gaakzei.com/like-inc/heart-pink.svg');

        if (change == 0) {
          // Img is non-clicked
          var new_amount_false2true = like_amount+1;
          $("#quantity"+goodsID).html(new_amount_false2true);

          // After the clicked
          $("#change"+goodsID).attr('value', '1');

        } else if (change == 1) {

          $("#quantity"+goodsID).html(like_amount);
          // After the clicked
          $("#change"+goodsID).attr('value', '0');
        } /*End of success*/
      }
    }); /*End of non-liked*/

/*---------------------------------------------------------------------------------------------------*/

        /*Start of liked*/
      } else if (src == 'https://www.gaakzei.com/like-inc/heart-pink.svg') {

        var goodsID_liked = $(this).attr('value');
        var email_liked = $('#'+goodsID_liked).attr('value');
        var change = $("#change"+goodsID_liked).attr('value');

        $.ajax({
          url:"https://www.gaakzei.com/like-inc/delete-like.inc.php",
          method:"POST",
          async:false,
          data:{email1:email_liked, goodsID1:goodsID_liked},
          success:function(){
            $("#"+goodsID_liked).attr('src', 'https://www.gaakzei.com/like-inc/heart.svg');

            if (change == 0) {
              // Img is non-clicked
              var new_amount_t2f = like_amount-1;
              $("#quantity"+goodsID_liked).html(new_amount_t2f);

              // After the clicked
              $("#change"+goodsID_liked).attr('value', '1');

            } else if (change == 1) {

              $("#quantity"+goodsID_liked).html(like_amount);
              // After the clicked
              $("#change"+goodsID_liked).attr('value', '0');
            }
          } /*End of success*/
        });
      } /*End of liked*/

});

});
