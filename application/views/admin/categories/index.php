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
                        <h4>
                            <h3 class="box-title"><?php echo anchor('admin/categories/create',
                                    '<i class="fa fa-plus"></i> ' . lang('users_create_category'),
                                    array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                        </h4>

                    </div>

                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>CategoryID</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th><?php echo lang('users_action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $aux=$categories; foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td <?php if (is_null($category['id_parent'])) {
                                        echo 'style="font-style: italic; text-decoration: underline; color: blue;";';
                                    } ?>><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td <?php if (!is_null($category['id_parent'])) {
                                        echo 'style="font-style: italic; color: blue;"';
                                    } else echo 'style="color: grey;"'; ?>><?php if (!is_null($category['id_parent'])) {
                                        foreach ($aux as $parent) {
                                            if ($parent['id']==$category['id_parent']) {
                                                echo htmlspecialchars($parent['name'],
                                                    ENT_QUOTES,
                                                    'UTF-8');
                                                break;
                                            }


                                        }

                                        } else {
                                            echo "Primary";
                                        } ?></td>
                                    <td>
                                        <?php echo anchor('admin/categories/edit/' . $category['id'],
                                            lang('actions_edit')); ?>
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
