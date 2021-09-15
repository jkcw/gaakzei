$(document).ready(function() {

    /* Profile rating js file */
    
    function ratingBackground (rating) {

        if (rating == 100) {
            var color = "rgb(2, 148, 73)";

        } else if (rating >= 80 && rating < 100) {
            var color = "rgb(145, 198, 68)";

        } else if (rating >= 50 && rating < 80) {
            var color = "rgb(178, 168, 147)";

        } else if (rating >= 25 && rating < 50) {
            var color = "rgb(248, 148, 28)";

        } else if (rating >= 0 && rating < 25) {
            var color = "rgb(247, 26, 38)";
        }

        return color;
    }

    function changeBackground (colorCB) {

        $(".rating-info-div").css("background-color", colorCB);
        $(".rating-info-div").css("border", "1px");
        $(".rating-info-div:hover").css("background-color", "#FFF");
    }

    /* Select the avg score */
    var scoreAttr = $("#avg-rating").attr("value");
    var score = parseInt(scoreAttr);
    
    var color = ratingBackground(score);

    changeBackground(color);

    $(".rating-info-div").mouseover( function() {
        $(".rating-info-div").css("background-color", "#FFF");
        $(".rating-info-p").css("color", "#000000");
    });

    $(".rating-info-div").mouseout( function() {
        $(".rating-info-div").css("background-color", color);
        $(".rating-info-p").css("color", "#ECECEC");
    });
    
})