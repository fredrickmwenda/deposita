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
                              <label for="date_of_birth" class="col-xs-3 col-form-label">Creation Date <i class="text-danger">*</i></label>
                              <div class="col-xs-9">
                                  <input disabled name="create_date" class="form-control" type="date" placeholder="1-1-2010" id="date_of_birth"  value="<?php echo $patient->create_date ?>" autocomplete="off">
                              </div>
                            </div>
                            <div class="form-group row">
                                <label for="branch" class="col-xs-3 col-form-label"> Choose Branch<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <select id="branchSelect"  name='branch' class="form-control" id="user_role" >

                                    <?php foreach ($branches as $mBranch): ?>
                                      <option value="<?php echo $mBranch->id; ?>" <?php if ($patient->branch_id == $mBranch->id){
                                        echo "selected";
                                      }?>><?php echo $mBranch->name ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstname" class="col-xs-3 col-form-label"><?php echo display('first_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input  name="firstname" type="text" class="form-control" id="firstname" placeholder="<?php echo display('first_name') ?>" value="<?php echo $patient->firstname ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="middlename" class="col-xs-3 col-form-label">Middle Name <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="middlename" type="text" class="form-control" id="lastname" placeholder="Middle Name" value="<?php echo $patient->middlename ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label"><?php echo display('last_name') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input  name="lastname" type="text" class="form-control" id="lastname" placeholder="<?php echo display('last_name') ?>" value="<?php echo $patient->lastname ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">Street Address<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input  name="address" type="text" class="form-control" id="address" placeholder="Street Address" value="<?php echo $patient->address ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">City/ State/ Zip Code<i class="text-danger">*</i></label>

                                <div class="col-xs-3">
                                    <input name="city" type="text" class="form-control" id="city" placeholder="City" value="<?php echo $patient->city ?>" autocomplete="off">
                                </div>
                                <div class="col-xs-3">
                                  <?php
                                  $states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];
                                   ?>
                                      <select id = "stateSell"  class="form-control" name="state">
                                        <option>Choose State</option>
                                        <?php foreach ($states as $state): ?>
                                          <option value="<?php echo $state?>" <?php if ($patient->state == $state): ?>
                                            <?php echo 'selected' ?>
                                          <?php endif; ?> ><?php echo $state ?></option>
                                        <?php endforeach; ?>
                                      </select>

                                </div>

                                <div class="col-xs-3">
                                  <input class="form-control" id="zipcode" name="zipcode" type="text" oninput="this.value=this.value.slice(0,this.maxLength)" pattern="[0-9]*" maxlength="5" placeholder="Zip Code" value="<?php echo $patient->zipcode ?>">
                                </div>
                              </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label"><?php echo display('phone') ?><i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $patient->phone ?>" name="phone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Alternate Phone</label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $patient->altphone ?>" name="altphone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-xs-3 col-form-label">Next of Kin<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input  name="next_of_kin" type="text" class="form-control" id="lastname" placeholder="Next of Kin" value="<?php echo $patient->next_of_kin ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-xs-3 col-form-label">Next of Kin Phone<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input value="<?php echo $patient->kin_phone ?>" name="kin_phone" class="form-control" type="tel" placeholder="(123) 456 - 7891" maxlength="16" id="phoneNumber3">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-xs-3 col-form-label">Category</label>
                                <div class="col-xs-4">
                                  <select id = "categorySelect" class="form-control" name="category_id">
                                    <option disabled value="disabled">Choose Category</option>

                                     <option <?php if ($patient->category_id == 'Skilled'){
                                       echo "selected";
                                     } ?>
                                         value="Skilled">Skilled</option>

                                         <option <?php if ($patient->category_id == 'Un-Skilled'){
                                           echo "selected";
                                         } ?>
                                             value="Un-Skilled">Un-Skilled</option>
                                  </select>
                                </div>

                                <label for="date_of_birth" class="col-xs-2 col-form-label">Start of Care<i class="text-danger">*</i></label>
                                <div class="col-xs-3">
                                    <input  name="start_of_care" class="form-control" type="date" placeholder="Start of Care Date" id="date_of_birth"  value="<?php echo $patient->start_of_care ?>" autocomplete="off">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-xs-3">Gender<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <div class="form-check">
                                      <label class="radio-inline">
                                      <input <?php if ($patient->sex == 'Male'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="sex" value="Male"><?php echo display('male')?>
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($patient->sex == 'Female'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="sex" value="Female"><?php echo display('female')?>
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($patient->sex == 'Other'): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="sex" value="Other"><?php echo display('others')?>
                                      </label>

                                  </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="date_of_birth" class="col-xs-3 col-form-label"><?php echo display('date_of_birth') ?> <i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="date_of_birth" class="dropdown-month-years form-control" type="text" placeholder="<?php echo display('date_of_birth') ?>" id="date_of_birth"  value="<?php echo $patient->date_of_birth ?>" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3">Status<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                  <div class="form-check">
                                      <label class="radio-inline">
                                      <input <?php if ($patient->status == 1): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> checked type="radio" name="status" value="1">Active
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($patient->status == 0): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="status" value="0">Inactive
                                      </label>

                                      <label class="radio-inline">
                                      <input <?php if ($patient->status == 2): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="status" value="2">DC
                                      </label>
                                      <label class="radio-inline">
                                      <input <?php if ($patient->status == 3): ?>
                                        <?php echo 'checked'; ?>
                                      <?php endif; ?> type="radio" name="status" value="3">Expired
                                      </label>

                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-xs-3 col-form-label">Comments<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input style="height: 100px" name="comments" class="form-control"  value="<?php if (empty($patient->comments)) {
                                      echo "No comments";
                                    } else {
                                      echo $patient->comments;
                                    }?>" maxlength="140" rows="7" id="address"></input>
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

<!-- Certificate Modal-->
<form action="<?php echo base_url('episode/create') ?>" method="post">
  <div class="modal fade" id="certModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add New Episode</h5>
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

                        <?php echo form_hidden('id',$department->id) ?>
                        <div class="form-group row">
                            <label for="certFrom" class="col-xs-3 col-form-label">Episode From Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="episodeFrom" id="certFrom" class="dropdown-month-years form-control" type="text" placeholder="Choose From Date"   autocomplete="off">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="certTo" class="col-xs-3 col-form-label">Episode To Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                  <input disabled id="certTo" name="episodeTo" class="dropdown-month-years form-control" type="text" placeholder="To Date" autocomplete="off">
                            </div>

                        </div>

                        <!-- SERVICE 1 -->

                        <div class="form-group row">
                            <label for="name" class="col-xs-3 col-form-label">Choose Service</label>
                            <div class="col-xs-3">
                                <select id="serviceSelect" class="form-control" class="service" name="serviceId1" required>
                                  <option value="addService">Add New Service</option>

                                  <?php foreach ($services as $service): ?>
                                    <option value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
                                  <?php endforeach; ?>
                                </select>

                                <input type="hidden" name="patientId" value="<?php echo $patient->id ?>">
                            </div>

                            <div class="col-xs-6">
                              <select id="serviceSelect" class="form-control" class="service" name="providerId1"  required>
                                <option disabled value="w">Search employees</option>

                                <?php foreach ($employees as $employee): ?>
                                  <option value="<?php echo $employee->user_id ?>"><?php echo $employee->firstname." ".$employee->lastname ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>

                        <!-- SERVICE 2 -->
                        <div class="form-group row">
                            <label for="name" class="col-xs-3 col-form-label"></label>
                            <div class="col-xs-3">
                                <select id="serviceSelect" class="form-control" class="service" name="serviceId2">

                                  <?php foreach ($services as $service): ?>
                                    <option value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-xs-6">

                              <select id="serviceSelect" class="form-control" class="service" name="providerId2">
                                <option value="w">Search employees</option>

                                <?php foreach ($employees as $employee): ?>
                                  <option value="<?php echo $employee->user_id ?>"><?php echo $employee->firstname." ".$employee->lastname ?></option>
                                <?php endforeach; ?>
                              </select>
                              </div>
                        </div>

                        <!-- SERVICE 3 -->

                        <div class="form-group row">
                            <label for="name" class="col-xs-3 col-form-label"></label>
                            <div class="col-xs-3">
                                <select id="serviceSelect" class="form-control" class="service" name="serviceId3">


                                  <?php foreach ($services as $service): ?>
                                    <option value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-xs-6">

                              <select id="serviceSelect" class="form-control" class="service" name="providerId3">
                                <option value="w">Search employees</option>

                                <?php foreach ($employees as $employee): ?>
                                  <option value="<?php echo $employee->user_id ?>"><?php echo $employee->firstname." ".$employee->lastname ?></option>
                                <?php endforeach; ?>
                              </select>
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
<!-- End Episode Modal-->

<div class="row" style="margin-left: .1%; margin-right: .1%" >
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <?php
             if($this->permission->method('add_main_department','create')->access()){
            ?>
            <div class="panel-heading no-print">
                <div class="btn-group">
                    <a class="btn btn-success" data-toggle="modal" data-target="#certModal"  > <i class="fa fa-plus"></i> Add Episode</a>
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
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Services</th>

                                            <?php
                                            if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                            ?>
                                            <th><?php echo display('action') ?></th>
                                            <?php } ?>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($episodes)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php if (1>0) { ?>

                                              <?php foreach ($episodes as $episode) { ?>
                                                  <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                      <td><?php echo $sl; ?></td>
                                                      <td><?php echo $episode->episodeFrom; ?></td>
                                                      <td><?php echo $episode->episodeTo?></td>
                                                      <td> <a  href="<?php echo base_url("episode/services/$episode->id/$patient->id") ?>" class="btn btn-primary">View Services</a> </td>
                                                      <?php
                                                       if($this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
                                                       ?>
                                                      <td class="center">
                                                      <?php
                                                       if($this->permission->method('main_department','update')->access()){
                                                       ?>
                                                          <a href="<?php echo base_url("episode/info/$episode->id") ?>" class="btn btn-xs  btn-success"><i class="fa fa-eye"></i></a>
                                                          <a href="<?php echo base_url("episode/read/$episode->id") ?>" class="btn btn-xs  btn-success"><i class="fa fa-edit"></i></a>
                                                          <a href="<?php echo base_url("episode/renew/$episode->id") ?>" class="btn btn-xs  btn-success"><i class="fa fa-refresh"></i></a>
                                                        <?php } ?>


                                                      <?php
                                                       if($this->session->userdata('isAdmin')){
                                                       ?>
                                                        <a href="<?php echo base_url("episode/delete/$episode->id/$patient->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
                                                      <?php } ?>



                                                      </td>
                                                      <?php } ?>

                                                  </tr>
                                                  <?php $sl++; ?>
                                              <?php } ?>


                                        <?php } ?>
                                      <?php } ?>
                                    </tbody>
                                </table>  <!-- /.table-responsive -->
                            </div>
                        </div>
                    </div>

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

</div>


        <!-- Add Service Modal-->
        <form action="<?php echo base_url('service/create') ?>" method="post">
          <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
              <div class="modal-header">
                <div class="row">
                  <a href="<?php echo base_url('service') ?>" style= "margin-left: 30px; margin-top: 15px" class="ui positive button" name="button">Services List</a>
                  <h5 style="float: right; margin-right: 40%"  id="exampleModalLabel">Add New Service</h5>
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
                                <label for="name" class="col-xs-3 col-form-label">Service Name<i class="text-danger">*</i></label>
                                <div class="col-xs-9">
                                    <input name="name"  type="text" class="form-control" id="name" placeholder="Service Name" >
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
        <!-- End Service Modal-->

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

// var states = [ 'AL', 'AK', 'AS', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FM', 'FL', 'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MH', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'MP', 'OH', 'OK', 'OR', 'PW', 'PA', 'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'VA', 'WA', 'WV', 'WI', 'WY' ];


window.onload = function () {

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
var myButton = document.getElementById('assignService');


//Search employees
function load_data(query, source)
{
 $.ajax({
  url:"<?php echo base_url(); ?>human_resources/employee/search_employee_req",
  method:"POST",
  data:{query:query,
        source: source
},
  success:function(data){
   $('#result').html(data);
  }
 })
}

$('#providerSearch').keyup(function(){
 var search = $(this).val();
 if(search != '')
 {
  load_data(search, 1);
} else {
  load_data('');
}
});

$('#providerSearch2').keyup(function(){
 var search = $(this).val();
 if(search != '')
 {
  load_data(search, 2);
} else {
  load_data('');
}
});


$('#providerSearch3').keyup(function(){
 var search = $(this).val();
 if(search != '')
 {
  load_data(search, 3);
} else {
  load_data('');
}
});

//Display selected user
function selectProvider(id){
  var selectedListItem = document.getElementById(id);
  var providerSearch = document.getElementById('providerSearch');
  var providerIdInput = document.getElementById('providerIdInput');
  var selectedListItemContent = selectedListItem.innerHTML;
  providerSearch.value = selectedListItemContent;
  providerIdInput.value = id;
  load_data('')
  //providerSearch.value = id;
}

function selectProvider2(id){
  var selectedListItem = document.getElementById(id);
  var providerSearch2 = document.getElementById('providerSearch2');
  var providerIdInput2 = document.getElementById('providerIdInput2');
  var selectedListItemContent = selectedListItem.innerHTML;
  providerSearch2.value = selectedListItemContent;
  providerIdInput2.value = id;
  load_data('')
  //providerSearch.value = id;
}

function selectProvider3(id){
  var selectedListItem = document.getElementById(id);
  var providerSearch3 = document.getElementById('providerSearch3');
  var providerIdInput3 = document.getElementById('providerIdInput3');
  var selectedListItemContent = selectedListItem.innerHTML;
  providerSearch3.value = selectedListItemContent;
  providerIdInput3.value = id;
  load_data('')
  //providerSearch.value = id;
}


//Show service modal
$("#serviceSelect").prop("selectedIndex", 1);
var serviceSelect = document.getElementById('serviceSelect');
serviceSelect.onchange = function(){
  if (serviceSelect.options[ serviceSelect.selectedIndex ].value == 'addService' ) {

      $('#certModal').modal('hide');
      $('#serviceModal').modal('show');
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

var certFrom = document.getElementById('certFrom');
var certTo = document.getElementById('certTo');

certFrom.onchange = function () {
  var pickedValue = certFrom.value;
  var result = new Date(pickedValue);
  result.setDate(result.getDate() + 59);
  var dd = String(result.getDate()).padStart(2, '0');
var mm = String(result.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = result.getFullYear();

var date = mm + '-' + dd + '-' + yyyy;
certTo.value = date;
}

</script>
