<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">

            <?php
            if($this->permission->method('add_main_department','create')->access()){
            ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('#','class="form-inner"') ?>

                            <?php echo form_hidden('id',$department->id) ?>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label">New Due Date<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="date_of_birth" id="certFrom" class="dropdown-month-years form-control" type="text" placeholder="License New Due Date" id="date_of_birth"   autocomplete="off">
                                </div>

                            </div>


                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button">Cancel</button>
                                        <div class="or"></div>
                                        <button class="ui positive button">Renew</button>
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
