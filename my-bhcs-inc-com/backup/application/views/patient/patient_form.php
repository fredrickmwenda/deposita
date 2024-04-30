<div class="row">
    <!--  form area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <?php
            if($this->permission->method('patient_list','read')->access() || $this->permission->method('patient_list','update')->access() || $this->permission->method('patient_list','delete')->access()){
            ?>
            <div class="panel-heading no-print">
                <div class="btn-group">
                    <a class="btn btn-primary" href="<?php echo base_url("patient") ?>"> <i class="fa fa-list"></i>  <?php echo display('patient_list') ?> </a>
                </div>
            </div>
            <?php } ?>

            <?php
            if($this->permission->method('add_patient','create')->access() ){
            ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('patient/create','class="form-inner"') ?>

                            <?php echo form_hidden('id',$patient->id); ?>
                            <div class="form-group row">
                                <label for="branch" class="col-xs-3 col-form-label"> Choose Branch<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <select name='branch' class="form-control" id="branchSelect" >
                                    <?php if ($isAdmin): ?>
                                      <option value="newBranch">Add New Branch</option>
                                    <?php endif; ?>
                                    <?php foreach ($branches as $mBranch): ?>
                                      <option value="<?php echo $mBranch->id; ?>"><?php echo $mBranch->name ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="<?php echo display('first_name') ?>" value="<?php echo $patient->firstname ?>" autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="status" value="1">

                            <div class="form-group row">
                                <label for="middlename" class="col-xs-3 col-form-label">Middle Name</label>
                                <div class="col-xs-9">
                                    <input name="middlename" type="text" class="form-control" id="lastname" placeholder="Middle Name" value="<?php echo $patient->lastname ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="lastname" type="text" class="form-control" id="lastname" placeholder="<?php echo display('last_name') ?>" value="<?php echo $patient->lastname ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">Street Address<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="address" type="text" class="form-control" id="address" placeholder="Street Address" value="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">City/ State/ Zip Code<i class="text-danger">*</i></label>

                                <div class="col-xs-3">
                                    <input name="city" type="text" class="form-control" id="city" placeholder="City" value="" autocomplete="off">
                                </div>
                                <div class="col-xs-3">

                                      <select  id = "stateSel"  class="form-control" name="state">
                                        <option disabled>Choose State</option>
                                      </select>

                                </div>

                                <div class="col-xs-3">
                                  <input class="form-control" id="zipcode" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="zipcode" type="text" maxlength="5" placeholder="Zip Code" value="">
                                </div>
                              </div>

                            <div class="form-group row">
                                <label for="cellphone" class="col-xs-3 col-form-label">Mobile Number</label>
                                <div class="col-xs-9">
                                    <input name="phone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Alternate Phone</label>
                                <div class="col-xs-9">
                                    <input name="altphone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="next_of_kin" class="col-xs-3 col-form-label">Next of Kin</label>
                                <div class="col-xs-9">
                                    <input name="next_of_kin" type="text" class="form-control" id="lastname" placeholder="Next of Kin" value="<?php echo $patient->lastname ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label">Next of Kin Phone</label>
                                <div class="col-xs-9">
                                    <input name="kin_phone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber3">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Category<i class="text-danger">*</i></label>
                                <div class="col-xs-4">
                                  <select id = "categorySelect" class="form-control" name="category_id">
                                      <option disabled value="disabled">Choose Category</option>
                                      <option value="Skilled">Skilled</option>
                                      <option value="Un-Skilled">Un-Skilled</option>
                                  </select>

                                </div>

                                <label for="date_of_birth" class="col-xs-2 col-form-label">Start of Care<i class="text-danger">*</i></label>
                                <div class="col-xs-3">
                                    <input name="start_of_care" class="form-control" type="date" placeholder="Start of Care" id="date"  autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xs-3">Gender<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input type="radio" name="sex" value="Male" <?php echo  set_radio('sex', 'Male'); ?> ><?php echo display('male') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="sex" value="Female" <?php echo  set_radio('sex', 'Female'); ?> ><?php echo display('female') ?>
                                        </label>
                                        <label class="radio-inline">
                                        <input type="radio" name="sex" value="Other" <?php echo  set_radio('sex', 'Other'); ?> ><?php echo display('other') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label"><?php echo display('date_of_birth') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="date_of_birth" class=" form-control" type="date" placeholder="<?php echo display('date_of_birth') ?>" id="date_of_birth" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">Comments</label>
                                <div class="col-xs-9">
                                    <textarea name="comments" class="form-control"  placeholder="Write your comments here" maxlength="140" rows="7" id="address"></textarea>
                                </div>
                            </div>

                          </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
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

        </div>
    </div>


  <!-- Add Branch Modal-->
<form action="<?php echo base_url('main_department/create') ?>" method="post">
    <div class="modal fade" id="branchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <a href="<?php echo base_url('main_department') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">Branch List</a>
              <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New Branch</h5>
            </div>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
        <div class="modal-body">
          <?php
          if($this->permission->method('add_main_department','create')->access()){
          ?>
          <div class="panel-body panel-form">
              <div class="row">
                  <div class="col-md-9 col-sm-12">
                      <!-- Add Branch form -->
                      <?php echo form_hidden('id',$department->id) ?>

                      <div class="form-group row">
                          <label for="name" class="col-xs-3 col-form-label">Branch Name<i class="text-danger">*</i></label>
                          <div class="col-xs-9">
                              <input name="name"  type="text" class="form-control" id="name" placeholder="Branch Name" >
                          </div>
                      </div>

                      <?php
                      // Get current url
                      $this->load->helper('url');
                      $source = current_url();
                       ?>
                      <input type="hidden" name="source" value="<?php echo $source ?>">


                      <div class="form-group row">
                          <label for="description" class="col-xs-3 col-form-label">Branch Description</label>
                          <div class="col-xs-9">
                              <textarea name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"><?php echo $department->description ?></textarea>
                          </div>
                      </div>

                      <!--Radio-->
                      <div class="form-group row">
                          <label class="col-sm-3"><?php echo display('status') ?></label>
                          <div class="col-xs-9">
                              <div class="form-check">
                                  <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                  <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                              </div>
                          </div>
                      </div>



                  </div>
              </div>
          </div>
          <?php
          }

          ?>

        </div>
        <div class="modal-footer">

          <div class="ui buttons">
            <button type="button" data-dismiss="modal" class="ui button">Close</button>
            <div class="or"></div>
            <button class="ui positive button"><?php echo display('save') ?></button>
          </div>

        </div>
        </div>
    </div>
    </div>
</form>
<!-- End Branch Modal-->

<!-- Add Category Modal-->
<form action="<?php echo base_url('categories/create') ?>" method="post">
  <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <a href="<?php echo base_url('categories') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">Category List</a>
            <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New Category</h5>
          </div>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <?php
        if($this->permission->method('add_main_department','create')->access()){
        ?>
        <div class="panel-body panel-form">
            <div class="row">
                <div class="col-md-9 col-sm-12">
                    <!-- Add Branch form -->
                    <?php echo form_hidden('id',$department->id) ?>

                    <div class="form-group row">
                        <label for="name" class="col-xs-3 col-form-label">Category Name<i class="text-danger">*</i></label>
                        <div class="col-xs-9">
                            <input name="name"  type="text" class="form-control" id="name" placeholder="Category Name" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-xs-3 col-form-label">Category Description</label>
                        <div class="col-xs-9">
                            <textarea name="description" class="form-control"  placeholder="Category Description" rows="7"><?php echo $department->description ?></textarea>
                        </div>
                    </div>

                    <!--Radio-->
                    <div class="form-group row">
                        <label class="col-sm-3"><?php echo display('status') ?></label>
                        <div class="col-xs-9">
                            <div class="form-check">
                                <label class="radio-inline"><input type="radio" name="status" value="1" checked><?php echo display('active') ?></label>
                                <label class="radio-inline"><input type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <?php
        }

        ?>

      </div>
      <div class="modal-footer">

        <div class="ui buttons">
          <button type="button" data-dismiss="modal" class="ui button">Close</button>
          <div class="or"></div>
          <button class="ui positive button"><?php echo display('save') ?></button>
        </div>

      </div>
      </div>
  </div>
  </div>
</form>
<!-- End Category Modal-->

</div>
<script type="text/javascript">
$(document).ready(function() {
     // show dropdown month name and previous years
    $( ".dropdown-month-years" ).datepicker({
        dateFormat: "dd-mm-yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "-90:+0"
     });
});

var states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];


window.onload = function () {
	var stateSel = document.getElementById("stateSel");

		 for (var state in states) {
       var el = document.createElement("option");

    el.text = states[state];
    el.value = states[state];

    stateSel.add(el);
		 }
}

$("#categorySelect").prop("selectedIndex", 1);

var categorySelect = document.getElementById('categorySelect');

categorySelect.onchange = function(){

  if (categorySelect.options[ categorySelect.selectedIndex ].value == 'newCategory' ) {

      $('#categoryModal').modal('show');
    //1. show modal
    //2. Get modal submission
    //3. Show loading modal
    //4. Make Ajax request
    //5. On success::
        //5.1 Make ajax request to fecth new all branches
        //5.2 On success::
            //5.2.1 Add new branch to select options
            //5.2.2 Hide loading Modal

  }

}

//Add Branch
$("#branchSelect").prop("selectedIndex", 1);

var branchSelect = document.getElementById('branchSelect');

branchSelect.onchange = function(){

  if (branchSelect.options[ branchSelect.selectedIndex ].value == 'newBranch' ) {

      $('#branchModal').modal('show');
    //1. show modal
    //2. Get modal submission
    //3. Show loading modal
    //4. Make Ajax request
    //5. On success::
        //5.1 Make ajax request to fecth new all branches
        //5.2 On success::
            //5.2.1 Add new branch to select options
            //5.2.2 Hide loading Modal

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

const inputElement3 = document.getElementById('phoneNumber3');
inputElement3.addEventListener('keydown',enforceFormat);
inputElement3.addEventListener('keyup',formatToPhone);

</script>
