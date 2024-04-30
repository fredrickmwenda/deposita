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

                        <?php echo form_open_multipart('discipline/create/'.$discipline->id,'class="form-inner"') ?>

                        <div class="form-group row">
                            <label for="name" class="col-xs-3 col-form-label">Discipline<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="name" value="<?php echo $discipline->name ?>" type="text" class="form-control" id="name" placeholder="Branch Name" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                            <div class="col-xs-9">
                                <input value="<?php echo $discipline->description ?>" style="height: 100px" name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"><?php echo $department->description ?></input>
                            </div>
                        </div>

                        <!--Radio-->
                        <div class="form-group row">
                            <label class="col-sm-3"><?php echo display('status') ?></label>
                            <div class="col-xs-9">
                                <div class="form-check">
                                    <label class="radio-inline"><input type="radio" name="status" <?php if ($discipline->status == 1) {
                                      echo 'checked';
                                    } ?> value="1" ><?php echo display('active') ?></label>
                                    <label class="radio-inline"><input <?php if ($discipline->status == 0) {
                                      echo 'checked';
                                    } ?> type="radio" name="status" value="0"><?php echo display('inactive') ?></label>
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
