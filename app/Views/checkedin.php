<?= $this->extend('layout') ?>
<?= $this->section('main') ?>
<?php if (!empty($user)) { ?>
    <div class="uk-margin uk-child-width-1-2@m uk-grid-divider" uk-grid>
        <div class="uk-form uk-form-horizontal">
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.fullname')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?=$user->firstname?> <?=$user->lastname?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.memberid')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?=$user->memberid?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Auth.username')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?=$user->username?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.phone')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove">+<?=$user->phone?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Auth.email')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?=$user->email?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.registerdate')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?=date('Y-m-d H:i:s', strtotime($user->created_at))?></div>
                </div>
            </div>
            <?php
            if ($user->expired_at != null) {
                $today = date('Y-m-d');
                $expire = date('Y-m-d', strtotime($user->expired_at));
                if ($expire < $today) {
                    $style = 'style="background-color:#cc0b24; color:#fff;"';
                } else {
                    $style = 'style="background-color:#04bf04; color:#fff;"';
                }
            } else {
                $expire = '<span class="uk-text-italic" style="color:#fff;">'.lang('Global.notSubscribed').'</span>';
                $style = 'style="background-color:#cc0b24;"';
            }
            ?>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.expiredate')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove" <?=$style?>><?=$expire?></div>
                </div>
            </div>
            <div class="uk-margin">
                <div class="uk-form-label"><?=lang('Global.promoStatus')?></div>
                <div class="uk-form-controls">
                    <div class="uk-h2 uk-margin-remove"><?= ($user->sub_type === '1' ? lang('Global.withPromo') : lang('Global.noPromo')) ?></div>
                </div>
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
                <div class="uk-text-center"><a class="uk-button uk-button-danger uk-button-large" href="users/update/<?=$user->memberid?>"><?=lang('Global.takePhoto')?></a></div>
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
    <?php
    if ($user->expired_at != null) {
        $now = date('Y-m-d');
        $ed = date('Y-m-d', strtotime($user->expired_at));
        if ($ed < $now) {
            $disable = 'disabled';
            $color = '#999';
        } else {
            $disable = '';
            $color = 'inherit';
        }
    } else {
        $disable = 'disabled';
        $color = '#999';
    }
    ?>
    <div class="uk-margin-large uk-text-center">
        <form action="users/checked" method="post">
            <input name="id" value="<?=$user->id?>" hidden />
            <button class="uk-button uk-button-primary uk-button-large" type="submit" <?=$disable?>><span class="uk-h1 uk-margin-remove" style="color:<?=$color?>;">Check In</span></button>
        </form>
    </div>
<?php } else { ?>
    <div class="uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: .tm-footer;">
        <div class="uk-width-1-1">
            <h1 class="uk-margin-remove uk-text-center uk-text-italic"><?=lang('Global.noData')?></h1>
        </div>
    </div>    
<?php } ?>
<?= $this->endSection() ?>