<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
<div class="uk-flex uk-flex-right">
    <a class="uk-button uk-button-primary" href="users/newmember">+ Add Member</a>
</div>
<?php if ($ismobile === false) { ?>
<form class="uk-margin" action="users" method="GET">
    <div class="uk-margin uk-flex-between uk-child-width-auto" uk-grid>
        <div>
            <div class="uk-vhild-width-auto uk-grid-small" uk-grid>
                <div>
                    <select class="uk-select uk-form-width-small" id="role" name="role">
                        <option value='0' <?=(empty($input['role'])) ? 'selected' : ''?><?=($input['role'] === '0') ? 'selected' : ''?>><?=lang('Global.allRole')?></option>
                        <?php
                        foreach ($groups as $group) {
                            if (($role === 'owner') || (($role === 'manager') && ($group->id != '2')) || (($role === 'staff') && ($group->id != '2') && ($group->id != '3'))) {
                        ?>
                            <option value="<?=$group->id?>" <?=($input['role'] === $group->id) ? 'selected' : ''?>><?=$group->name?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>
                    <input class="uk-input uk-form-width-medium" type="text" id="search" name="search" placeholder="<?=lang('Global.search')?>" value="<?=(isset($input['search'])) ? $input['search'] : ''?>" />
                </div>
            </div>
        </div>
        <div>
            <div class="uk-child-width-auto uk-grid-small uk-flex-middle" uk-grid>
                <div><?=lang('Global.display')?>:</div>
                <div>
                    <select class="uk-select uk-form-width-xsmall" id="sort" name="sort">
                        <option value="10" <?=(($input['sort'] === '10') || (empty($input['sort']))) ? 'selected' : ''?>>10</option>
                        <option value="25" <?=($input['sort'] === '25') ? 'selected' : ''?>>25</option>
                        <option value="100" <?=($input['sort'] === '100') ? 'selected' : ''?>>100</option>
                    </select>
                </div>
                <div><?=lang('Global.perPage')?></div>
            </div>
        </div>
    </div>
    <button id="submit" type="submit" hidden></button>
</form>
<?php } else { ?>
<form class="uk-margin" action="users" method="GET">
    <div class="uk-margin uk-child-width-1-2 uk-grid-small" uk-grid>
        <div>
            <select class="uk-select" id="role" name="role">
                <option value='0' <?=(empty($input['role'])) ? 'selected' : ''?><?=($input['role'] === '0') ? 'selected' : ''?>><?=lang('Global.allRole')?></option>
                <?php foreach ($groups as $group) { ?>
                    <option value="<?=$group->id?>" <?=($input['role'] === $group->id) ? 'selected' : ''?>><?=$group->name?></option>
                <?php } ?>
            </select>
        </div>
        <div class="uk-inline">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>
            <input class="uk-input" type="text" id="search" name="search" placeholder="<?=lang('Global.search')?>" value="<?=(isset($input['search'])) ? $input['search'] : ''?>" />
        </div>
    </div>
    <div class="uk-margin uk-flex uk-flex-right">
        <div class="uk-child-width-auto uk-grid-small uk-flex-middle" uk-grid>
            <div><?=lang('Global.display')?>:</div>
            <div>
                <select class="uk-select uk-form-width-xsmall" id="sort" name="sort">
                    <option value="10" <?=(($input['sort'] === '10') || (empty($input['sort']))) ? 'selected' : ''?>>10</option>
                    <option value="25" <?=($input['sort'] === '25') ? 'selected' : ''?>>25</option>
                    <option value="50" <?=($input['sort'] === '50') ? 'selected' : ''?>>50</option>
                    <option value="100" <?=($input['sort'] === '100') ? 'selected' : ''?>>100</option>
                </select>
            </div>
            <div><?=lang('Global.perPage')?></div>
        </div>
    </div>
    <button id="submit" type="submit" hidden></button>
</form>
<?php } ?>
<script type="application/javascript">
    document.getElementById('role').addEventListener('change', formSubmit);
    document.getElementById('search').addEventListener('change', formSubmit);
    document.getElementById('sort').addEventListener('change', formSubmit);
    function formSubmit() {
        document.getElementById("submit").click();
    }
</script>
<div class="uk-overflow-auto">
    <table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle">
        <thead>
            <tr>
                <th>Memberid</th>
                <th><?=lang('Global.fullname')?></th>
                <?php if (($role === 'owner') || ($role === 'manager')) { ?>
                    <th><?=lang('Global.phone')?></th>
                    <th><?=lang('Auth.email')?></th>
                <?php } ?>
                <th class="uk-text-center"><?=lang('Global.subscription')?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($users)) {
                foreach ($users as $user) {
            ?>
                <tr>
                    <td><?=$user->memberid?></td>
                    <td><?=$user->firstname?> <?=$user->lastname?></td>
                    <?php if (($role === 'owner') || ($role === 'manager')) { ?>
                        <td><?=$user->phone?></td>
                        <td><?=$user->email?></td>
                    <?php } ?>
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
            <?php
                }
            } else {
                echo '<tr><td class="uk-text-center uk-text-meta uk-text-italic"  colspan="6">'.lang('Global.noData').'</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<div class="uk-margin"><?= $pager->links('users', 'uikit') ?></div>
<?php foreach ($users as $user) { ?>
<div class="uk-flex-top uk-modal-container" id="user-<?=$user->memberid?>" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title"><?=$user->firstname?> <?=$user->lastname?></h2>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>
            <div class="uk-child-width-1-2@m uk-grid-divider" uk-grid>
                <div class="uk-form-horizontal">
                    <div class="uk-margin">
                        <label class="uk-form-label"><?=lang('Global.fullname')?></label>
                        <div class="uk-form-controls uk-h3 uk-margin-remove"><?=$user->firstname?> <?=$user->lastname?></div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label"><?=lang('Global.memberid')?></label>
                        <div class="uk-form-controls uk-h3 uk-margin-remove"><?=$user->memberid?></div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label"><?=lang('Auth.username')?></label>
                        <div class="uk-form-controls uk-h3 uk-margin-remove"><?=$user->username?></div>
                    </div>
                    <?php if (($role === 'owner') || ($role === 'manager')) { ?>
                        <div class="uk-margin">
                            <label class="uk-form-label"><?=lang('Global.phone')?></label>
                            <div class="uk-form-controls uk-h3 uk-margin-remove">+<?=$user->phone?></div>
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label"><?=lang('Auth.email')?></label>
                            <div class="uk-form-controls uk-h3 uk-margin-remove"><?=$user->email?></div>
                        </div>
                    <?php } ?>
                    <?php
                    if ($user->expired_at != null) {
                        $today = date('Y-m-d');
                        $expire = date('Y-m-d', strtotime($user->expired_at));
                        if ($expire < $today) {
                            $style = 'style="background-color:#cc0b24; color:#fff; padding:10px;"';
                        } else {
                            $style = 'style="background-color:#04bf04; color:#fff; padding:10px;"';
                        }
                    } else {
                        $expire = '<span class="uk-text-italic" style="color:#fff;">'.lang('Global.notSubscribed').'</span>';
                        $style = 'style="background-color:#cc0b24; padding:10px;"';
                    }
                    ?>
                    <div class="uk-margin">
                        <label class="uk-form-label"><?=lang('Global.expiredate')?></label>
                        <div class="uk-form-controls uk-h3 uk-margin-remove"><span <?=$style?>><?=$expire?></span></div>
                    </div>
                </div>
                <div>
                    <?php if (isset($user->photo)) { ?>
                    <div class="uk-margin">
                        <img class="uk-width-1-1" src="images/member/<?=$user->photo?>" />
                    </div>
                    <?php } else { ?>
                    <div clss="uk-margin">
                        <div class="uk-text-center uk-text-meta"><?=lang('Global.noPhoto')?></div>
                    </div>
                    <?php } ?>
                    <div class="uk-margin uk-text-center">
                        <?php
                        $msg = urlencode(base_url().'images/member/'.$user->membercard);
                        ?>
                        <a class="uk-button uk-button-secondary" href="https://wa.me/<?=$user->phone?>?text=<?=$msg?>" target="_blank"><span uk-icon="whatsapp"></span> <?=lang('Global.sendMembercard')?></a>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="uk-modal-footer">
            <div class="uk-child-width-auto uk-flex-center" uk-grid>
                <div><a class="uk-button uk-button-secondary uk-text-uppercase" href="users/update/<?=$user->memberid?>"><?=lang('Global.edit')?></a></div>
                <?php if (($role === 'owner') || ($role === 'manager')) { ?>
                    <div>
                        <a class="uk-button uk-button-primary uk-text-uppercase" href="#delete-confirm-<?=$user->memberid?>" uk-toggle><?=lang('Global.delete')?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="uk-flex-top" id="delete-confirm-<?=$user->memberid?>" uk-modal="bg-close: false">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title uk-text-center"><?=lang('Global.areYouSure')?></h3>
        </div>
        <div class="uk-modal-body">
            <form action="users/delete" method="post">
                <input name="memberid" value="<?=$user->memberid?>" hidden/>
                <div class="uk-child-width-auto uk-flex-center" uk-grid>
                    <div><button class="uk-button uk-button-secondary" type="submit"><?=lang('Global.yes')?></button></div>
                    <div><a class="uk-button uk-button-danger" onclick="UIkit.modal('#delete-confirm-<?=$user->memberid?>').hide();"><?=lang('Global.no')?></a></div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>
<?= $this->endSection() ?>