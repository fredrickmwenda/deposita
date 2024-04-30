<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <?php
            if(1>0){
            ?>
            <div style="background-color: #45C203" class="panel-heading no-print">
              <div class="row">
                <div  style="margin-top: ; text-align: center; border: solid 0px; border-radius: 0px" class="  alert alert-success alert-dismissable">
                  <p style="margin-bottom: -2%">  Please set a password to continue.</p>

                </div>

              </div>
            </div>
            <?php } ?>
            <?php
            if(1>0){
            ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('dashboard/set_password','class="form-inner"') ?>



                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Password<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="password"  type="password" class="form-control" id="name" placeholder="Password" required >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label">Confirm Password<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input required name="confirm"  type="password" class="form-control" id="name" placeholder="Confirm Password" >
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">

                                        <button class="ui positive button">Set Password</button>
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

</div>
