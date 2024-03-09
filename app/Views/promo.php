<?= $this->extend('layout') ?>

<?= $this->section('main') ?>
<div class="uk-container uk-container-small">
<div class="uk-flex uk-flex-right">
    <a class="uk-button uk-button-primary" href="#newpromo" uk-toggle>+ <?=$create?></a>
</div>
<table class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-middle">
    <thead>
        <tr>
            <th>No.</th>
            <th><?=$name?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $idx = 0;
        foreach ($promos as $promo) {
            $idx++;
            echo '<tr>';
            echo '<td class="uk-text-center uk-table-shrink">'.$idx.'</td>';
            echo '<td class="uk-table-expand">'.$promo['name'].'</td>';
            echo '<td>';
            echo '<div class="uk-flex-right uk-child-width-auto uk-grid-small" uk-grid>';
            echo '<div><a href="#editpromo'.$promo['id'].'" uk-toggle uk-icon="pencil"></a></div>';
            echo '<div><a href="#deletepromo'.$promo['id'].'" uk-toggle uk-icon="trash"></a></div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="uk-margin"><?= $pager->links('promos', 'uikit') ?></div>
<div id="newpromo" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title"><?=$create?></h3>
        </div>
        <form class="uk-form-horizontal" action="promo/create" method="post">
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label class="uk-form-label" for="name"><?=$name?></label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" name="name" required />
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-flex uk-flex-center">
                <button class="uk-button uk-button-primary" type="submit"><?=lang('Global.save')?></button>
            </div>
        </form>
    </div>
</div>
<?php foreach ($promos as $promo) { ?>
<div id="editpromo<?=$promo['id']?>" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h3 class="uk-modal-title"><?=$edit?></h3>
        </div>
        <form class="uk-form-horizontal" action="promo/update/<?=$promo['id']?>" method="post">
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label class="uk-form-label" for="name"><?=$name?></label>
                    <div class="uk-form-controls">
                        <input class="uk-input" type="text" name="name" value="<?=$promo['name']?>" required />
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-flex uk-flex-center">
                <button class="uk-button uk-button-primary" type="submit"><?=lang('Global.save')?></button>
            </div>
        </form>
    </div>
</div>
<div id="deletepromo<?=$promo['id']?>" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title"><?=lang('Global.areYouSure')?></h3>
        </div>
        <form class="uk-form-horizontal" action="promo/delete" method="post">
            <input name="promoid" value="<?=$promo['id']?>" hidden />
            <div class="uk-modal-body">
                <div class="uk-child-width-auto uk-flex-center" uk-grid>
                    <div>
                    <button class="uk-button uk-button-secondary" type="submit">Yes</button>
                    </div>
                    <div>
                        <a class="uk-button uk-button-danger" onclick="UIkit.modal('#deletepromo<?=$promo['id']?>').hide();">No</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php } ?>
</div>
<?= $this->endSection() ?>