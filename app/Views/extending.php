<?= $this->extend('layout') ?>

<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery.webcam.js"></script>
<script src="js/jquery-ui.js"></script>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?php if (!empty($user)) { ?>
<div class="uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: .tm-footer;">
    <div class="uk-width-1-1">
        <div class="uk-h2 uk-text-center uk-margin-remove"><?=$user->firstname?> <?=$user->lastname?></div>
        <div class="uk-margin">
            <div class="uk-text-center">Expired At</div>
            <?php
            $ed = date('d-m-Y', strtotime($user->expired_at));
            if(strtotime($user->expired_at) < strtotime('-2 months')) {
                $expired = '<div class="uk-text-center"><span style="background-color:#da2550; color:#fff; padding: 0 5px;">'.lang('Global.adminFeeReq').'</span></div>';
            } else {
                $expired = '';
            }
            ?>
            <div class="uk-h3 uk-margin-remove uk-text-center"><?=$ed?></div>
            <?=$expired?>
        </div>
        <form action="users/extending" method="post">
            <input name="id" value="<?=$user->id?>" hidden/>
            <div class="uk-margin uk-flex uk-flex-center">
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                    <input class="uk-input uk-form-width-medium" type="text" id="expire" name="expire" placeholder="<?=lang('Global.extendTo')?>" required/>
                </div>
            </div>
            <div class="uk-margin uk-flex uk-flex-center">
                <div class="uk-child-width-auto uk-grid-small" uk-grid>
                    <div><label><input class="uk-radio" type="radio" name="sub_type" value="0" required> <?=lang('Global.noPromo')?></label></div>
                    <div><label><input class="uk-radio" type="radio" name="sub_type" value="1" required> <?=lang('Global.withPromo')?></label></div>
                </div>
            </div>
            <div id="promo-select" class="uk-margin uk-flex uk-flex-center" hidden>
                <select class="uk-select uk-width-medium" id="promoid" name="promoid">
                    <option value="" disabled selected><?=lang('Global.selectPromo')?></option>
                    <?php
                    foreach ($promos as $promo) {
                        echo '<option value="'.$promo['id'].'">'.$promo['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <script>
                $('input[type=radio][name=sub_type]').change(function() {
                    if (this.value == '0') {
                        document.getElementById('promo-select').setAttribute('hidden', '');
                        document.getElementById('promoid').removeAttribute('required');
                    } else if (this.value == '1') {
                        document.getElementById('promo-select').removeAttribute('hidden');
                        document.getElementById('promoid').setAttribute('required', '');
                    }
                });
            </script>
            <div class="uk-margin uk-text-center">
                <button class="uk-button uk-button-primary" type="submit"><?=lang('Global.extend')?></button>
            </div>
        </form>
        <script type="application/javascript">
            $( function() {
                $( "#expire" ).datepicker({
                    minDate: new Date(),
                    dateFormat: "yy-mm-dd",
                });
            } );
        </script>
    </div>
</div>
<?php } else { ?>
    <div class="uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: .tm-footer;">
        <div class="uk-width-1-1">
            <h1 class="uk-margin-remove uk-text-center uk-text-italic"><?=lang('Global.noData')?></h1>
        </div>
    </div>    
<?php } ?>
<?= $this->endSection() ?>