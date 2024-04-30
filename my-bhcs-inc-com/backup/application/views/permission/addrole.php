<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
          <?php
          if($this->permission->method('add_employee','create')->access()){
          ?>
              <div class="panel-heading no-print">

                <div class="row">
                    <div class="col-lg-2 col-sm-12">
                        <div class="btn-group">
                            <a class="btn btn-success"  href="<?php echo base_url("permission_assign/rolelist") ?>" ?><i class="fa fa-plus"></i> Roles List</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12"></div>

                </div>


              </div>
          <?php } ?>
       <?php
        if($this->permission->method('add_role','create')->access()){
        ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('permission_assign/create','class="form-inner"') ?>

                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label"><?php echo display('role_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="type" type="text" class="form-control" id="lastname" placeholder="<?php echo display('role_name') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <a href="<?php echo base_url('permission_assign/rolelist') ?>" class="ui button">Cancel</a>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <?php
            }
            else{
            ?>
            <div class="panel panel-bd lobidrag">
              <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('you_do_not_have_permission_to_access_please_contact_with_administrator');?>.</h4>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
