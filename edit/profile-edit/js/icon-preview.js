$(document).ready(function() {

    /*function of file preview*/
    function filePreview(input) {

        if (input.files && input.files[0]) {

          var reader = new FileReader();

          reader.onload = function(e) {
            $('#iconUploadForm + img').remove();
            $('#icon-container').attr('src',e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
    }

    $('#icon_file').change( function() {

      filePreview(this);
    });

});

