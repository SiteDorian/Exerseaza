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
                        <h3 class="box-title">Product edit</h3>
                    </div>
                    <div class="box-body">

                        <?php echo form_open(uri_string(), array('class' => 'form-horizontal', 'id' => 'form-edit_product')); ?>
                        <div class="form-group">
                            <?php echo lang('products_name', 'name', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_input($name);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo lang('products_price', 'price', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_input($price);?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo lang('products_description', 'description', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_textarea($description);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo lang('products_category', 'category', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php
                                echo form_dropdown($category, $options, $product->id_category);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php echo form_hidden('id', $product->id);?>
                                <div class="btn-group">
                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                    <?php echo anchor('admin/products', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
