$(document).ready(function() {
    
    function able_submit(){
        $("#signup-submit").removeAttr("disabled");
        $("#signup-submit").attr("style", "opacity: 1; cursor: pointer;");
      }

    function disable_submit(){
        $("#signup-submit").attr("disabled", true);
        $("#signup-submit").attr("style", "opacity: 0.2; cursor: not-allowed;");
    }

    $("#usr-name-input").keyup(function(){

        var usr_name = $("#usr-name-input").val();
        var usr_name_len = usr_name.length;
        
        $.ajax({
            url:"https://www.gaakzei.com/login/includes/signup-js-usrname-check.inc.php",
            method:"POST",
            async:false,
            data:{usr_name:usr_name},
            success:function(data){
                
                if (data == 0) {
                    $("#usr-name-not-available").attr("style", "display:none");
                } else {
                    $("#usr-name-not-available").attr("style", "display:block");
                }
            }
          });

        if (usr_name.match(/([a-zA-Z])/) || usr_name.match(/([0-9])/)) {

            if (usr_name.match(/([!,%,&,@,#,$,^,*,?,~])/)) {
                $("#username-not-allow").attr("style", "display:block");
                disable_submit();
            } else {
                $("#username-not-allow").attr("style", "display:none");
                able_submit();
            }

            } else {

            $("#username-not-allow").attr("style", "display:block");
            disable_submit();
            
        }

        if (usr_name_len < 6 || usr_name_len > 15) {
            $("#username-not-allow-len").attr("style", "display:block");
            disable_submit();
        } else {
            $("#username-not-allow-len").attr("style", "display:none");
            able_submit();
        }
        
    });

    $("#mail-repeat").keyup(function(){

        var mail_st = $("#mail-st").val();
        var mail_repeat = $("#mail-repeat").val();
        
        if (mail_st == mail_repeat) {
            $("#email-not-same").attr("style", "display:none");
            able_submit();
            
        } else {
            $("#email-not-same").attr("style", "display:block");
            disable_submit();
        }
        
    });
    
    $("#mail-st").keyup(function(){

        var mail_st = $("#mail-st").val();
        var mail_repeat = $("#mail-repeat").val();

        $.ajax({
            url:"https://www.gaakzei.com/login/includes/signup-js-email-check.inc.php",
            method:"POST",
            async:false,
            data:{mail_st:mail_st},
            success:function(data){
                
                if (data == 0) {
                    $("#email-not-available").attr("style", "display:none");
                } else {
                    $("#email-not-available").attr("style", "display:block");
                }
            }
          });
        
        if (mail_st == mail_repeat) {
            $("#email-not-same").attr("style", "display:none");
            able_submit();

        } else {
            $("#email-not-same").attr("style", "display:block");
            disable_submit();
        }
        
    });


    $("#pwd-repeat").keyup(function(){

        var pwd_st = $("#pwd-st").val();
        var pwd_repeat = $("#pwd-repeat").val();
        
        if (pwd_st == pwd_repeat) {
            $("#pwd-not-same").attr("style", "display:none");
            able_submit();

        } else {
            $("#pwd-not-same").attr("style", "display:block");
            disable_submit();
        }
        
    });

    $("#pwd-st").keyup(function(){

        var pwd_st = $("#pwd-st").val();
        var pwd_repeat = $("#pwd-repeat").val();
        
        var pwd_len = pwd_st.length;

        if (pwd_st == pwd_repeat) {
            $("#pwd-not-same").attr("style", "display:none");
            able_submit();

        } else {
            $("#pwd-not-same").attr("style", "display:block");
            disable_submit();
        }

        if (pwd_len < 8 || pwd_len > 20) {

            $("#pwd-not-allow").attr("style", "display:block");
            disable_submit();

        } else {

            $("#pwd-not-allow").attr("style", "display:none");
            able_submit();

        }

        if (pwd_st.match(/([a-z])/) && pwd_st.match(/([0-9])/) && pwd_st.match(/([A-Z])/)) {

            $("#pwd-not-allow-type").attr("style", "display:none");
            able_submit();

        } else {

            $("#pwd-not-allow-type").attr("style", "display:block");
            disable_submit();

        }
        
    });


    $(document).on('click', '#signup-submit', function() {
        
        var usr_name_status = $("#usr-name-not-available").attr("style");
        var email_status = $("#email-not-available").attr("style");

        if (usr_name_status == 'display:block') {
            alert("用戶名已被注冊");
            return false;
        } else {

        }

        if (email_status == 'display:block') {
            alert("Email已被注冊");
            return false;
        } else {

        }
    });

});