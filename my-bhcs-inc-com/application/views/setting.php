<div class="row">
    <!--  form area -->
    <?php
    if($this->permission->method('app_setting','read')->access() || $this->permission->method('app_setting','update')->access()){
    ?>
    <div class="col-sm-12">
        <div  class="panel panel-default panel-form">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('setting/create','class="form-inner form-inner-setting"') ?>
                            <?php echo form_hidden('setting_id',$setting->setting_id) ?>

                            <div class="form-group row">
                                <label for="title" class="col-xs-3 col-form-label">Company Name<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input readonly name="title" type="text" class="form-control" id="title" placeholder="Company Name" value="<?php echo $setting->title ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-xs-3 col-form-label">Street Address<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input readonly name="description" type="text" class="form-control" id="description" placeholder="Street Address"  value="<?php echo $setting->description ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">City/ State/ Zip Code<i class="text-danger">*</i></label>

                                <div class="col-xs-3">
                                    <input readonly name="city" type="text" class="form-control" id="city" placeholder="City" value="<?php echo $setting->city ?>" autocomplete="off">
                                </div>
                                <div class="col-xs-3">

                                  <?php
                                  $states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];
                                   ?>
                                      <select disabled id = ""  class="form-control" name="state">
                                        <option disabled>Choose State</option>
                                        <?php foreach ($states as $state): ?>
                                          <option value="<?php echo $state?>" <?php if ($setting->state == $state): ?>
                                            <?php echo 'selected' ?>
                                          <?php endif; ?> ><?php echo $state ?></option>
                                        <?php endforeach; ?>
                                      </select>

                                </div>

                                <div class="col-xs-3">
                                  <input value="<?php echo $setting->zipcode ?>" disabled class="form-control" id="zipcode" name="zipcode" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" maxlength="5" placeholder="Zip Code" value="">

                                </div>
                              </div>

                            <div class="form-group row">
                                <label for="email" class="col-xs-3 col-form-label"><?php echo display('email')?></label>
                                <div class="col-xs-9">
                                    <input readonly name="email" type="email" class="form-control" id="email" placeholder="<?php echo display('email')?>"  value="<?php echo $setting->email ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Mobile Number</label>
                                <div class="col-xs-9">
                                    <input readonly value="<?php echo $setting->phone ?>" name="cellphone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Fax</label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $setting->fax ?>"  readonly name="fax" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber2">
                                </div>
                            </div>


                            <!-- if setting favicon is already uploaded -->
                            <?php if(!empty($setting->favicon)) {  ?>
                            <div class="form-group row">
                                <label for="faviconPreview" class="col-xs-3 col-form-label"></label>
                                <div class="col-xs-9">
                                    <img src="<?php echo base_url($setting->favicon) ?>" alt="Favicon" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="favicon" class="col-xs-3 col-form-label"><?php echo display('favicon') ?> </label>
                                <div class="col-xs-9">
                                    <input disabled type="file" name="favicon" id="favicon">
                                    <input readonly type="hidden" name="old_favicon" value="<?php echo $setting->favicon ?>">
                                </div>
                            </div>


                            <!-- if setting logo is already uploaded -->
                            <?php if(!empty($setting->logo)) {  ?>
                            <div class="form-group row">
                                <label for="logoPreview" class="col-xs-3 col-form-label"></label>
                                <div class="col-xs-9">
                                    <img src="<?php echo base_url($setting->logo) ?>" alt="Picture" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="logo" class="col-xs-3 col-form-label"><?php echo display('logo') ?></label>
                                <div class="col-xs-9">
                                    <input disabled type="file" name="logo" id="logo">
                                    <input readonly type="hidden" name="old_logo" value="<?php echo $setting->logo ?>">
                                </div>
                            </div>

                            <div style="display: none" class="form-group row">
                                <label for="footer_text" class="col-xs-3 col-form-label"><?php echo display('language') ?></label>
                                <div class="col-xs-9">
                                    <?= form_dropdown('language',$languageList,$setting->language, 'class="form-control"') ?>
                                </div>
                            </div>

                            <div style="display: none" class="form-group row">
                                <label for="time_zone" class="col-xs-3 col-form-label"><?php echo display('time_zone') ?>  <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <select id="time_zone" name="time_zone" class="form-control">
                                        <option value=""><?php echo display('select_option') ?></option>
                                        <?php foreach (timezone_identifiers_list() as $value) { ?>
                                            <option value="<?php echo $value ?>" <?php echo (($setting->time_zone==$value)?'selected':null) ?>><?php echo $value ?></option>";
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div style="display: none" class="form-group row">
                                <label for="left_to_right" class="col-xs-3 col-form-label"><?php echo display('site_align') ?></label>
                                <div class="col-xs-9">
                                    <?= form_dropdown('site_align', array('LTR' => display('left_to_right'), 'RTL' => display('right_to_left')) ,$setting->site_align, 'class="form-control"') ?>
                                </div>
                            </div>

                            <?php
                            if($this->permission->method('app_setting','update')->access()){
                            ?>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a href="<?php echo base_url("setting/edit") ?>" class="ui positive button">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
 else{
 ?>
    <div class="col-sm-12">
       <div class="panel panel-bd lobidrag">
        <div class="panel-heading">
          <div class="panel-title">
            <h4><?php echo display('you_do_not_have_permission_to_access_please_contact_with_administrator');?>.</h4>
           </div>
           </div>
         </div>
        </div>
 <?php
 }
 ?>


<script type="text/javascript">

var states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];


window.onload = function () {
  var stateSel = document.getElementById("stateSel");

     for (var state in states) {
       var el = document.createElement("option");

    el.text = states[state];
    el.value = state;

    stateSel.add(el);
     }
}

const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
    );
};

const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
            // Allow Ctrl/Command + A,C,V,X,Z
            (event.ctrlKey === true || event.metaKey === true) &&
            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
};

const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if(!isNumericInput(event) && !isModifierKey(event)){
        event.preventDefault();
    }
};

const formatToPhone = (event) => {
    if(isModifierKey(event)) {return;}

    const input = event.target.value.replace(/\D/g,'').substring(0,10); // First ten digits of input only
    const areaCode = input.substring(0,3);
    const middle = input.substring(3,6);
    const last = input.substring(6,10);

    if(input.length > 6){event.target.value = `(${areaCode}) ${middle} - ${last}`;}
    else if(input.length > 3){event.target.value = `(${areaCode}) ${middle}`;}
    else if(input.length > 0){event.target.value = `(${areaCode}`;}
};

const inputElement = document.getElementById('phoneNumber');
inputElement.addEventListener('keydown',enforceFormat);
inputElement.addEventListener('keyup',formatToPhone);

const inputElement2 = document.getElementById('phoneNumber2');
inputElement2.addEventListener('keydown',enforceFormat);
inputElement2.addEventListener('keyup',formatToPhone);


</script>
</div>
