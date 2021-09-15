<?php

    /*loop the uploader boxes*/

    $img_output ='';

    for ($i=0; $i < 3; $i++) {

      /*first uploader*/
      if ($i == 0) {
        $img_output .= '<li id="li-'.$i.'" class="img_li">
                          <div class="img-div">
                            <label for="'.$i.'" class="custom-file-upload">
                              <img class="img_comment_upload" id="img_'.$i.'" src="system-svg/img-upload.svg" />
                              <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                            </label>
                              <input type="file" class="file-input" name="fileToUpload'.$i.'" id="'.$i.'">
                              <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                          </div>
                        </li>';

        /*other uploaders*/
      } else {
        $img_output .= '<li id="li-'.$i.'" class="img_li" style="display:none;">
                          <div class="img-div">
                            <label for="'.$i.'" class="custom-file-upload">
                              <img class="img_comment_upload" id="img_'.$i.'" src="system-svg/img-upload.svg" />
                              <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                            </label>
                              <input type="file" class="file-input" name="fileToUpload'.$i.'" id="'.$i.'">
                              <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                          </div>
                        </li>';
      }
    }
