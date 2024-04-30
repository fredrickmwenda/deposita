<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <?php
            if($this->permission->method('main_department','read')->access()  || $this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
            ?>

            <?php } ?>
            <?php
            if($this->permission->method('add_main_department','create')->access()){
            ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('license/create/'.$license->id,'class="form-inner"') ?>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">License Type<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <select class="form-control" name="licType">
                                    <option disabled value ='choose'>Choose License Type</option>

                                    <?php foreach ($licenses as $eLicense): ?>
                                        <option <?php if ($eLicense->name == $license->licType) {
                                            echo 'selected';
                                        } ?> value="<?php echo $eLicense->name ?>"><?php echo $eLicense->name ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                            </div>

                            <input type="hidden" name="employeeId" value="<?php echo $license->employeeId ?>">

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">From Date<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $license->licFrom ?>" name="licFrom" id="certFrom" class="form-control" type="date" placeholder="12/12/1932" id="date_of_birth"   autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">Due Date<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $license->licDue ?>" name="licDue" id="certFrom" class="form-control" type="date" placeholder="12/12/1933" id="date_of_birth"   autocomplete="off">
                                </div>

                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3">Status<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <div class="form-check">
                                        <label class="radio-inline">
                                        <input <?php if ($license->status == 1): ?>
                                          <?php echo 'checked'; ?>
                                        <?php endif; ?> type="radio" name="status" value="1">Active
                                        </label>

                                        <label class="radio-inline">
                                        <input <?php if ($license->status == 0): ?>
                                          <?php echo 'checked'; ?>
                                        <?php endif; ?> type="radio" name="status" value="0">Inactive
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button">Update</button>
                                    </div>
                                </div>
                            </div>


                        <?php echo form_close() ?>

                    </div>
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
    $(document).ready(function() {
         // show dropdown month name and previous years
        $( ".dropdown-month-years" ).datepicker({
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+0"
         });
    });
    </script>

</div>
