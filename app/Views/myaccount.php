<!DOCTYPE html>
<html dir="ltr" lang="<?=$lang?>" style="overflow-y: hidden;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?=base_url();?>">
        <meta name="robots" content="noindex,nofollow">
        <title><?=$title;?></title>
        <meta name="description" content="<?=$description;?>">
        <meta name="author" content="PT. Kodebiner Teknologi Indonesia">
        <link rel="icon" href="favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="16x16" href="favicon/apple-icon-16x16.png">
        <link rel="apple-touch-icon" sizes="32x32" href="favicon/apple-icon-32x32.png">
        <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="96x96" href="favicon/apple-icon-96x96.png">
        <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
        <link rel="apple-touch-icon" sizes="192x192" href="favicon/apple-icon-192x192.png">
        <link rel="manifest" href="favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="css/theme.css">
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="js/theme.js"></script>
    </head>
    <body>
        <header class="uk-navbar-container tm-navbar-container" uk-sticky="media: 960;">
            <div class="uk-container uk-container-expand">
                <nav uk-navbar>
                    <div class="uk-navbar-left">
                        <a class="uk-navbar-item uk-logo" href="<?=base_url();?>">
                            <img src="images/logo.png" width="60" height="60" />
                        </a>
                    </div>
                    <div class="uk-navbar-right">
                        <?php if ($ismobile === false) { ?>
                            <div class="uk-inline uk-visible@m">
                                <a class="uk-link-reset uk-h4 uk-text-bold"><?=$fullname?> <span uk-icon="triangle-down"></span></a>
                                <div class="uk-width-medium" uk-dropdown="mode: click">
                                    <div class="uk-margin">
                                        <div class="uk-h4 uk-margin-remove tm-navbar-preserve"><?=$fullname?></div>
                                        <div class="uk-h5 uk-margin-remove tm-navbar-preserve"><?=$role?></div>
                                    </div>
                                    <div class="uk-margin">
                                        <div class="tm-navbar-dropdown"><a href="forgot" class="tm-navbar-preserve uk-link-reset"><span uk-icon="lock"></span> <?=lang('Auth.resetPassword')?></a></div>
                                        <div class="tm-navbar-dropdown"><a href="myaccount" class="tm-navbar-preserve uk-link-reset"><span uk-icon="user"></span> <?=lang('Global.profile')?></a></div>
                                    </div>
                                    <div class="uk-margin">
                                        <a class="uk-button tm-button-navbar" href="javascript:void(0)"><span uk-icon="sign-out"></span> <?=lang('Global.logout')?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a href="#offcanvas" class="uk-navbar-toggle uk-hidden@m" uk-navbar-toggle-icon uk-toggle></a>
                        <?php } ?>
                    </div>
                </nav>
            </div>
        </header>
        <div id="offcanvas" uk-offcanvas="mode: reveal; overlay: true">
            <div class="uk-offcanvas-bar">
                <div class="uk-margin">
                    <div class="uk-h4 uk-margin-remove"><?=$fullname?></div>
                    <div class="uk-h5 uk-margin-remove"><?=$role?></div>
                    <div class="uk-margin uk-text-center">
                        <a class="uk-button tm-button-navbar" href="javascript:void(0)"><span uk-icon="sign-out"></span> <?=lang('Global.logout')?></a>
                    </div>
                </div>
                <hr class="uk-divider-icon">
                <ul class="uk-margin uk-nav-default" uk-nav>
                    <li class="uk-nav-header"><?=lang('Global.account')?></li>
                    <li><a href="forgot"><span class="uk-margin-small-right" uk-icon="lock"></span> <?=lang('Auth.resetPassword')?></a></li>
                    <li><a href="myaccount"><span class="uk-margin-small-right" uk-icon="user"></span> <?=lang('Global.profile')?></a></li>
                    <li class="uk-nav-divider"></li>
                </ul>
            </div>
        </div>
        <main class="tm-main uk-section" style="background-color: #f2f7f8; height: 170px; overflow: auto; resize: both;" uk-height-viewport="offset-top: .uk-navbar-container; offset-bottom: .account-footer;">
            <div class="uk-container">
                <?= view('Views/Auth/_message_block') ?>
                <form class="uk-form-horizontal" action="updateaccount" method="POST">
                    <div class="uk-child-width-1-2@m uk-grid-small uk-grid-divider" uk-grid>
                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label"><?=lang('Global.memberid')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="text" value="<?=$account->memberid?>" disabled />
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="firstname"><?=lang('Global.firstname')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="text" name="firstname" value="<?=$account->firstname?>" required />
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="lastname"><?=lang('Global.lastname')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="text" name="lastname" value="<?=$account->lastname?>" required />
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="username"><?=lang('Auth.username')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="text" name="username" value="<?=$account->username?>" required />
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label" for="email"><?=lang('Auth.email')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="email" name="email" value="<?=$account->email?>" required />
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label"><?=lang('Global.phone')?></label>
                                <div class="uk-form-controls">
                                    <input class="uk-input" type="tel" value="+<?=$account->phone?>" disabled />
                                </div>
                            </div>
                            <?php
                            $today = date('d-m-Y');
                            if ($account->expired_at === null) {
                                $expire = '<span class="uk-text-danger uk-text-italic">'.lang('Global.notSubscribed').'</span>';
                            } else {
                                $subscription = date('d-m-Y', strtotime($account->expired_at));
                                if ($subscription < $today) {
                                    $expire = '<span class="uk-text-danger">'.$subscription.'</span>';
                                } else {
                                    $expire = $subscription;
                                }
                            }
                            ?>
                            <div class="uk-margin">
                                <label class="uk-form-label"><?=lang('Global.expiredate')?></label>
                                <div class="uk-form-controls">
                                    <?=$expire?>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label"><?=lang('Global.registerdate')?></label>
                                <div class="uk-form-controls">
                                    <?=date('d-m-Y', strtotime($account->created_at))?>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label class="uk-form-label"><?=lang('Global.updatedate')?></label>
                                <div class="uk-form-controls">
                                    <?=date('d-m-Y H:i:s', strtotime($account->updated_at))?>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <a class="uk-button uk-button-secondary uk-button-small" href="forgot"><?=lang('Global.passChange')?></a>
                            </div>
                        </div>
                        <div>
                            <div class="uk-flex uk-flex-center">
                                <div class="uk-width-2-3@m">
                                    <a href="images/member/<?=$account->membercard?>" download>
                                        <img class="uk-width-1-1" src="images/member/<?=$account->membercard?>" />
                                    </a>
                                </div>
                            </div>
                            <div class="uk-text-center uk-text-meta uk-text-italic"><?=lang('Global.imgClick')?></div>
                        </div>
                    </div>
                    <div class="uk-margin-medium">
                        <button class="uk-button uk-button-primary uk-button-large uk-text-uppercase" type="submit"><?=lang('Global.save')?></button>
                    </div>
                </form>
            </div>
        </main>
        <footer class="account-footer uk-section uk-section-xsmall uk-light" style="background-color: #000;">
            <?php if ($ismobile === false) { ?>
                <div class="uk-child-width-auto uk-flex-between uk-flex-middle uk-padding-small uk-padding-remove-top uk-padding-remove-bottom" uk-grid>
                    <?php
                    function auto_copyright($year = 'auto'){
                        if(intval($year) == 'auto'){ $year = date('Y'); }
                        if(intval($year) == date('Y')){ echo intval($year); }
                        if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
                        if(intval($year) > date('Y')){ echo date('Y'); }
                    }
                    ?>
                    <div class="uk-text-center">Copyright &copy <?php auto_copyright("2023"); ?>. Eight Gym</div>
                    <div class="uk-text-center">Developed by<br/><a class="uk-link-reset" href="https://binary111.com" target="_blank">PT. Kodebiner Teknologi Indonesia</a></div>
                </div>
            <?php } else { ?>
                <div>
                    <?php
                    function auto_copyright($year = 'auto'){
                        if(intval($year) == 'auto'){ $year = date('Y'); }
                        if(intval($year) == date('Y')){ echo intval($year); }
                        if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
                        if(intval($year) > date('Y')){ echo date('Y'); }
                    }
                    ?>
                    <div class="uk-margin-small uk-text-center">Copyright &copy <?php auto_copyright("2023"); ?>. Eight Gym</div>
                    <div class="uk-margin-small uk-text-center">Developed by<br/><a class="uk-link-reset" href="https://binary111.com" target="_blank">PT. Kodebiner Teknologi Indonesia</a></div>
                </div>
            <?php } ?>
        </footer>
    </body>
</html>