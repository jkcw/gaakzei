$(function() {

  $("#jsNewPwd").hide();
  $("#jsConfirmPwd").hide();

  var check_pwd_error = false;
  var check_retype_error = false;

  $("#NewPwd").focusout(function() {

    check_pwd();

  });

  $("#ConfirmPwd").focusout(function() {

    check_retype();

  });

  function check_pwd() {

    var pwd_length = $("#NewPwd").val().length;

    if (pwd_length < 8) {
      $("#jsNewPwd").show();
      check_pwd_error = true;
      
    } else {
      $("#jsNewPwd").hide();

    }
  }

  function check_retype() {

    var pwd_st = $("#NewPwd").val();
    var pwd_nd = $("#ConfirmPwd").val();

    if (pwd_st != pwd_nd) {
      $("#jsConfirmPwd").show();
      check_retype_error = true;

    } else {
      $("#jsConfirmPwd").hide();

    }
  }
  $("#updatePwd").submit(function() {

     check_pwd_error = false;
     check_retype_error = false;

     check_pwd();
     check_retype();

     if (check_pwd_error == false && check_retype_error == false) {

       return true;
     } else {

       return false;
     }

  });
});
