<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
<div class="uk-flex uk-flex-right">
    <a class="uk-button uk-button-primary" href="users/newmember">+ Add Member</a>
</div>
<table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle">
    <thead>
        <tr>
            <th>Memberid</th>
            <th><?=lang('Global.fullname')?></th>
            <th><?=lang('Global.phone')?></th>
            <th><?=lang('Auth.email')?></th>
            <th class="uk-text-center"><?=lang('Global.subscription')?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?=$user->memberid?></td>
                <td><?=$user->firstname?> <?=$user->lastname?></td>
                <td><?=$user->phone?></td>
                <td><?=$user->email?></td>
                <?php
                $today = date('Y-m-d');
                $expire = date('Y-m-d', strtotime($user->expired_at));
                if ($user->expired_at != null) {
                    $expired = $expire;
                    if ($expire < $today) {
                        $style = 'style="background-color:#cc0b24; color:#fff;"';
                    } else {
                        $style = 'style="background-color:#04bf04; color:#fff;"';
                    }
                } else {
                    $style = 'style="background-color:#cc0b24;"';
                    $expired = '<span class="uk-text-meta uk-text-italic" style="color:#fff;">'.lang('Global.notSubscribed').'</span>';
                }
                ?>
                <td class="uk-text-center" <?=$style?>><?=$expired?></td>
                <td class="uk-text-center">
                    <button class="uk-button uk-button-secondary" type="button" uk-toggle="target: #user-<?=$user->memberid?>"><?=lang('Global.manage')?></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php foreach ($users as $user) { ?>
<div class="uk-flex-top" id="user-<?=$user->memberid?>" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?=$user->firstname?> <?=$user->lastname?></h2>
        </div>
        <div class="uk-modal-body">
            
        </div>
    </div>
</div>
<?php } ?>
<?= $this->endSection() ?>