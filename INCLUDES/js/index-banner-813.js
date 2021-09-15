$(document).ready(function() {

    /*js of banner*/
    var bannerStatus = 1;
    var bannerTimer = 4000;

    bannerLoop();

    /*function*/
    /*1*/
    function bannerLoop() {

      if (bannerStatus === 1) {
        $('#ban2').css('opacity', '0');

        setTimeout(function() {
          $('#ban1').css('right', '0px');
          $('#ban1').css('z-index', '1000');
          $('#ban2').css('right', '-815.48px');
          $('#ban2').css('z-index', 'z-index : 1500');
          $('#ban3').css('right', '815.48px');
          $('#ban3').css('z-index', '500');
        } ,500);

        setTimeout(function() {
        $('#ban2').css('opacity', '1');
      } ,1000);

        bannerStatus = 2;
      }

      /*2*/
      else if (bannerStatus === 2) {
        $('#ban3').css('opacity', '0');

        setTimeout(function() {
          $('#ban2').css('right', '0px');
          $('#ban2').css('z-index', '1000');
          $('#ban3').css('right', '-815.48px');
          $('#ban3').css('z-index', 'z-index : 1500');
          $('#ban1').css('right', '815.48px');
          $('#ban1').css('z-index', '500');
        } ,500);

        setTimeout(function() {
        $('#ban3').css('opacity', '1');
      } ,1000);

        bannerStatus = 3;
      }

      /*3*/
      else if (bannerStatus === 3) {
        $('#ban1').css('opacity', '0');

        setTimeout(function() {
          $('#ban3').css('right', '0px');
          $('#ban3').css('z-index', '1000');
          $('#ban1').css('right', '-815.48px');
          $('#ban1').css('z-index', 'z-index : 1500');
          $('#ban2').css('right', '815.48px');
          $('#ban2').css('z-index', '500');
        } ,500);

        setTimeout(function() {
        $('#ban1').css('opacity', '1');
      } ,1000);

        bannerStatus = 1;
      }
    }

/*=====================================================================================================*/

    var startBannerLoop = setInterval(function() {
        bannerLoop();
    }, bannerTimer);

    $('#upper-left-container').mouseenter(function() {
        clearInterval(startBannerLoop);
    });

    $('#upper-left-container').mouseleave(function() {
      startBannerLoop = setInterval(function() {
          bannerLoop();
      }, bannerTimer);
    });

/*=====================================================================================================*/
    /*btn of banner*/
    $('#img-bank-btn-prev').on('click', function() {
        if (bannerStatus === 1) {
          bannerStatus = 2;
        } else if (bannerStatus === 2) {
          bannerStatus = 3;
        } else if (bannerStatus === 3) {
          bannerStatus = 1;
        }
        bannerLoop();
    });

    $('#img-bank-btn-next').on('click', function() {
      bannerLoop();
    });
});
