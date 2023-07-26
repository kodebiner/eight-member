<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?=lang('Auth.forgotSubject')?></title>
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
                margin-top: 20px;
                margin-bottom: 20px;
                border: 2px solid #cc0b24;
                border-radius: 20px;
                padding: 20px;
                width: 800px;
                background-color: #000;
                color: #fff;
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
                <p>Someone requested a password reset at this email address for <?= site_url() ?>.</p>
                <p>To reset the password use this code or URL and follow the instructions.</p>
                <p>Your Code: <?= $hash ?></p>
                <p>Visit the <a href="<?= url_to('reset-password') . '?token=' . $hash ?>">Reset Form</a>.</p>
                <p style="margin-top: 40px;">If you did not request a password reset, you can safely ignore this email.</p>
            </div>
            <div class="notice"><?=lang('Global.emailNotes')?></div>
        </div>
    </body>
</html>