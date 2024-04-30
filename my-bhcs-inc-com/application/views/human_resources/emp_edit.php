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
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">
                        <?php echo form_open_multipart('human_resources/employee/form/'.$employee->user_id,'class="form-inner"') ?>
                            <?php echo form_hidden('user_id',$employee->user_id) ?>
                            <div class="form-group row">
                              <label for="date_of_birth" class="col-xs-3 col-form-label">Creation Date <i class="text-danger">*</i></label>
                              <div class="col-xs-9">
                                  <input disabled value="<?php echo $employee->create_date ?>"  onfocusout="(this.type='text')" onfocus="(this.type='date')" name="create_date" class="dropdown-month-years form-control" type="text" placeholder="1-1-2010" autocomplete="off">
                              </div>
                            </div>
                            <div class="form-group row">
                                <label for="branch" class="col-xs-3 col-form-label"> Choose Branch<i class="text-danger">*</i></label>
                                <div id="branchSelect2" class="col-xs-9">
                                  <select name='branch' id="branchSelect" class="form-control">

                                      <?php foreach ($branches as $mBranch): ?>
                                        <option value="<?php echo $mBranch->id; ?>" <?php if ($employee->branch == $mBranch->name){
                                          echo "selected";
                                        }?>><?php echo $mBranch->name ?></option>
                                      <?php endforeach; ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->firstname ?>" name="firstname" type="text" class="form-control" id="firstname" placeholder="<?php echo display('first_name') ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="middlename" class="col-xs-3 col-form-label">Middle Name</label>
                                <div class="col-xs-9">
                                    <input name="middlename" value="<?php echo $employee->middlename ?>" type="text" class="form-control" id="lastname" placeholder="Middle Name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->lastname ?>" name="lastname" type="text" class="form-control" id="lastname" placeholder="<?php echo display('last_name') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">Street Address<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->address ?>"  name="address" type="text" class="form-control" id="address" placeholder="Street Address" value="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-xs-3 col-form-label">City/ State/ Zip Code<i class="text-danger">*</i></label>

                                <div class="col-xs-3">
                                    <input value="<?php echo $employee->city ?>" name="city" type="text" class="form-control" id="city" placeholder="City" value="" autocomplete="off">
                                </div>
                                <div class="col-xs-3">
                                  <?php
                                  $states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];
                                   ?>
                                      <select id = "stateSell"  class="form-control" name="state">
                                        <option disabled>Choose State</option>
                                        <?php foreach ($states as $state): ?>
                                          <option value="<?php echo $state?>" <?php if ($employee->state == $state): ?>
                                            <?php echo 'selected' ?>
                                          <?php endif; ?> ><?php echo $state ?></option>
                                        <?php endforeach; ?>
                                      </select>

                                </div>
                                <div class="col-xs-3">
                                  <input value="<?php echo $employee->zipcode ?>" class="form-control" id="zipcode" name="zipcode" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" maxlength="5" pattern="[0-9]*" placeholder="Zip Code" value="">
                                </div>
                              </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Cell Phone </label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->cellphone ?>" name="cellphone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label">Home Phone</label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->homephone ?>" name="homephone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber2">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Emergency Contact</label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->emContact ?>" name="emContact" placeholder="Emergency Contact Name" class="form-control" type="text" >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label">Emergency Contact Phone</label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $employee->emPhone ?>" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber4" name="emPhone">
                                </div>
                            </div>

                            <div class="form-group row">

                               <label for="discipline" class="col-xs-3 col-form-label">Discipline<i class="text-danger">*</i></label>
                               <div class="col-xs-4">
                                 <select id = "disciplineSelect" class="form-control" name="discipline">


                                  <?php foreach ($disciplines as $discipline): ?>
                                    <option <?php if ($employee->discipline == $discipline->name){
                                      echo "selected";
                                    } ?>
                                      value="<?php echo $discipline->name ?>"><?php echo $discipline->name ?></option>
                                  <?php endforeach; ?>

                                 </select>

                           </div>
                           <label for="hire_date" class="col-xs-2 col-form-label">Hire Date<i class="text-danger">*</i></label>
                           <div class="col-xs-3">
                               <input value="<?php echo $employee->hire_date ?>" name="hire_date" onfocusout="(this.type='text')" onfocus="(this.type='date')" class="dropdown-month-years form-control" type="text" placeholder="1-1-2010" id="hire_date" autocomplete="off">
                           </div>

                         </div>
                         <div class="form-group row">
                             <label class="col-sm-3">Gender<i class="text-danger">*</i></label>
                             <div class="col-xs-9">
                                 <div class="form-check">
                                     <label class="radio-inline">
                                     <input <?php if ($employee->sex == 'Male'): ?>
                                       <?php echo 'checked'; ?>
                                     <?php endif; ?> type="radio" name="sex" value="Male"><?php echo display('male')?>
                                     </label>

                                     <label class="radio-inline">
                                     <input <?php if ($employee->sex == 'Female'): ?>
                                       <?php echo 'checked'; ?>
                                     <?php endif; ?> type="radio" name="sex" value="Female"><?php echo display('female')?>
                                     </label>

                                     <label class="radio-inline">
                                     <input <?php if ($employee->sex == 'Other'): ?>
                                       <?php echo 'checked'; ?>
                                     <?php endif; ?> type="radio" name="sex" value="Other"><?php echo display('others')?>
                                     </label>

                                 </div>
                             </div>
                         </div>
                         <div class="form-group row">
                           <label for="date_of_birth" class="col-xs-3 col-form-label"><?php echo display('date_of_birth') ?> <i class="text-danger">*</i></label>
                           <div class="col-xs-9">
                               <input value="<?php echo $employee->date_of_birth?>" name="date_of_birth" class="dropdown-month-years form-control" type="date" placeholder="1-1-2010"  autocomplete="off">
                           </div>

                         </div>

                         <div class="form-group row">
                             <label class="col-sm-3">Status<i class="text-danger">*</i></label>
                             <div class="col-xs-9">
                                 <div class="form-check">
                                     <label class="radio-inline">
                                     <input <?php if ($employee->status == 1): ?>
                                       <?php echo 'checked'; ?>
                                       <?php endif; ?> type="radio" name="status" value="1">Active
                                     </label>

                                     <label class="radio-inline">
                                     <input <?php if ($employee->status == 0): ?>
                                       <?php echo 'checked'; ?>
                                     <?php endif; ?> type="radio" name="status" value="0">Inactive
                                     </label>

                                 </div>
                             </div>
                         </div>

                           <div class="form-group row">
                               <label for="address" class="col-xs-3 col-form-label">Comments</label>
                               <div class="col-xs-9">
                                   <input style="height: 100px" value="<?php echo $employee->comments ?>" name="comments" class="form-control"  placeholder="No comments" maxlength="140" rows="7" id="address"></input>
                               </div>
                           </div>

                           <input type="hidden" name="gen_role" value="employee">

                            <div class="form-group row">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <div class="ui buttons">
                                        <button class="ui positive button">Update</button>
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


      <!-- License Modal-->
    <form action="<?php echo base_url('/license/create'); ?>" method="post">
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
              <div class="row">
                <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New License</h5>
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

                              <?php echo form_hidden('employeeId',$employee->user_id) ?>

                              <div class="form-group row">
                                  <label for="name" class="col-xs-3 col-form-label">License Type<i class="text-danger">*</i></label>
                                  <div class="col-xs-9">
                                      <select id="licenseSelect" class="form-control" name="licType" required>
                                        <?php if ($isAdmin): ?>
                                          <option value="addLicenseType">Add License Type</option>
                                        <?php endif; ?>
                                        <?php foreach ($licenseTypes as $licenseType): ?>
                                          <option value="<?php echo $licenseType->name ?>"><?php echo $licenseType->name ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="date_of_birth" class="col-xs-3 col-form-label">From Date<i class="text-danger">*</i></label>
                                  <div class="col-xs-9">
                                      <input  name="licFrom" class="form-control" type="date" placeholder="License From Date" id="licFrom"   autocomplete="off" required >
                                  </div>

                              </div>
                              <input hidden name="status" value="1">
                              <div class="form-group row">
                                  <label for="date_of_birth" class="col-xs-3 col-form-label">Due Date<i class="text-danger">*</i></label>
                                  <div class="col-xs-9">
                                      <input type="date" name="licDue" id="licDue" class="form-control" placeholder="License Due Date" id="due_date" required   autocomplete="off">
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

        <div class="row">
            <div class="col-sm-12">
                <div  class="panel panel-default thumbnail">
                    <?php
                     if($this->permission->method('add_main_department','create')->access()){
                    ?>
                    <div class="panel-heading no-print">
                        <div class="btn-group">
                            <a class="btn btn-success" data-toggle="modal" data-target="#addModal" > <i class="fa fa-plus"></i> Add License</a>
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
                                                    <th>License Type</th>
                                                    <th>From Date</th>
                                                    <th>Due Date</th>
                                                    <?php
                                                    if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                                    ?>
                                                    <th><?php echo display('action') ?></th>
                                                    <?php } ?>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($licenses)) { ?>
                                                    <?php $sl = 1; ?>
                                                    <?php if (1>0) { ?>
                                                      <?php foreach ($licenses as $license): ?>
                                                        <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                            <td><?php echo $sl ?></td>
                                                            <td><?php echo $license->licType ?></td>
                                                            <td><?php echo $license->licFrom ?></td>
                                                            <td><?php echo $license->licDue ?></td>
                                                            <?php
                                                             if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                                             ?>
                                                            <td class="center">
                                                            <?php
                                                             if($this->permission->method('main_department','update')->access()){
                                                             ?>
                                                                <a href="<?php echo base_url("license/info/$license->id/$employee->user_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="<?= display('view')?>"></i></a>
                                                                <a href="<?php echo base_url("license/read/$license->id") ?>" class="btn btn-xs btn-success" data-toggle="tooltip" title = "Edit"><i class="fa fa-edit"></i></a>
                                                                <a style="display: none" href="<?php echo base_url("license/renew/$patient->id") ?>" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Renew"></i></a>
                                                            <?php } ?>

                                                             <?php
                                                             if($this->session->userdata('isAdmin')){
                                                             ?>
                                                                <a href="<?php echo base_url("license/delete/$license->id/$employee->user_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
                                                             <?php } ?>

                                                            </td>
                                                            <?php } ?>

                                                        </tr>
                                                      <?php $sl++; ?>
                                                      <?php endforeach; ?>


                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>  <!-- /.table-responsive -->
                                    </div>
                                </div>
                            </div>

                            <!-- END INFORMATION -->

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
        <!-- Add Branches Modal-->
        <form action="<?php echo base_url('/main_department/create') ?>" method="post">
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
                                        <input checked type="radio" name="status" value="Active">Active
                                        </label>

                                        <label class="radio-inline">
                                        <input type="radio" name="status" value="Inactive">Inactive
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
        <!-- End Branch Modal-->

        <!-- Add license Modal-->
        <form action="<?php echo base_url('license_type/create') ?>" method="post">
          <div style="margin-left: -10px;" class="modal fade" id="licenseTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
              <div class="modal-header">
                <div class="row">
                  <a href="<?php echo base_url('license_type') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">License Type List</a>
                  <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New License Type</h5>
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
                                <label for="name" class="col-xs-3 col-form-label">License Name<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name"  type="text" class="form-control" id="name" placeholder="License Name" >
                                </div>
                            </div>

                            <?php
                            // Get current url
                            $this->load->helper('url');
                            $source = current_url();
                             ?>
                            <input type="hidden" name="source" value="<?php echo $source ?>">


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

        <!-- Add discipline Modal-->
        <form action="<?php echo base_url('discipline/create') ?>" method="post">
          <div class="modal fade" id="disciplineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
              <div class="modal-header">
                <div class="row">
                  <a href="<?php echo base_url('discipline') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">Discpline List</a>
                  <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New Discpline</h5>
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
        <!-- End Discipline Modal-->
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
        el.value = state;

    //    stateSel.add(el);
    		 }
    }


    //Add new license
    $("#licenseSelect").prop("selectedIndex", 1);
    var licenseSelect = document.getElementById('licenseSelect');
    licenseSelect.onchange = function(){
      if (licenseSelect.options[ licenseSelect.selectedIndex ].value == 'addLicenseType' ) {
        //$('#addModal').modal('hide');
          $('#licenseTypeModal').modal('show');
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

    const inputElement4 = document.getElementById('phoneNumber4');
    inputElement4.addEventListener('keydown',enforceFormat);
    inputElement4.addEventListener('keyup',formatToPhone);
    </script>

</div>
