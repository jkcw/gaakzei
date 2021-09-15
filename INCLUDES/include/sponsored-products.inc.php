<?php

    $goodsID = 20;
    $goodsTitle = "Sponsor Sample";
    $goodsPrice = 50;
    $goodsUserID = 13;

    $sponsored_img_like = '<div class="hot-like-img" value="'.$goodsID.'">
                            <div class="latest-like-img-div">
                               <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="hot-'.$goodsID.'" value="">
                            </div>
                            <div class="latest-like-img-p-div">
                              <p id="hot-quantity'.$goodsID.'" value="" class="quantity" >123</p>
                            </div>
                            <p id="hot-change'.$goodsID.'" value="0"></p>
                         </div>';

    $sponsored_pd_output = '<li class="hot-product-li">
                                <div class="hot-product-div">

                                  <!--***Product Top Container***-->
                                  <a class="hot-product-a" href="../user-info/'.$goodsUserID.'-profile">
                                    <div class="product-top-container">
                                      <div class="product-top-left">
                                        <img class="product_user_icon" src="https://www.gaakzei.com/user-info/user-img/'.$goodsUserID.'-profile.jpg" />
                                      </div>
                                      <div class="product-top-right">
                                        <div class="product-user-name-div">
                                          <p class="product-user-name-p">Template</p>
                                        </div>
                                        <div class="product-date-count-div">
                                        <p class="product-date-count-p">Change Later</p>
                                        </div>
                                      </div>
                                    </div>
                                  </a>
                                  <!--***END***-->

                                  <a class="hot-product-a" href="../products-info/products-file/'.$goodsUserID.'-'.$goodsID.'">
                                    <div class="product-img-cover-div">
                                      <img class="product-img-cover" src="../products-info/products-img/'.$goodsID.'-'.$goodsUserID.'-0.jpg">
                                    </div>
                                    <div class="product-id-container">
                                      <p class="hot-product-a-title" >'.$goodsTitle.'</p>
                                    </div>

                                    <div class="price-id-container">
                                      <div class="hot-product-a-price-div">
                                        <p class="hot-product-a-price" >$'.$goodsPrice.'</p>
                                      </div>
                                      <div class="hot-product-a-id-div">
                                        <p class="hot-product-a-id" >ID:'.$goodsID.'</p>
                                      </div>
                                    </div>
                                  </a>
                                    '.$sponsored_img_like.'
                                </div>
                              </li>';

 ?>
