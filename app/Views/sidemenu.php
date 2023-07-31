<?php if ($ismobile === true) { ?>
    <div id="offcanvas" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar">
            <div class="uk-margin">
                <div class="uk-h4 uk-margin-remove"><?=$fullname?></div>
                <div class="uk-h5 uk-margin-remove"><?=$role?></div>
                <div class="uk-margin uk-text-center">
                    <a id="logout-mobile" class="uk-button uk-button-secondary"><span uk-icon="sign-out"></span> <?=lang('Global.logout')?></a>
                </div>
            </div>
            <hr class="uk-divider-icon">
            <ul class="uk-margin uk-nav-default" uk-nav>
                <li class="uk-nav-header"><?=lang('Global.account')?></li>
                <li><a href="forgot"><span class="uk-margin-small-right" uk-icon="lock"></span> <?=lang('Auth.resetPassword')?></a></li>
                <li><a href="myaccount"><span class="uk-margin-small-right" uk-icon="user"></span> <?=lang('Global.profile')?></a></li>
                <li class="uk-nav-divider"></li>
                <li class="uk-nav-header">Menu</li>

                <!-- Dashboard -->
                <li class="<?=($uri->getSegment(1) === 'dashboard') ? 'uk-active' : ''?>"><a href="dashboard"><span class="uk-margin-small-right" uk-icon="desktop"></span> <?=lang('Global.dashboard')?></a></li>
                <li class="uk-parent <?=($uri->getSegment(1) === 'users') ? 'uk-active' : ''?>">
                    <a href="#"><span class="uk-margin-small-right" uk-icon="users"></span> <?=lang('Global.Users')?> <span uk-nav-parent-icon></span></a>
                    <ul class="uk-nav-sub">
                        <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'newmember')) ? 'uk-active' : ''?>"><a href="users/newmember">+ <?=lang('Global.newMember')?></a></li>
                        <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === '')) ? 'uk-active' : ''?>"><a href="users"><?=lang('Global.memberList')?></a></li>
                        <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'extend')) ? 'uk-active' : ''?>"><a href="users/extend"><?=lang('Global.extend')?></a></li>
                        <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'checkin')) ? 'uk-active' : ''?>"><a href="users/checkin"><?=lang('Global.checkIn')?></a></li>
                    </ul>
                </li>
                <li class="<?=(($uri->getSegment(1) === 'report') && ($uri->getSegment(2) === 'checkin')) ? 'uk-active' : ''?>"><a href="report/checkin"><span class="uk-margin-small-right" uk-icon="database"></span> <?=lang('Global.checkinLog')?></a></li>
                <!-- end of Dashboard -->
            </ul>
        </div>
    </div>
<?php } else { ?>
    <aside class="tm-sidebar-left uk-visible@m">
        <ul class="uk-nav-default uk-nav-divider" uk-nav>
            <!-- Dashboard -->
            <li class="<?=($uri->getSegment(1) === 'dashboard') ? 'uk-active' : ''?>"><a href="dashboard"><span class="uk-margin-small-right" uk-icon="desktop"></span> <?=lang('Global.dashboard')?></a></li>
            <li class="uk-parent <?=($uri->getSegment(1) === 'users') ? 'uk-active' : ''?>">
                <a href="#"><span class="uk-margin-small-right" uk-icon="users"></span> <?=lang('Global.Users')?> <span uk-nav-parent-icon></span></a>
                <ul class="uk-nav-sub">
                    <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'newmember')) ? 'uk-active' : ''?>"><a href="users/newmember">+ <?=lang('Global.newMember')?></a></li>
                    <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === '')) ? 'uk-active' : ''?>"><a href="users"><?=lang('Global.memberList')?></a></li>
                    <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'extend')) ? 'uk-active' : ''?>"><a href="users/extend"><?=lang('Global.extend')?></a></li>
                    <li class="<?=(($uri->getSegment(1) === 'users') && ($uri->getSegment(2) === 'checkin')) ? 'uk-active' : ''?>"><a href="users/checkin"><?=lang('Global.checkIn')?></a></li>
                </ul>
            </li>
            <li class="<?=(($uri->getSegment(1) === 'report') && ($uri->getSegment(2) === 'checkin')) ? 'uk-active' : ''?>"><a href="report/checkin"><span class="uk-margin-small-right" uk-icon="database"></span> <?=lang('Global.checkinLog')?></a></li>
            <!-- end of Dashboard -->
        </ul>
    </aside>
<?php } ?>