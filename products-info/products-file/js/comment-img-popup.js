$(document).ready(function() {

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
    
});
