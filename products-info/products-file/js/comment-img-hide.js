$(document).ready(function() {

  /*hide comment img*/
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
});
