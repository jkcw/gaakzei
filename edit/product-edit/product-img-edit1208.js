$(document).ready(function() {

  /*function of file preview*/
  function filePreview(input , id) {

      if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img_'+id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
  }

  function checkImgBox() {

      var box_total = '';

      for (var i = 0; i < 6; i++) {

        var style = $('#li-'+i).attr('style');

        /*check*/
        if (style == 'display:none;') {

        } else {
          box_total++;
        }
      } /*end of loop*/
      return box_total;
  }

  /*total new uploader box*/
  function checkUploaderBox() {

      var box_total_uploader = 0;

      for (var i = 0; i < 6; i++) {

        var img_src = $('#img_'+i).attr('src');
        var li_style = $('#li-'+i).attr('style');

        /*check*/
        if (img_src == 'https://www.gaakzei.com/system-img/upload-button.svg' && li_style != 'display:none;') {
          box_total_uploader++;
        } else {
        }
      } /*end of loop*/
      //return box_total_uploader;
      return box_total_uploader;
  }

  /*get lowestID*/
  function lowestID() {

      var display_array = [];

      for (var i = 0; i < 6; i++) {

        var style = $('#li-'+i).attr('style');

        /*check*/
        if (style == 'display:none;') {
          var selector = i;
          display_array.push(selector);
        } else {
        }
      } /*end of loop*/
      var lowest_id = Math.min.apply(Math,display_array);
      return lowest_id;
  }
/*============================================================================================================================================================*/

  /*When user change the input file*/
  $(document).on('change', '.file-input', function() {

      var img_id = $(this).attr('id');
      /*src of the uploader*/
      var src = $('#img_'+img_id).attr('src');

      var number_id = Number(img_id);

      var totalCheckBoxNow = checkImgBox();

      /*if user clicked the new uploader box*/
      if (src == 'https://www.gaakzei.com/system-img/upload-button.svg') {

        filePreview(this , img_id);
        $('#img-bool'+img_id).attr('value', '1');
        $('#button-'+img_id).attr('value', '1');
        $('#button-'+img_id).html("??????");

        /*check how many left*/
        if (totalCheckBoxNow == 6) {
          /*There are 6 boxes existed*/

          /*There are space left*/
        } else {
          var lowestID_box = lowestID();
          var img_li = $('.img_li');
          $('#li-'+lowestID_box).attr('style', '');/*disable the display:none;*/
          $('#li-'+lowestID_box).insertAfter(img_li.last());
        }

        /*If user clicked the existed img box*/
      } else if (img_id == 0) {
        filePreview(this , img_id);

      } else {
        filePreview(this , img_id);
        $('#img-bool'+img_id).attr('value', '1');
        $('#button-'+img_id).attr('value', '1');
        $('#button-'+img_id).html("??????");
      }


  });

/*============================================================================================================================================================*/

    /*delete button*/
    $(document).on('click', '.img-button', function() {

        /*get the img id*/
        var img_attr = $(this).attr('id');
        var img_delete_value = $(this).attr('value');
        var img_id_split = img_attr.split("-");
        var img_delete_id = img_id_split[1];

        /*check the button status*/
        var bool = $('#img-bool'+img_delete_id).attr('value');
        
        /*origin selector*/
        var origin_value = $('#img-origin'+img_delete_id).attr('value');

        var total_uploader_box = checkUploaderBox();

        /*if the user clicked the cover button*/
        if (img_delete_id == 0) {

          /*if there are no new uplaoder left*/
        } else if (bool == 0) {

        } else if (total_uploader_box == 0) {
          $('#li-'+img_delete_id).remove();
          $(".img_ul").append("<li id='li-"+img_delete_id+"' class='img_li'><div class='img-div'><label for='"+img_delete_id+"' class='custom-file-upload' value='"+img_delete_id+"'><img class='img_product' id='img_"+img_delete_id+"' src='https://www.gaakzei.com/system-img/upload-button.svg' /><button id='button-"+img_delete_id+"' class='img-button' type='button'>??????</button></label><input name='img-upload"+img_delete_id+"' class='file-input' id='"+img_delete_id+"' type='file'/><input name='img-bool"+img_delete_id+"' id='img-bool"+img_delete_id+"' type='hidden' value='0'/></div></li>");

            /*check the origin*/
            if (origin_value == 1) {
              /*get the value of the origin delete record*/
              var delete_record_value = $('#delete-check').attr('value');
              $('#delete-check').attr('value', delete_record_value+'-'+img_delete_id)
            }

          /*if there are uploader existed*/
        } else {
          $('#li-'+img_delete_id).remove();
          $(".img_ul").append("<li id='li-"+img_delete_id+"' style='display:none;' class='img_li'><div class='img-div'><label for='"+img_delete_id+"' class='custom-file-upload' value='"+img_delete_id+"'><img class='img_product' id='img_"+img_delete_id+"' src='https://www.gaakzei.com/system-img/upload-button.svg' /><button id='button-"+img_delete_id+"' class='img-button' type='button'>??????</button></label><input name='img-upload"+img_delete_id+"' class='file-input' id='"+img_delete_id+"' type='file'/><input name='img-bool"+img_delete_id+"' id='img-bool"+img_delete_id+"' type='hidden' value='0'/></div></li>");

            /*check the origin*/
            if (origin_value == 1) {
              /*get the value of the origin delete record*/
              var delete_record_value = $('#delete-check').attr('value');
              $('#delete-check').attr('value', delete_record_value+'-'+img_delete_id)
            }
        }
    });
});
