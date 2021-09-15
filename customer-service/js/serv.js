$(document).ready(function(){
    $(".myDIV").hide();
       $(document).on("click", "#show", function(){
            $("#button_container").fadeOut(100); 
            $(".myDIV").fadeIn(100);
       });
        $(document).on("click", "#hide", function(){
            $(".myDIV").fadeOut(100);
            $("#button_container").fadeIn(100); 
        });
});
        