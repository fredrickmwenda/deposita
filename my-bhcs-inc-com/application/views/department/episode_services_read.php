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
             if($this->permission->method('add_main_department','create')->access()){
            ?>
            <div style="" class="panel-heading no-print">
              <div class="row">

                <div class="col-lg-6">
                  <a  class="btn btn-success" href="<?php echo base_url("patient/read/$patientId") ?>" > <i class="fa fa-arrow-left"></i>  Back</a>

                </div>

                    <div style="margin-top: .75%; font-size: 1.2em" class="col-lg-6 ml-4 row">
                      <label class="col-lg-4" for="">Patient Name:</label>
                      <p style=""><?php echo $patientName ?></p>
                    </div>

              </div>
            </div>
            <?php } ?>

            <?php
            if($this->permission->method('main_department','read')->access()  || $this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
            ?>
            <div class="panel-body">
                <!-- Nav tabs -->


                <!-- Tab panes -->
                <div class="col-xs-12 tab-content">

                    <!-- INFORMATION -->
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID No.</th>

                                            <th>Service Name</th>
                                            <th>Service Provider</th>

                                            <?php
                                            if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                            ?>
                                            <th><?php echo display('action') ?></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($episodeServices)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($episodeServices as $episodeService) { ?>
                                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $episodeService->name; ?></td>
                                                    <td><?php echo $episodeService->firstname." ".$episodeService->lastname; ?></td>

                                                    <?php
                                                     if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                                     ?>
                                                    <td class="center">
                                                    <?php
                                                     if($this->permission->method('main_department','update')->access()){
                                                     ?>

                                                        <a disabled class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>

                                                    <?php } ?>

                                                    </td>
                                                    <?php } ?>

                                                </tr>
                                                <?php $sl++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>  <!-- /.table-responsive -->
                            </div>
                        </div>
                    </div>

                    <!-- Add discipline Modal-->
                    <form action="<?php echo base_url('discipline/create') ?>" method="post">
                      <div class="modal fade" id="licenseTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                          <div class="modal-header">
                            <div class="row">
                              <a href="<?php echo base_url('discipline') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">Discipline List</a>
                              <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New Discipline</h5>
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


                                        <div class="form-group row">
                                            <label for="name" class="col-xs-3 col-form-label">Discipline Name<i class="text-danger">*</i></label>
                                            <div class="col-xs-9">
                                                <input name="name"  type="text" class="form-control" id="name" placeholder="Discipline Name" >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description" class="col-xs-3 col-form-label"><?php echo display('description') ?></label>
                                            <div class="col-xs-9">
                                                <textarea name="description" class="form-control"  placeholder="<?php echo display('description') ?>" rows="7"><?php echo $department->description ?></textarea>
                                            </div>
                                        </div>

                                        <!--Radio-->
                                        <div class="form-group row">
                                            <label class="col-sm-3">Status<i class="text-danger">*</i></label>
                                            <div class="col-xs-9">
                                                <div class="form-check">
                                                    <label class="radio-inline">
                                                    <input checked type="radio" name="status" value="1">Active
                                                    </label>

                                                    <label class="radio-inline">
                                                    <input type="radio" name="status" value="0">Inactive
                                                    </label>

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
                    <!-- End License Modal-->

                    <div role="tabpanel" class="tab-pane" id="language">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="datatable table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('serial') ?></th>
                                            <th><?php echo display('department_name') ?></th>
                                            <th><?php echo display('language') ?></th>
                                            <th><?php echo display('name') ?></th>
                                            <th><?php echo display('description') ?></th>
                                            <th><?php echo display('status') ?></th>
                                            <?php
                                            if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                            ?>
                                            <th><?php echo display('action') ?></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($lang_dprt)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($lang_dprt as $department) { ?>
                                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $department->dname; ?></td>
                                                    <td><?php echo $department->language; ?></td>
                                                    <td><?php echo $department->name; ?></td>
                                                    <td><?php echo character_limiter($department->description, 60); ?></td>
                                                    <td><?php echo (($department->status==1)?display('active'):display('inactive')); ?></td>


                                                    <?php
                                                     if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                                     ?>
                                                    <td class="center">
                                                    <?php
                                                     if($this->permission->method('main_department','update')->access()){
                                                     ?>
                                                        <a href="<?php echo base_url("main_department/edit_lang/$department->id") ?>" class="btn btn-xs  btn-primary"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>

                                                     <?php
                                                     if($this->permission->method('main_department','delete')->access()){
                                                     ?>
                                                        <a href="<?php echo base_url("main_department/delete_lang/$department->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
                                                     <?php } ?>

                                                    </td>
                                                    <?php } ?>

                                                </tr>
                                                <?php $sl++; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>  <!-- /.table-responsive -->
                            </div>
                        </div>
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
