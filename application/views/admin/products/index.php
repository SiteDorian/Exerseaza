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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo anchor('admin/products/create',
                                '<i class="fa fa-plus"></i>  New product',
                                array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th><?php echo "ProductID"; ?></th>
                                <th>Image</th>
                                <th><?php echo "Name"; ?></th>
                                <th><?php echo lang('product_price'); ?></th>
                                <th><?php echo lang('product_description'); ?></th>

                                <th><?php echo lang('category_added_at'); ?></th>
                                <th><?php echo lang('category_updated_at'); ?></th>
                                <th><?php echo lang('category_name'); ?></th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td> <a href="#"> <?php $ok=true; foreach ($images as $img) {
                                            if ($img['id'] == $product->id) {
                                                echo "<img title='Modify main image' src='data:image/jpg;base64, " . $img['img'] . "' onerror=\"this.src='". base_url() ."/images/Default.png'\" alt=' ' width='50'/> ";
                                                $ok=false; break;
                                            }
                                        } if ($ok) echo "<img title='Add main image' src='". base_url() ."/images/Default.png'\" alt=' ' width='50'/> "; ?> </a> </td>
                                    <td><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td style="max-width: 300px;"><?php echo $product->description . ' ...'; ?></td>
                                    <td><?php echo htmlspecialchars($product->created_at, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($product->updated_at, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php
                                        echo htmlspecialchars($product->category, ENT_QUOTES, 'UTF-8');
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo anchor('admin/products/edit/' . $product->id,
                                            lang('actions_edit')); ?>
                                        <?php echo anchor('admin/products/images/' . $product->id,
                                            'Imgs'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
