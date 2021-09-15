$(document).ready(function() {

    $("[name='follow']").on('click', function() {
      var status = $(this).attr('id');

       followers = $("#num_followers").attr('value');
       num_followers = Number(followers);
       ownerID = $("#ownerID").attr('value');
       followerID = $("#followerID").attr('value');

      /*If no session*/
      if (status == 'no_session') {
        window.location.href = "https://www.gaakzei.com/INCLUDES/login?error=nologin";

        /*End of no session*/
      } else if (status == 'no_follow') {

        $.ajax({
          url:"https://www.gaakzei.com/user-info/follow-inc/follow.inc.php",
          method:"POST",
          cache: false,
          data:{ownerID:ownerID, followerID:followerID},

          /*Success*/
          success:function(data){
            $("[name='follow']").html("追蹤中");
            $("[name='follow']").attr('id', 'has_follow');
            var new_t2f = typeof(t2f);
            /*Un-clicked*/
            if (new_t2f == 'undefined' || t2f == null) {
              var new_num_f = num_followers+1;
              $("#new_num_f").html(new_num_f);

              f2t = 1;
              /*Clicked*/
            } else if (t2f == 1) {

              $("#new_num_f").html(num_followers);

              f2t = null;
            }
          }, /*End of success*/
        });


      } else if (status == 'has_follow') {

        $.ajax({
          url:"https://www.gaakzei.com/user-info/follow-inc/un-follow.inc.php",
          method:"POST",
          cache: false,
          data:{ownerID:ownerID, followerID:followerID},

          /*Success*/
          success:function(data){
            $("[name='follow']").html("追蹤");
            $("[name='follow']").attr('id', 'no_follow');
            var new_f2t = typeof(f2t);
            /*Clicked*/
            if (new_f2t == 'undefined' || f2t == null) {
              var new_num_f_b = num_followers-1;
              $("#new_num_f").html(new_num_f_b);

              t2f = 1;
              /*Clicked*/
            } else if (f2t == 1) {

              $("#new_num_f").html(num_followers);

              t2f = null;
            }
          } /*End of success*/
        });

      }
    });

});
