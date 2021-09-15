<?php

    /*loop the uploader boxes*/

    $img_output ='';

    for ($i=0; $i < 6; $i++) {

      /*first uploader*/
      if ($i == 0) {
        $img_output .= '<li id="li-'.$i.'" class="img_li"><div class="img-div">
                          <label for="'.$i.'" class="custom-file-upload">
                            <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/system-img/upload-button.svg" />
                            <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                          </label>
                            <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file"/>
                            <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                        </div></li>';

        /*other uploaders*/
      } else {
        $img_output .= '<li id="li-'.$i.'" class="img_li" style="display:none;"><div class="img-div">
                          <label for="'.$i.'" class="custom-file-upload">
                            <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/system-img/upload-button.svg" />
                            <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                          </label>
                            <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file"/>
                            <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                        </div></li>';
      }
    }
