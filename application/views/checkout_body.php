<div id="checkout_body" class="checkout_b">
    <p>
         <h1>Your Shipping Cart</h1>
    </p>
    <p>
        <a href="#">< Continue Shopping</a>
    </p>

    <div class="cart_items">
        <table class="cart_items_table">
            <tr>
                <th colspan="2">
                    Product Name & Details
                </th>
                <th>
                    Quantity
                </th>
                <th>
                    Price
                </th>
                <th>
                    Shipping details
                </th>
                <th>
                    Actions
                </th>
            </tr>

<!--            <tr>-->
<!--                <td colspan="6">-->
<!--                    <hr>-->
<!--                </td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td>-->
<!--                    Image-->
<!--                </td>-->
<!--                <td>-->
<!--                    Name & description-->
<!--                </td>-->
<!--                <td>-->
<!--                    2-->
<!--                </td>-->
<!--                <td>-->
<!--                    3-->
<!--                </td>-->
<!--                <td>-->
<!--                    4-->
<!--                </td>-->
<!--                <td>-->
<!--                    5-->
<!--                </td>-->
<!--            </tr>-->

            <?php
            foreach ($items as $key => $item) {
                ?>

                <tr>
                    <td colspan="6">
                        <hr>
                    </td>
                </tr>

                <tr>
                    <td>
                        <?php
                            foreach ($images as $j => $imgs) {
                                if ($imgs['id_product'] == $item['id']) {
                                    echo "<img src='data:image/jpg;base64, " . $imgs['img'] . "' alt=' ' class='img-checkout'/> ";
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <p><?php echo $item['name']; ?></p>
                        <p><?php echo $item['description']; ?></p>
                    </td>
                    <td>
                        <?php echo $item['count']; ?>
                    </td>
                    <td>
                        <?php echo $item['price']; ?>
                    </td>
                    <td>

                    </td>
                    <td>
                        <p><a href="#">Remove</a></p>
                        <p><a href="#">Buy only</a></p>
                    </td>
                </tr>

            <?php
            }
            ?>

        </table>

    </div>

    <div class="paypal_button">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="HSCRJTM8B34GY">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0"
                   name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>


</div>