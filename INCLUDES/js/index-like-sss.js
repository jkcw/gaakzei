$(document).ready(function() {

      /*like system of index page*/
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
            success:function(data){
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

      /*---------------------------------------------------------------------------------------------------*/
      /*---------------------------------------------------------------------------------------------------*/
      /*---------------------------------------------------------------------------------------------------*/
      /*---------------------------------------------------------------------------------------------------*/
      /*---------------------------------------------------------------------------------------------------*/

      /*like system of index page for hot products*/
      $(document).on('click', '.hot-like-img', function() {
        var goodsID_check = $(this).attr('value');
        var status = $('#hot-'+goodsID_check).attr('value');
        var src = $('#hot-'+goodsID_check).attr('src');

        like_amount_a = $("#hot-quantity"+goodsID_check).attr('value');
        like_amount = Number(like_amount_a);
        /*If there is no session*/
        if (status == 'login_first') {

          window.location.href = "https://www.gaakzei.com/INCLUDES/login?error=nologin";
          /*End of no session*/

    /*---------------------------------------------------------------------------------------------------*/

          /*Start of non-liked*/
        } else if (src == 'https://www.gaakzei.com/like-inc/heart.svg') {

          var goodsID = $(this).attr('value');
          var email = $('#hot-'+goodsID).attr('value');
          var change = $("#hot-change"+goodsID).attr('value');

          $.ajax({
            url:"https://www.gaakzei.com/like-inc/like.inc.php",
            method:"POST",
            async:false,
            data:{goodsID0:goodsID, email0:email},
            success:function(){
              $("#hot-"+goodsID).attr('src', 'https://www.gaakzei.com/like-inc/heart-pink.svg');

              if (change == 0) {
                // Img is non-clicked
                var new_amount_false2true = like_amount+1;
                $("#hot-quantity"+goodsID).html(new_amount_false2true);

                // After the clicked
                $("#hot-change"+goodsID).attr('value', '1');

              } else if (change == 1) {

                $("#hot-quantity"+goodsID).html(like_amount);
                // After the clicked
                $("#hot-change"+goodsID).attr('value', '0');
              } /*End of success*/
            }
          }); /*End of non-liked*/

    /*---------------------------------------------------------------------------------------------------*/

              /*Start of liked*/
            } else if (src == 'https://www.gaakzei.com/like-inc/heart-pink.svg') {

              var goodsID_liked = $(this).attr('value');
              var email_liked = $('#hot-'+goodsID_liked).attr('value');
              var change = $("#hot-change"+goodsID_liked).attr('value');

              $.ajax({
                url:"https://www.gaakzei.com/like-inc/delete-like.inc.php",
                method:"POST",
                async:false,
                data:{email1:email_liked, goodsID1:goodsID_liked},
                success:function(){
                  $("#hot-"+goodsID_liked).attr('src', 'https://www.gaakzei.com/like-inc/heart.svg');

                  if (change == 0) {
                    // Img is non-clicked
                    var new_amount_t2f = like_amount-1;
                    $("#hot-quantity"+goodsID_liked).html(new_amount_t2f);

                    // After the clicked
                    $("#hot-change"+goodsID_liked).attr('value', '1');

                  } else if (change == 1) {

                    $("#hot-quantity"+goodsID_liked).html(like_amount);
                    // After the clicked
                    $("#hot-change"+goodsID_liked).attr('value', '0');
                  }
                } /*End of success*/
              });
            } /*End of liked*/

    /*---------------------------------------------------------------------------------------------------*/

      });
});
