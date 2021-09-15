$(document).ready(function() {

  $('.rating-container').hide();

  /*js programme of comment div slide down and up*/
  $('.comment-title-div').on('click', function() {
    $('.rating-container').slideToggle('fast');
  });
});
