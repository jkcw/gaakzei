$(document).ready(function() {

    

    $(".choices").on('click', function() {

        var css_display_value = $(".choices__list--dropdown").attr("style");

        if (css_display_value == 'display:none;') {

            $(".choices__list--dropdown").attr("style", "display:block;");

        } else {
            $(".choices__list--dropdown").attr("style", "display:none;");
        }
        
    });

    $("#choices-option-bn-item-choice-1").on('click', function() {

        $("#header-option").attr("value", "Products");
        $("#box-value").html("Products");

    });

    $("#choices-option-bn-item-choice-2").on('click', function() {

        $("#header-option").attr("value", "Users");
        $("#box-value").html("Shops");

    });

});