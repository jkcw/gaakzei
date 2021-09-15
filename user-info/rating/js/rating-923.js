$(document).ready(function() {
  
    function changeAvgScoreColor () {
        
        var avgAttr = $(".avg-score").attr("value");
        var avg = parseInt(avgAttr);

        if (avg == 100) {
            var color = "rgb(2, 148, 73)";

        } else if (avg >= 80 && avg < 100) {
            var color = "rgb(145, 198, 68)";

        } else if (avg >= 50 && avg < 80) {
            var color = "rgb(178, 168, 147)";

        } else if (avg >= 25 && avg < 50) {
            var color = "rgb(248, 148, 28)";

        } else if (avg >= 0 && avg < 25) {
            var color = "rgb(247, 26, 38)";
        }

        $(".avg-score").css("color", color);

    }

    function loadMore (userID, start) {

      $.ajax({
        async:false,
        //做成同步
        url:"include/comment-loadmore.inc.php",
        data: {userID:userID, start:start},
        method: "POST",
        dataType:"TEXT",
        success:function(data){
          load_comment_output = data;
          }
        });
        return load_comment_output;

    }

    changeAvgScoreColor();

    /* img hide */
    $('.each-comment-img-container').hide();

    $(document).on('click', '.each-comment-img-p', function() {
      uid = $(this).attr('id');
      imgQ = $(this).attr('value');
  
      if (imgQ == 0) {
        $('#'+uid).html("唔好意思，此評論沒有照片。");
      } else {
        $('#img-div-'+uid).slideToggle("fast");
      }
  
    });


    /*img popup*/
    $(document).on('click', '.comment-img', function() {

      /*get id*/
      var imgID = $(this).attr('id');
      var src = $(this).attr('src');

      $("#popup-container").attr('style', 'display:block;');
      $('#comment-popup').attr('src', src);
    });

    /*close button*/
    $(document).on('click', '.popup-close', function() {
      $("#popup-container").attr('style', 'display:none;');
    });

    /*ajax of loading file*/
    $(document).on('click', '.button-loadmore', function() {

      /*select goods id*/
      var userID = $('.button-loadmore').attr('id');
      var startValue = $('.button-loadmore').attr('value');
      var newStartValue  = Number(startValue) +2;

      loadMore(userID, startValue);

      if (load_comment_output == 0) {
        $('.button-loadmore').attr('style', 'display:none;');
        $('.prev-comment-container-childDIV').append('<p class="comment-nomore">--已到底--<p>')
      } else {
        $('.prev-comment-container-childDIV').append(load_comment_output);
        $('.button-loadmore').attr('value', newStartValue);
        $('.each-comment-img-container').hide();
      }
    });
});