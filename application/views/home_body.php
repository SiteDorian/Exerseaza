<!---->
<!--<script>-->
<!--    $('#myModal88').modal('show');-->
<!--</script>-->


<!-- banner -->
<div class="banner">
    <div class="container">
        <h3>Electronic Store, <span>Oferte speciale</span></h3>
    </div>
</div>
<!-- //banner -->
<!-- new-products -->
<div class="new-products">
    <div class="container">
        <h3>New Products</h3>
        <div class="agileinfo_new_products_grids">


            <?php
            foreach ($new_products as $product):
                ?>
                <div class="col-md-3 agileinfo_new_products_grid">
                    <div class="agile_ecommerce_tab_left agileinfo_new_products_grid1">
                        <div class="hs-wrapper hs-wrapper1">

                            <?php
                            foreach ($images as $j => $imgs) {
                                if ($imgs['id'] == $product->id) {
                                    echo "<img style='height: 100%;' src='" . base_url($imgs['img']) . "' alt=' ' class='img-responsive'/> ";
                                }
                            }
                            ?>

                            <div class="w3_hs_bottom w3_hs_bottom_sub">
                                <ul>
                                    <li>
                                        <a href="#" data-toggle="modal"
                                           data-target="#myModal<?php echo $product->id; ?>"><span
                                                    class="glyphicon glyphicon-eye-open"
                                                    aria-hidden="true"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h5><a href="single.html"><?php echo $product->name?></a></h5>
                        <div class="simpleCart_shelfItem">
                            <p><span><?php  ?></span> <i class="item_price"><?php echo $product->price?></i></p>
                            <form action="#" method="post">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="add" value="<?php echo $product->id?>">
                                <input type="hidden" name="w3ls_item" value="<?php echo $product->name?>">
                                <input type="hidden" name="amount" value="<?php echo preg_replace('~[\\\\/:*?$,"<>|]~', null,
                                    $product->price); ?>">
                                <button type="submit" class="w3ls-cart">Add to cart</button>
                            </form>
                        </div>
                        <div class="mobiles_grid_pos">
                            <h6>New</h6>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>


            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //new-products -->

<?php
foreach ($new_products as $value) :

    ?>
    <div class="modal video-modal fade" id="myModal<?php echo $value->id; ?>" tabindex="-1" role="dialog"
         aria-labelledby="myModal<?php echo $value->id; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                </div>
                <section>
                    <div class="modal-body">
                        <div class="col-md-5 modal_body_left">

                            <img src="<?php foreach ($main_images as $i => $img) {
                                if ($img['id'] == $value->id) {
                                    echo $img['img'];
                                    break;
                                }
                            } ?>" alt="No data.." class="img-responsive"/>


                        </div>
                        <div class="col-md-7 modal_body_right">
                            <h4> <?php echo $value->name; ?> </h4>
                            <p><?php echo $value->description; ?></p>
                            <div class="rating">
                                <?php
                                foreach ($rating as $b => $rat) {
                                    if ($rat['id'] == $value->id) {
                                        $stars = $rat['round'];
                                        break;
                                    }
                                }


                                for ($i = 1; $i <= $stars; $i++):


                                    ?>
                                    <div class="rating-left">
                                        <img src="<?php echo base_url(); ?>images/star-.png" alt=" "
                                             class="img-responsive"/>
                                    </div>

                                <?php
                                endfor;

                                for ($i = 1; $i <= (5 - $stars); $i++):

                                    ?>
                                    <div class="rating-left">
                                        <img src="<?php echo base_url(); ?>images/star.png" alt=" "
                                             class="img-responsive"/>
                                    </div>
                                <?php
                                endfor;
                                ?>


                                <div class="clearfix"></div>
                            </div>
                            <div class="modal_body_right_cart simpleCart_shelfItem">
                                <p><span>$250</span> <i class="item_price"><?php echo $value->price; ?></i></p>
                                <form action="#" method="post">
                                    <input type="hidden" name="cmd" value="_cart"/>
                                    <input type="hidden" name="id_product" value="<?php echo $value->id; ?>"/>
                                    <input type="hidden" name="add" value="<?php echo $value->id; ?>"/>
                                    <input type="hidden" name="w3ls_item" value="<?php echo $value->name; ?>"/>
                                    <input type="hidden" name="amount"
                                           value="<?php echo preg_replace('~[\\\\/:*?$,"<>|]~', null,
                                               $value->price); ?>"/>
                                    <button type="submit" class="w3ls-cart">Add to cart</button>
                                </form>
                            </div>
                            <h5>Color</h5>
                            <div class="color-quality">
                                <ul>
                                    <li><a href="#"><span></span></a></li>
                                    <li><a href="#" class="brown"><span></span></a></li>
                                    <li><a href="#" class="purple"><span></span></a></li>
                                    <li><a href="#" class="gray"><span></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php
endforeach;
?>


<!-- banner-bottom1 -->
<div class="banner-bottom1">
    <div class="agileinfo_banner_bottom1_grids">
        <div class="col-md-7 agileinfo_banner_bottom1_grid_left">
            <h3>Grand Opening Event With flat<span>20% <i>Discount</i></span></h3>
            <a href="products.html">Shop Now</a>
        </div>
        <div class="col-md-5 agileinfo_banner_bottom1_grid_right">
            <h4>hot deal</h4>
            <div class="timer_wrap">
                <div id="counter"></div>
            </div>
            <script src="<?php echo base_url(); ?>assets/js/jquery.countdown.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- //banner-bottom1 -->
<!-- special-deals -->
<div class="special-deals">
    <div class="container">
        <h2>Special Deals</h2>
        <div class="w3agile_special_deals_grids">
            <div class="col-md-7 w3agile_special_deals_grid_left">
                <div class="w3agile_special_deals_grid_left_grid">
                    <img src="images/21.jpg" alt=" " class="img-responsive"/>
                    <div class="w3agile_special_deals_grid_left_grid_pos1">
                        <h5>30%<span>Off/-</span></h5>
                    </div>
                    <div class="w3agile_special_deals_grid_left_grid_pos">
                        <h4>We Offer <span>Best Products</span></h4>
                    </div>
                </div>
                <div class="wmuSlider example1">
                    <div class="wmuSliderWrapper">
                        <article style="position: absolute; width: 100%; opacity: 0;">
                            <div class="banner-wrap">
                                <div class="w3agile_special_deals_grid_left_grid1">
                                    <img src="images/t1.png" alt=" " class="img-responsive"/>
                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate
                                        velit esse quam nihil molestiae consequatur, vel illum qui dolorem
                                        eum fugiat quo voluptas nulla pariatur</p>
                                    <h4>Laura</h4>
                                </div>
                            </div>
                        </article>
                        <article style="position: absolute; width: 100%; opacity: 0;">
                            <div class="banner-wrap">
                                <div class="w3agile_special_deals_grid_left_grid1">
                                    <img src="images/t2.png" alt=" " class="img-responsive"/>
                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate
                                        velit esse quam nihil molestiae consequatur, vel illum qui dolorem
                                        eum fugiat quo voluptas nulla pariatur</p>
                                    <h4>Michael</h4>
                                </div>
                            </div>
                        </article>
                        <article style="position: absolute; width: 100%; opacity: 0;">
                            <div class="banner-wrap">
                                <div class="w3agile_special_deals_grid_left_grid1">
                                    <img src="images/t3.png" alt=" " class="img-responsive"/>
                                    <p>Quis autem vel eum iure reprehenderit qui in ea voluptate
                                        velit esse quam nihil molestiae consequatur, vel illum qui dolorem
                                        eum fugiat quo voluptas nulla pariatur</p>
                                    <h4>Rosy</h4>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <script src="<?php echo base_url(); ?>assets/js/jquery.wmuSlider.js"></script>
                <script>
                    $('.example1').wmuSlider();
                </script>
            </div>
            <div class="col-md-5 w3agile_special_deals_grid_right">
                <img src="images/20.jpg" alt=" " class="img-responsive"/>
                <div class="w3agile_special_deals_grid_right_pos">
                    <h4>Women's <span>Special</span></h4>
                    <h5>save up <span>to</span> 30%</h5>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //special-deals -->

<!-- top-brands -->
<div class="top-brands">
    <div class="container">
        <h3>Top Brands</h3>
        <div class="sliderfig">
            <ul id="flexiselDemo1">
                <li>
                    <img src="images/tb1.jpg" alt=" " class="img-responsive"/>
                </li>
                <li>
                    <img src="images/tb2.jpg" alt=" " class="img-responsive"/>
                </li>
                <li>
                    <img src="images/tb3.jpg" alt=" " class="img-responsive"/>
                </li>
                <li>
                    <img src="images/tb4.jpg" alt=" " class="img-responsive"/>
                </li>
                <li>
                    <img src="images/tb5.jpg" alt=" " class="img-responsive"/>
                </li>
            </ul>
        </div>
        <script type="text/javascript">
            $(window).load(function () {
                $("#flexiselDemo1").flexisel({
                    visibleItems: 4,
                    animationSpeed: 1000,
                    autoPlay: true,
                    autoPlaySpeed: 3000,
                    pauseOnHover: true,
                    enableResponsiveBreakpoints: true,
                    responsiveBreakpoints: {
                        portrait: {
                            changePoint: 480,
                            visibleItems: 1
                        },
                        landscape: {
                            changePoint: 640,
                            visibleItems: 2
                        },
                        tablet: {
                            changePoint: 768,
                            visibleItems: 3
                        }
                    }
                });

            });
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.flexisel.js"></script>
    </div>
</div>
<!-- //top-brands -->

