<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>


<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $product->name ?></h3>
                <hr class="hr-images">
            </div>

            <div id="imagin" class="imagini">
                <p><b>Import an image ... </b></p>

                <div style="display: block; padding-bottom: 30px;">
                    <form action="<?php
                    echo site_url('admin/products/upload/') . $productID; ?>" method="post" accept-charset="utf-8"
                          enctype="multipart/form-data">
                        <input type="file" name="f1" id="file1" required="required" style="float: left;">

                        <input type="submit" name="btn" value="Incarca" id="b1" style="float: left;">

                        <input type="reset" name="">
                    </form>
                </div>


                <?php
                if ($images) {
                    foreach ($images as $img) {
                        echo "<div class='container'>";
                        if ($img->is_main == 't') {
                            echo '<img src="' . base_url($img->img_link) . '" height="70px" width="60px" border hspace="3" class="main_image"/>';
                            echo '<a href="' . site_url() . 'admin/products/delete/' . $img->id . '/' . $img->id_product . '"><div class="overlay">Delete</div></a>';
                        } else {
                            echo '<img src="' . base_url($img->img_link) . '" height="70px" width="60px" border hspace="3"/>';
                            echo '<a href="' . site_url() . 'admin/products/delete/' . $img->id . '/' . $img->id_product . '"><div class="overlay">Delete</div></a>';
                            echo '<a href="' . site_url() . 'admin/products/set_main_image/' . $img->id . '/' . $img->id_product . '"><div class="overlay main">Set as main</div></a>';
//                            echo anchor('admin/products/delete/'.$img->id, "Delete",  array('class' => 'overlay'));
                        }

                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>
</div>

<?php
//Alert messages

if (isset($delete_info)) {
    echo "<script> alert('$delete_info'); </script>";
}

if (isset($upload_info)) {
    echo "<script> alert('$upload_info'); </script>";
}

if (isset($image_info)) {
    echo "<script> alert('$image_info'); </script>";
}

?>


<!--<script>-->
<!--    $(document).ready(function(){-->
<!--        alert('<%: TempData["Resultat"]%>');-->
<!--    });-->
<!--</script>-->



