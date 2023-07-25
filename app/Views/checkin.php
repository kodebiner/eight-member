<?= $this->extend('layout') ?>
<?= $this->section('main') ?>
<div class="uk-flex uk-flex-middle" uk-height-viewport="offset-top: true; offset-bottom: .tm-footer;">
    <div class="uk-width-1-1">
        <div class="uk-h2 uk-text-center uk-margin-remove">Scan the QR Code to the scanner</div>
        <form action="users/checkin" method="get">
            <div class="uk-margin-top uk-width-1-1 uk-flex uk-flex-center">
                <input class="uk-input uk-form-width-medium uk-form-large" id="memberid" name="memberid" autofocus />
            </div>
            <button id="submit" type="submit" hidden></button>
        </form>        
        <script type="application/javascript">
            document.getElementById('memberid').addEventListener('change', submitform);
            function submitform() {
                document.getElementById('submit').click();
            }
        </script>
    </div>
</div>
<?= $this->endSection() ?>