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
                <li class="@if(request()->is('admin')) uk-active @endif"><a href="dashboard"><span class="uk-margin-small-right" uk-icon="desktop"></span> <?=lang('Global.dashboard')?></a></li>
                <!-- end of Dashboard -->
            </ul>
        </div>
    </div>
<?php } else { ?>
    <aside class="tm-sidebar-left uk-visible@m">
        <ul class="uk-nav-default uk-nav-divider" uk-nav>
            <!-- Dashboard -->
            <li class="@if(request()->is('admin')) uk-active @endif"><a href="dashboard"><span class="uk-margin-small-right" uk-icon="desktop"></span> <?=lang('Global.dashboard')?></a></li>
            <!-- end of Dashboard -->
        </ul>
    </aside>
<?php } ?>