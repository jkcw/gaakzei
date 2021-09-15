<?php

    /*loop the img*/
    $image_output = '';
    for ($i=0; $i < $imgQuantity; $i++) {

      $img_now = $i + 1 ;
      $img_path = $goodsIDp.'-'.$userIDp.'-'.$i.'.jpg';

      $image_output .= '<div class="img-slider">
                          <img alt="'.$goodsTitle.'" src="../products-img/'.$img_path.'">
                          <p class="img-number">'.$img_now.'/'.$imgQuantity.'</p>
                        </div>';

    }

    /*button setting*/

    $img_button = '';

    if ($imgQuantity > 1) {
      $img_button .= '<button id="prev"><img src="system-svg/left-arrow.svg"></button>';
      $img_button .= '<button id="next"><img src="system-svg/right-arrow.svg"></button>';

    } else {
      $img_button = '';
    }
