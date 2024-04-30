<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
        <?php
        if($this->permission->method('add_employee','create')->access()){
        ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('human_resources/employee/form_user/'.$employee->user_id,'class="form-inner"') ?>
                            <?php echo form_hidden('user_id',$employee->user_id) ?>
                            <div class="form-group row">

                                <div class="col-xs-9">
                                    <input type="hidden" name="password" value="">
                                      <input type="hidden" name="status" value="1">
                                      <input type="hidden" name="password_status" value="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="branch" class="col-xs-3 col-form-label"> Choose Role<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <select disabled name='user_role' class="form-control" id="user_role" >
                                    <option value="newBranch">Choose Role</option>
                                    <?php foreach ($userRoles as $role): ?>
                                      <option value="<?php echo $role->id; ?>" <?php if ($employee->user_role == $role->id){
                                        echo "selected";
                                      }?>><?php echo $role->type ?></option>
                                    <?php endforeach; ?>
                                  </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="branch" class="col-xs-3 col-form-label"> Choose Branch<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <select disabled name='branch' class="form-control" id="user_role" >
                                    <option value="newBranch">Add New Branch</option>
                                    <?php foreach ($branches as $mBranch): ?>
                                      <option value="<?php echo $mBranch->id; ?>" <?php if ($employee->branch == $mBranch->id){
                                        echo "selected";
                                      }?>><?php echo $mBranch->name ?></option>
                                    <?php endforeach; ?>
                                  </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->firstname ?>" disabled name="firstname" type="text" class="form-control" id="firstname" placeholder="<?php echo display('first_name') ?>">
                                </div>
                             </div>

                            <div class="form-group row">
                                <label for="middlename" class="col-xs-3 col-form-label">Middle Name<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->middlename ?>" disabled name="lastname" type="text" class="form-control" id="lastname" placeholder="Middle Name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->lastname ?>" disabled name="lastname" type="text" class="form-control" id="lastname" placeholder="<?php echo display('last_name') ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-xs-3 col-form-label"><?php echo display('email')?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input disabled value="<?php echo $employee->email?>" name="email" class="form-control" type="text" placeholder="<?php echo display('email')?>" id="email">
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-3">Gender</label>
                                <div class="col-xs-9">
                                  <div class="form-check">
                                      <label class="radio-inline">
                                      <input <?php if ($employee->sex == 'Male'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> disabled type="radio" name="sex" value="Male"><?php echo display('male')?>
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($employee->sex == 'Female'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> disabled type="radio" name="sex" value="Female"><?php echo display('female')?>
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($employee->sex == 'Other'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> disabled type="radio" name="sex" value="Other"><?php echo display('others')?>
                                      </label>

                                  </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cellphone" class="col-xs-3 col-form-label">Cell Phone </label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->cellphone ?>" disabled name="cellphone" class="form-control" maxlength="16" type="tel" placeholder="(123) 456 - 7891" id="phoneNumber" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Status<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <div class="form-check">
                                    <label class="radio-inline">
                                    <input disabled <?php if ($employee->status == 1) {
                                      // code...
                                      echo "checked";
                                    } ?> type="radio" name="status" value="1">Active
                                    </label>

                                    <label class="radio-inline">
                                    <input disabled <?php if ($employee->status == 0) {
                                      // code...
                                      echo "checked";
                                    } ?> type="radio" name="status" value="0">Inactive
                                    </label>

                                  </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                  <div class="ui buttons">
                                      <a href="<?php echo base_url('human_resources/employee/form_user/'.$employee->user_id) ?>" class="ui positive button">Edit</a>
                                  </div>
                                </div>
                            </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <?php
                }
                 else{
                 ?>
                   <div class="row">
                    <div class="col-sm-12">
                       <div class="panel panel-bd lobidrag">
                        <div class="panel-heading">
                          <div class="panel-title">
                            <h4><?php echo display('you_do_not_have_permission_to_access_please_contact_with_administrator');?>.</h4>
                           </div>
                           </div>
                         </div>
                        </div>
                     </div>
                 <?php
                 }
                 ?>
        </div>
    </div>
<script type="text/javascript">
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

</script>
</div>
