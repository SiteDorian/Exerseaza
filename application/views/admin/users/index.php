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
                        <h3 class="box-title"><?php echo anchor('admin/users/create',
                                '<i class="fa fa-plus"></i> ' . lang('users_create_user'),
                                array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th><?php echo "User id"; ?></th>
                                <th><?php echo "Full name"; ?></th>
                                <th><?php echo lang('users_email'); ?></th>
                                <th><?php echo lang('users_groups'); ?></th>
                                <th><?php echo lang('users_status'); ?></th>
                                <th><?php echo lang('users_action'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php

                                        foreach ($user->groups as $group) {

                                            // Disabled temporary !!!
                                            // echo anchor('admin/groups/edit/'.$group->id, '<span class="label" style="background:'.$group->bgcolor.';">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>');
                                            echo anchor('admin/groups/edit/' . $group->id,
                                                '<span class="label label-default">' . htmlspecialchars($group->name,
                                                    ENT_QUOTES, 'UTF-8') . '</span>');
                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($user->status=='t') {
                                            echo anchor('admin/users/deactivate/' . $user->id,
                                                '<span class="label label-success">' . lang('users_active') . '</span>');
                                        } else {
                                            echo anchor('admin/users/activate/' . $user->id,
                                                '<span class="label label-default">' . lang('users_inactive') . '</span>');
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo anchor('admin/users/edit/' . $user->id, lang('actions_edit')); ?>
                                        <?php echo anchor('admin/users/profile/' . $user->id, lang('actions_see')); ?>
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
