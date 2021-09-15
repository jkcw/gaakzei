$(document).ready(function() {

  $(document).on('change', '#img0', function() {

    var property = document.getElementById("img0").files[0];
    var img_name = property.name;
    var img_extention = img_name.split(".").pop().toLowerCase();

    if (jQuery.inArray(img_extention, ['gif', 'png', 'jpeg', 'jpg']) == -1) {

      alert("只允許gif,png,jpeg.jpg檔案");

    }

    var img_size = property.size;

    if (img_size > 2000000) {

      alert("檔案大小唔可以大過2MB");

    } else {

      var form_data = new FormData();
      form_data.append("file", property); // Need to check
      $.ajax({
          url:"img_upload.inc.php",
          method:"POST",
          data:form_data,
          contentType:false, // Need to check
          cache:false, // Need to check
          processData:false, // Need to check
          beforeSend:function(){ // Execute first
            $('#img0_upload').html("<label class='text-success'>圖片上傳中...</label>")
          },
          success:function(data){
            $('#img0_upload').html(data);
          }
      })
    }
  });

  changed = false;
  
  $("#0").on('change', function() { 
    var file = this.files[0];
    if (jQuery.type(file) != "undefined") {
      changed = true;
    } else {
      changed = false;
      $('#img_0').attr('src', 'https://www.gaakzei.com/products-system/svg/upload-button.svg');
    }
  }); 

  $(document).on('click', '.update-details-submit', function() {
    
    if (changed == false) {
      alert("必須上傳第一張相片");
      return false;
    } else {
    }
  });
  
});
