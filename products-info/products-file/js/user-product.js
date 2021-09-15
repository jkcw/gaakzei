$(document).ready(function() {
/*---------------------------------------------------------------------------------------------------------*/
    $(".like-div").on('click', function() {

       var idImg = $(".heart").attr('id');
       var src = $(".heart").attr('src');
       like_amount_a = $(".quantity").attr('value');
       like_amount = Number(like_amount_a);

        /*If there is no session*/
      if (idImg == 'login_first') {

        window.location.href = "https://www.gaakzei.com/INCLUDES/login?error=nologin";
        /*End of no session*/

/*------------------------------------------------------------------------------------------------------------*/

        /*Start of non-liked*/
      } else if (src == 'https://www.gaakzei.com/like-inc/heart.svg') {

        var email0 = $(".heart").attr('value');
        var goodsID0 = $(".heart").attr('id');
        $.ajax({

          url:"https://www.gaakzei.com/like-inc/like.inc.php",
          method:"POST",
          data:{email0:email0, goodsID0:goodsID0},
          async: false,
          success:function(){
            $(".heart").attr('src', 'https://www.gaakzei.com/like-inc/heart-pink.svg');


            if (typeof(true2false) == "undefined" || true2false == null) {
              // Img is non-clicked
              var new_amount_false2true = like_amount+1;
              $(".quantity").html(new_amount_false2true);

              // After the clicked
              false2true = 1;

            } else if (true2false == 1) {

              $(".quantity").html(like_amount);

              false2true = null;

            } /*End of success*/
          }
        }); /*End of non-liked*/

/*------------------------------------------------------------------------------------------------------------*/

        /*Start of liked*/
      } else if (src == 'https://www.gaakzei.com/like-inc/heart-pink.svg') {

        var email1 = $(".heart").attr('value');
        var goodsID1 = $(".heart").attr('id');

        $.ajax({

          url:"https://www.gaakzei.com/like-inc/delete-like.inc.php",
          method:"POST",
          data:{email1:email1, goodsID1:goodsID1},

          success:function(){
            $(".heart").attr('src', 'https://www.gaakzei.com/like-inc/heart.svg');

            if (typeof(false2true) == "undefined" || false2true == null) {
              // Img is non-clicked
              var new_amount_true2false = like_amount-1;
              $(".quantity").html(new_amount_true2false);

              // After the clicked
              true2false = 1;

            } else if (false2true == 1) {

              $(".quantity").html(like_amount);

              true2false = null;

            }
          } /*End of success*/
        });
      } /*End of liked*/

/*------------------------------------------------------------------------------------------------------------*/

    });
});
