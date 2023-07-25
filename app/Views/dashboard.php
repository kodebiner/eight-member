<?= $this->extend('layout') ?>
<?= $this->section('main') ?>
<div class="uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: .tm-footer;">
    <div class="uk-width-1-1 uk-child-width-1-2@m" uk-grid>
        <div>
            <a class="uk-link-reset" href="users/checkin">
                <div class="uk-card uk-card-primary uk-card-hover uk-card-large uk-card-body">
                    <h1 class="uk-margin-remove uk-text-center">Check-In</h1>
                </div>
            </a>
        </div>
        <div>
            <a class="uk-link-reset" href="users/newmember">
                <div class="uk-card uk-card-secondary uk-card-hover uk-card-large uk-card-body">
                    <h1 class="uk-margin-remove uk-text-center">New Member</h1>
                </div>
            </a>
        </div>
        <div>
            <a class="uk-link-reset" href="users/extend">
                <div class="uk-card uk-card-default uk-card-hover uk-card-large uk-card-body">
                    <h1 class="uk-margin-remove uk-text-center">Extend</h1>
                </div>
            </a>
        </div>
        <div>
            <a class="uk-link-reset" href="users">
                <div class="uk-card uk-card-primary uk-card-hover uk-card-large uk-card-body">
                    <h1 class="uk-margin-remove uk-text-center">Member List</h1>
                </div>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>