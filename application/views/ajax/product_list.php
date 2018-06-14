<?php
$i = 0; //variabila care numara produsele din rand, --cate 3 pe rand

foreach ($products

as $key => $value):
if ($i++ % 3 == 0) {
?>


<div class="w3ls_mobiles_grid_right_grid3">


    <?php
    }
    ?>
    <div class="col-md-4 agileinfo_new_products_grid agileinfo_new_products_grid_mobiles">
        <div class="agile_ecommerce_tab_left mobiles_grid">
            <div class="hs-wrapper hs-wrapper2">

                <?php
                foreach ($images as $j => $imgs) {
                    if ($imgs['id'] == $value['id']) {
                        echo "<img src='" . base_url($imgs['img']) . "' alt=' ' class='img-responsive'/> ";
                    }
                }
                ?>


                <div class="w3_hs_bottom w3_hs_bottom_sub1">
                    <ul>
                        <li>
                            <a href="#" data-toggle="modal"
                               data-target="#myModal<?php echo $value['id']; ?>"><span
                                        class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <h5><a href="#link"><?php echo $value['name']; ?></a></h5>
            <div class="simpleCart_shelfItem">
                <p><span>$250</span> <i class="item_price"><?php echo $value['price']; ?></i></p>
                <form action="#" method="post">
                    <input type="hidden" name="cmd" value="_cart"/>
                    <input type="hidden" name="add" value="<?php echo $value['id']; ?>"/>
                    <input type="hidden" name="w3ls_item" value="<?php echo $value['name']; ?>"/>
                    <input type="hidden" name="amount"
                           value="<?php echo preg_replace('~[\\\\/:*?$,"<>|]~', null,
                               $value['price']); ?>"/>
                    <button type="submit" class="w3ls-cart">Add to cart</button>
                </form>
            </div>
            <?php
            if ($value['created_at'] > date('Y-m-d h:i:sa', strtotime(date('Y-m-d h:i:sa') . ' -14 day'))) {
                echo '<div class="mobiles_grid_pos">
                                    <h6>New</h6>
                                </div>';
            }
            ?>
        </div>
    </div>

    <?php
    endforeach;
    ?>

</div>