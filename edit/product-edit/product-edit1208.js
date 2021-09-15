$(document).ready(function() {
  
  var img = $('#quantity').attr('value');

  $('.img-wrap .close').on('click', function() {
      var id = $(this).closest('.img-wrap').find('img').data('id');
      $('#'+id).hide();
      alert('remove picture: ' + id);
  });


});

