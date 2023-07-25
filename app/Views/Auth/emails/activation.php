<style>
    .body {
        width: 100%;
        background-color: #000;
        display: flex;
        justify-content: center;
    }
    .container {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 2px solid ##cc0b24;
        border-radius: 20px;
        padding: 20px;
        width: 500px;
        background-color: #fff;
    }
    .notice {
        width: 500px;
        font-size: 10px;
        line-height: 1.4;
        color: #fff;
        font-style: italic;
        margin-bottom: 20px;
    }
</style>
<div class="body">
    <div class="uk-container">
        <div style="width:100%; text-align: center; margin: 20px 0;">
            <img src="<?=base_url()?>images/logo.png" width="80" height="80" />
        </div>
        <p><?=lang('Global.activation1Msg')?> <?= site_url() ?>.</p>
        <p>
            <?=lang('Global.activation2Msg')?><br/>
            <a href="<?= url_to('activate-account') . '?token=' . $hash ?>"><?= url_to('activate-account') . '?token=' . $hash ?></a>
        </p>
        <p style="margin-top: 40px;"><?=lang('Global.activation2Msg')?></p>
    </div>
</div>
<div class="body">
    <div class="notice"><?=lang('Global.emailNotes')?></div>
</div>