<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Pesan Konfirmasi</title>
        <style>
            body {
                width: 100%;
                background-color: #fff;
                display: flex;
                flex-wrap: nowrap;
                justify-content: center;
            }
            p {
                font-size: 18px;
            }
            .content {
                width: 800px;
                margin: auto;
            }
            .container {
                margin: 20px;
                margin-bottom: 20px;
                border: 2px solid #cc0b24;
                border-radius: 20px;
                padding: 20px;
                width: 800px;
                background-color: #000;
                color: #fff !important;
            }
            .notice {
                width: 500px;
                font-size: 10px;
                line-height: 1.4;
                font-style: italic;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="container">
                <div style="width:100%; text-align: center; margin: 20px 0;">
                    <img src="<?=base_url()?>images/logo.png" width="80" height="80" />
                </div>
                <p><?=lang('Global.activation1Msg')?> <b>Eight Gym</b>.</p>
                <p><?=lang('Global.newMember1Msg')?> <b><?=$username?></b></p>
                <p>
                    <?=lang('Global.activation2Msg')?><br/>
                    <a href="<?= url_to('reset-password') . '?token=' . $hash ?>"><?= url_to('reset-password') . '?token=' . $hash ?></a>
                </p>
                <p>
                    <?=lang('Global.newMember2Msg')?><br/>
                    <a href="<?=url_to('login')?>"><?=url_to('login')?></a>
                </p>
                <p style="margin-top: 40px;"><?=lang('Global.activation3Msg')?></p>
            </div>
            <div class="notice"><?=lang('Global.emailNotes')?></div>
        </div>
    </body>
</html>