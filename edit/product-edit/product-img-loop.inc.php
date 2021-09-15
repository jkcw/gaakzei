<?php

      /*miuns 1 to get the actual number of profucts' img*/
      $goodsIMG = $goodsIMG - 1;
      $img_output = '';
      $img_hidden = 0;

      /*Start for loop*/
      for ($i=0; $i < 6; $i++) {

        /*if there are remainders*/
        if ($goodsIMG >= $i) {
          $path = $productID.'-'.$uid.'-'.$i.'.jpg';
          if ($i == 0) {
            $img_output .= '<li id="li-'.$i.'" class="img_li"><div class="img-div">
                              <label for="'.$i.'" class="custom-file-upload" value="'.$i.'">
                                <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/products-info/products-img/'.$path.'" />
                                <button class="img-button" type="button" id="button-'.$i.'">更改</button>
                              </label>
                                <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file" value="1"/>
                                <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                                <input name="img-origin'.$i.'" id="img-origin'.$i.'" type="hidden" value="1"/>
                            </div></li>';
          } else {
            $img_output .= '<li id="li-'.$i.'" class="img_li"><div class="img-div">
                              <label for="'.$i.'" class="custom-file-upload" value="'.$i.'">
                                <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/products-info/products-img/'.$path.'" />
                                <button class="img-button" type="button" id="button-'.$i.'" value="1">刪除</button>
                              </label>
                                <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file" value="1"/>
                                <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                                <input name="img-origin'.$i.'" id="img-origin'.$i.'" type="hidden" value="1"/>
                            </div></li>';
          }

          /*if there are no more remainder*/
        } elseif ($goodsIMG < $i) {

          /*first upload system img*/
          if ($img_hidden == 0) {
            $img_output .= '<li id="li-'.$i.'" class="img_li"><div class="img-div">
                              <label for="'.$i.'" class="custom-file-upload" value="'.$i.'">
                                <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/system-img/upload-button.svg" />
                                <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                              </label>
                                <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file"/>
                                <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                                <input name="img-origin'.$i.'" type="hidden" value="0"/>
                              </div></li>';
            $img_hidden ++;

            /*the other*/
          } else {
            $img_output .= '<li id="li-'.$i.'" class="img_li" style="display:none;"><div class="img-div">
                              <label for="'.$i.'" class="custom-file-upload" value="'.$i.'">
                                <img class="img_product" id="img_'.$i.'" src="https://www.gaakzei.com/system-img/upload-button.svg" />
                                <button class="img-button" type="button" id="button-'.$i.'">上傳</button>
                              </label>
                                <input name="img-upload'.$i.'" class="file-input" id="'.$i.'" type="file"/>
                                <input name="img-bool'.$i.'" id="img-bool'.$i.'" type="hidden" value="0"/>
                                <input name="img-origin'.$i.'" type="hidden" value="0"/>
                              </div></li>';
          }

        }
      } /*end of loop*/
