$(document).ready(function() {
//user_comment.js
    $("input[name='rating']").on('click', function() {
      rating = $(this).attr('value');
      $("#score").attr('value', rating);
    });

    /*End of select the rating*/



    $("#comment-submit").on('click', function() {
      /* Some variables */
      var uid = $('#uid').attr('value');
      var ownerUID = $("#owner-uid").attr('value');
      var goodsID = $("#goodsID").attr('value');
      
      textarea = $("#comment-textarea").val();
      length_textarea = textarea.length;

      /* Check the length of the input text */
      if (length_textarea < 25 || length_textarea > 200) {
        alert("字數不能小於25個，及不能多於200個");
        return false;

      } else if (uid == ownerUID) {
        alert("唔好意思，不允許自評");
        return false;

      } else {

        $.ajax({
          async:false,
          url: 'include/user-comment-check.inc.php',
          type: 'POST',
          data: {goodsID:goodsID, uid:uid},
          success: function (data) {
            status_check = data;
          }
        });

        /*check the status*/
        if (status_check == 1) {
          alert("唔好意思，你只能對此產品評價一次");
          return false;
        }
      }
        /*End of checking*/
  });
});
