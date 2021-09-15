$(document).ready(function() {

    /*function*/
    function loadMoreComment(goodsID, start)
    {
        $.ajax({
            async:false,
            //做成同步
            url:"include/comment-loadmore.inc.php",
            data: {goodsID:goodsID, start:start},
            method: "POST",
            dataType:"TEXT",
            success:function(data){
              load_comment_output = data;
              }
            });
            return load_comment_output;
    }


    /*ajax of loading file*/
    $(document).on('click', '.button-loadmore', function() {

      /*select goods id*/
      var gID = $('.button-loadmore').attr('id');
      var startValue = $('.button-loadmore').attr('value');
      var newStartValue  = Number(startValue) +2;

      loadMoreComment(gID, startValue);

      if (load_comment_output == 0) {
        $('.button-loadmore').attr('style', 'display:none;');
        $('.prev-comment-container').append('<p class="comment-nomore">--已到底--<p>')
      } else {
        $('.prev-comment-container-childDIV').append(load_comment_output);
        $('.button-loadmore').attr('value', newStartValue);
      }
    });

});
