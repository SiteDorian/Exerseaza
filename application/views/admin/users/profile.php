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
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">User info</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <?php foreach ($user_info as $user): ?>

                                <tr>
                                    <th>Full name</th>
                                    <td><?php echo htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>

                                <tr>
                                    <th><?php echo lang('users_email'); ?></th>
                                    <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_created_on'); ?></th>
                                    <td><?php echo $user->created_at; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_last_login'); ?></th>
                                    <td><?php echo (!empty($user->updated_at)) ? $user->updated_at : null; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_status'); ?></th>
                                    <td><?php echo ($user->status) ? '<span class="label label-success">' . lang('users_active') . '</span>' : '<span class="label label-default">' . lang('users_inactive') . '</span>'; ?></td>
                                </tr>

                                <tr>
                                    <th><?php echo lang('users_groups'); ?></th>
                                    <td>
                                        <?php foreach ($user->groups as $group): ?>
                                            <?php
                                            if (isset($group->bgcolor)) $grcolor=$group->bgcolor; else $grcolor="grey";
                                            echo '<span class="label" style="background:' . $grcolor . '">' . htmlspecialchars($group->name,
                                                    ENT_QUOTES, 'UTF-8') . '</span>';
                                            ?>
                                        <?php endforeach ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">User orders / Cart</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            not data ..
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
