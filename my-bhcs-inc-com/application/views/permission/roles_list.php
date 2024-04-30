
<style media="screen">


@media only screen and (min-width: 1125px) {
  .dataTables_wrapper  .dataTables_filter {

    float: left;
    text-align: left !important;
    margin-left: -110%
  }

  .dataTables_wrapper .dt-buttons {
  float:right !important;
  margin-right: -110%;
  }
}


</style>
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
                          <a class="btn btn-success"  href="<?php echo base_url("permission_assign/rolecreate") ?>" ?><i class="fa fa-plus"></i> Add Role</a>
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-12"></div>

              </div>


            </div>
        <?php } ?>

        <?php
        if($this->permission->method('role_list','read')->access() || $this->permission->method('role_list','update')->access() || $this->permission->method('role_list','delete')->access()){
        ?>
            <div class="panel-body">
                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo display('serial') ?></th>
                            <th>Role Name</th>
                             <?php
                               if($this->permission->method('role_list','update')->access() || $this->permission->method('role_list','delete')->access()){
                             ?>
                              <th><?php echo display('action') ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($role)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($role as $role) { ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $role->type; ?></td>
                                    <?php
                                    if($this->permission->method('role_list','update')->access() || $this->permission->method('role_list','delete')->access()){
                                    ?>
                                    <td>
                                        <div class="action-btn">


                                          <?php

                                          if($this->permission->method('role_list','update')->access()){
                                            ?>
                                              <a href="<?php echo base_url("permission_assign/read/$role->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
                                              <?php } ?>
                                        <?php
                                        if($this->permission->method('role_list','update')->access()){
                                          ?>
                                            <a href="<?php echo base_url("permission_assign/edit/$role->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                            <?php } ?>

                                            <?php
                                            if($this->permission->method('role_list','delete')->access()){
                                            ?>
                                            <a href="<?php echo base_url("permission_assign/delete/$role->id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?> ')"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
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
</div>
