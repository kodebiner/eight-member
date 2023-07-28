<?= $this->extend('layout') ?>

<?= $this->section('pageStyles') ?>
<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery.webcam.js"></script>
<script src="js/jquery-ui.js"></script>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<form class="uk-form-horizontal" action="users/create" method="post">
    <div class="uk-flex-between uk-chidl-width-auto" uk-grid>
        <div><h1>Add New Member</h1></div>
        <div><button class="uk-button uk-button-large uk-button-primary" type="submit">Save</button></div>
    </div>
    <div class="uk-child-width-1-2@m" uk-grid>
        <div>
            <div class="uk-margin">
                <label class="uk-form-label" for="firstname"><?=lang('Global.firstname')?></label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="text" id="firstname" name="firstname" value="<?=old('firstname')?>" required/>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="lastname"><?=lang('Global.lastname')?></label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="text" id="lastname" name="lastname" value="<?=old('lastname')?>" required/>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="email"><?=lang('Auth.email')?></label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="email" id="email" name="email" value="<?=old('email')?>" required/>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="phone"><?=lang('Global.phone')?></label>
                <div class="uk-form-controls">
                    <div uk-grid>
                        <div class="uk-width-1-3@m">
                            <select class="uk-select" id="country-code" name="country-code" required>
                                <?php                                
                                foreach ($countries as $country) {
                                    if (!empty($country['idd']['root'])) {
                                        if ($country['name']['common'] === 'Indonesia') {
                                            echo '<option value="'.ltrim($country['idd']['root'], $country['idd']['root'][0]).implode($country['idd']['suffixes']).'" selected>'.$country['idd']['root'].implode($country['idd']['suffixes']).' '.$country['name']['common'].'</option>';
                                        } elseif (count($country['idd']['suffixes']) > 1) {
                                            echo '<option value="'.ltrim($country['idd']['root'], $country['idd']['root'][0]).'">'.$country['idd']['root'].' '.$country['name']['common'].'</option>';
                                        } else {
                                            echo '<option value="'.ltrim($country['idd']['root'], $country['idd']['root'][0]).implode($country['idd']['suffixes']).'">'.$country['idd']['root'].implode($country['idd']['suffixes']).' '.$country['name']['common'].'</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="uk-width-2-3@m">
                            <input class="uk-input" type="tel" id="phone" name="phone" required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="role"><?=lang('Global.accountType')?></label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="role" name="role" required>
                        <?php
                        foreach ($groups as $group) {
                            if (($role === 'owner') && (($group->name === 'owner') || ($group->name === 'staff'))) {
                                if (old('role') === $group->id) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="'.$group->id.'" '.$selected.'>'.$group->name.'</option>';
                            } elseif ($group->name === 'member') {
                                echo '<option value="'.$group->id.'" selected>'.$group->name.'</option>';
                            } 
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="expire"><?=lang('Global.subscription')?></label>
                <div class="uk-form-controls">
                    <div class="uk-inline">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                        <input class="uk-input uk-form-width-medium" type="text" id="expire" name="expire" value="<?=old('expire')?>" required/>
                    </div>
                </div>
            </div>
            <div class="uk-flex uk-flex-center uk-margin">
                <input id="photo" name="photo" value="<?=old('photo')?>" hidden />
                <div id="camera"></div>
            </div>
            <div class="uk-flex uk-flex-center uk-margin">
                <div id="take-snapshot" class="uk-button uk-button-primary">Take Snapshot</div>
            </div>
        </div>
        <div>
            <div class="uk-flex uk-flex-center uk-margin">
                <div id="snapshot">
                    <?php
                    if (old('photo') != null) {
                        echo '<img class="uk-width-1-1" src="'.old('photo').'" />';
                    }
                    ?>
                </div> 
            </div>
        </div>
        <script type="application/javascript">
            $( function() {
                $( "#expire" ).datepicker({
                    minDate: new Date(),
                    dateFormat: "yy-mm-dd",
                });
            } );
            Webcam.set({
                width: 640,
                height: 360,
                image_format: 'jpeg',
                jpeg_quality: 100
            });
        
            Webcam.attach( '#camera' );

            document.getElementById('take-snapshot').addEventListener('click', takesnapshot);
            function takesnapshot() {
                Webcam.snap( function(data_uri) {
                    $("#photo").val(data_uri);
                    document.getElementById('snapshot').innerHTML = '<img class="uk-width-1-1" src="'+data_uri+'"/>';
                });
            }
        </script>
    </div>
</form>
<?= $this->endSection() ?>