<?= $this->extend('layout') ?>

<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.js"></script>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<?php if ($ismobile === false) { ?>
<form class="uk-margin" action="" method="GET">
    <div class="uk-flex-between uk-child-width-auto" uk-grid>
        <div>
            <div class="uk-child-width-auto uk-flex-middle uk-grid-small" uk-grid>
                <div>Filter:</div>
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                    <input class="uk-input uk-form-width-small" type="text" id="startdate" name="startdate" value="<?=$input['startdate']?>" placeholder="<?=lang('Global.from')?>" />
                </div>
                <div class="uk-inline">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                    <input class="uk-input uk-form-width-small" type="text" id="enddate" name="enddate" value="<?=$input['enddate']?>" placeholder="<?=lang('Global.to')?>" />
                </div>
                <div><button class="uk-button uk-button-primary" id="submit" type="submit"><?=lang('Global.search')?></button></div>
            </div>
        </div>
        <div>
            <div class="uk-child-width-auto uk-flex-middle uk-grid-small" uk-grid>
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
    </div>
    <button id="submit" type="submit" hidden></button>
</form>
<?php } ?>
<script type="application/javascript">
    $( function() {
        $( "#startdate" ).datepicker({
            dateFormat: "yy-mm-dd",
        });
        $( "#enddate" ).datepicker({
            dateFormat: "yy-mm-dd",
        });
    } );
    document.getElementById('sort').addEventListener('change', formSubmit);
    function formSubmit() {
        document.getElementById("submit").click();
    }
</script>
<div class="uk-margin uk-overflow-auto">
    <table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle">
        <thead>
            <tr>
                <th>Member</th>
                <th>Check-In Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checkins as $checkin) { ?>
                <tr>
                    <td>
                        <?php
                        foreach ($users as $user) {
                            if ($user->id === $checkin['user_id']) {
                                echo $user->firstname.' '.$user->lastname;
                            }
                        }
                        ?>
                    </td>
                    <td><?=$checkin['checked_at']?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="2" class="uk-text-bold">Total Check-in: <?=count($total)?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="uk-margin"><?= $pager->links('checkin', 'uikit') ?></div>
<?= $this->endSection() ?>