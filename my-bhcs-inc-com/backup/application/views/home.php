
<div class="row">

  <style media="screen">


  .dataTables_wrapper  .dataTables_filter {

    display: none;
  }

  .dataTables_wrapper .dt-buttons {
    display: none;
  }

    .custom-link {
      color: white;
    }

    .custom-link-two {
      color: white;
    }

    .custom-link:hover {
      color: #37A000;
    }
    .custom-link-two:hover {
      color: #3498DB;
    }
  </style>
    <!-- welcome message -->
    <?php if ($password_status !=0): ?>
      <?php if ($this->session->flashdata('welcome') != null) {  ?>
      <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?php echo $this->session->flashdata('welcome'); ?>
      </div>
      <?php } ?>
    <?php endif; ?>


    <!-- password set message -->
    <?php if ($this->session->flashdata('message') != null) {  ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $this->session->flashdata('message'); ?>
    </div>
    <?php } ?>

    <!-- welcome message -->

    <?php
     if($password_status != 0){
     ?>
     <div style = "" class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
         <div class="info-box bg-green">
             <span class="info-box-icon"><i class="fa fa-user-md"></i></span>

             <div class="info-box-content">
               <span class="info-box-text"> <a class="custom-link-two" href="<?php echo base_url("human_resources/employee") ?>" >EMPLOYEES</a> </span>
               <span class="info-box-number"><?php echo number_format((!empty($notify[2]->total_doctor) ? $notify[2]->total_doctor : null)) ?></span>

               <div class="progress">
                 <div class="progress-bar" style="width: 50%"></div>
               </div>
               <span class="progress-description">
                    <?= date('j F, Y');?>
                   </span>
             </div>
             <!-- /.info-box-content -->
           </div>
     </div>
     <?php }?>

    <?php
    if($password_status != 0){
    ?>
    <div style="margin-right: 30px" class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
        <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-wheelchair"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"> <a class="custom-link" href="<?php echo base_url("patient") ?>">PATIENTS</a> </span>
              <span class="info-box-number"><?php echo number_format((!empty($notify[1]->total_patient) ? $notify[1]->total_patient : null)) ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
              <span class="progress-description">
                    <?= date('j F, Y');?>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
    <?php }?>


    <!-- Start employees due  -->
    <?php
    if(1>0){
    ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
        <div style="border: solid 2px #37A000; border-radius: 5px; padding: 6px" class="info-box">
          <!-- INFORMATION -->
          <div role="tabpanel" class="tab-pane active" id="home">
              <div class="row">
                  <div class="col-md-12">
                      <table width="100%" class="datatable table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>ID No.</th>
                                  <th>Employees whose licenses are due</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php if (!empty($employeesDue)) { ?>
                                  <?php $sl = 1; ?>
                                  <?php foreach ($employeesDue as $key => $employeeDue) { ?>
                                      <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                          <td><?php echo $sl; ?></td>
                                          <td><?php echo $employeeDue->firstname." ".$employeeDue->lastname; ?></td>

                                      </tr>
                                      <?php $sl++; ?>
                                  <?php } ?>
                              <?php } ?>
                          </tbody>
                      </table>  <!-- /.table-responsive -->
                  </div>
              </div>
          </div>
            <!-- /.info-box-content -->
          </div>
    </div>
   <?php }?>

   <!-- Start employees due  -->
   <?php
   if(1>0){
   ?>
   <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
       <div style="border: solid 2px #37A000; border-radius: 5px; padding: 6px" class="info-box">
         <!-- INFORMATION -->
         <div role="tabpanel" class="tab-pane active" id="home">
             <div class="row">
                 <div class="col-md-12">
                     <table width="100%" class="datatable table table-striped table-bordered table-hover">
                         <thead>
                             <tr>
                                 <th>ID No.</th>
                                 <th>Patients whose episodes are due</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php if (!empty($patientsDue)) { ?>
                                 <?php $sl = 1; ?>
                                 <?php foreach ($patientsDue as $key => $patientDue) { ?>
                                     <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                         <td><?php echo $sl; ?></td>
                                         <td><?php echo $patientDue->firstname." ".$patientDue->lastname; ?></td>

                                     </tr>
                                     <?php $sl++; ?>
                                 <?php } ?>
                             <?php } ?>
                         </tbody>
                     </table>  <!-- /.table-responsive -->
                 </div>
             </div>
         </div>
           <!-- /.info-box-content -->
         </div>
   </div>
  <?php }?>

</div>

<div class="row">
    <!-- Total Product Sales area -->
    <?php
    if($this->permission->method('graph','read')->access()){
    ?>
    <div style="display: none" class="col-lg-8">
         <div style="display: none" class="panel panel-default" id="js-timer">
            <div class="panel-body">
                <div class="widget-title">
                    <h3><?= ($this->session->userdata('title')!=null?$this->session->userdata('title'):null) ?> <?= display('total_progress')?></h3>
                    <span><?= display('last_year_status') ?></span>

                </div>
                <canvas id="lineChart" height="170"></canvas>

            </div> <!-- /.panel-body -->
         </div>
    </div>
    <?php } ?>

    <!-- Message area -->
     <?php
       if(1<0){
        ?>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><?= display('enquiry') ?></h3>
                <span><?= display('latest_enquiry') ?></span>
            </div>
            <div class="panel-body">
                <div class="message_inner">
                    <?php if (!empty($enquires)) {  ?>
                        <?php foreach ($enquires as $enquiry) {  ?>
                        <a href="<?php echo base_url("enquiry/view/$enquiry->enquiry_id") ?>">
                            <div class="inbox-item">
                                <strong class="inbox-item-author"><?php echo $enquiry->name; ?></strong>
                                <span class="inbox-item-date"></span>
                                <p class="inbox-item-text"><?php echo character_limiter(strip_tags($enquiry->enquiry),70); ?></p>
                            </div>
                        </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- /.row -->
</div> <!-- /.row -->

<div class="row">
    <!-- Total Product Sales area -->
    <?php
    if($this->permission->method('patient_list','read')->access() && $this->permission->method('appointment_list','read')->access()){
    ?>
    <div class="col-lg-8">

    </div>
    <?php } ?>

    <!-- Message area -->
     <?php
       if(1<0){
        ?>
       <div class="col-lg-4">
           <div class="panel panel-default">
                <div class="panel-body">
                    <div class="widget-title">
                      <h3><?= display('quick_links')?></h3>
                    </div>
                    <div class="fancy-collapse-panel">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#billing" aria-expanded="true" aria-controls="billing"><?php echo display('billing') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="billing" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                       <ul class="quick-menu">
                                            <?php
                                            if($this->permission->method('service_list','read')->access() || $this->permission->method('service_list','update')->access() || $this->permission->method('service_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-green btn-block" href="<?php echo base_url("billing/service/index") ?>"><?php echo display('service_list') ?></a></li>
                                            <?php } ?>

                                            <?php
                                            if($this->permission->method('package_list','read')->access() || $this->permission->method('package_list','update')->access() || $this->permission->method('package_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-olive btn-block" href="<?php echo base_url("billing/package/index") ?>"><?php echo display('package_list') ?></a></li>
                                            <?php } ?>


                                            <?php
                                            if($this->permission->method('admission_list','read')->access() || $this->permission->method('admission_list','update')->access() || $this->permission->method('admission_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-blue btn-block" href="<?php echo base_url("billing/admission") ?>"><?php echo display('admission_list') ?></a></li>
                                            <?php } ?>

                                           <?php
                                            if($this->permission->method('bill_list','read')->access() || $this->permission->method('bill_list','update')->access() || $this->permission->method('bill_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-primary btn-block" href="<?php echo base_url("billing/bill") ?>"><?php echo display('bill_list') ?></a></li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#hactivity" aria-expanded="false" aria-controls="hactivity"><?php echo display('hospital_activities') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="hactivity" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <ul class="quick-menu">
                                            <?php
                                            if($this->permission->method('birth_report','read')->access() || $this->permission->method('birth_report','update')->access() || $this->permission->method('birth_report','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-green btn-block" href="<?php echo base_url('hospital_activities/birth/index') ?>"><?php echo display('birth_report') ?></a></li>
                                            <?php } ?>
                                            <?php
                                            if($this->permission->method('death_report','read')->access() || $this->permission->method('death_report','update')->access() || $this->permission->method('death_report','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-red btn-block" href="<?php echo base_url('hospital_activities/death/index') ?>"><?php echo display('death_report') ?></a></li>
                                            <?php } ?>

                                            <?php
                                            if($this->permission->method('operation_report','read')->access() || $this->permission->method('operation_report','update')->access() || $this->permission->method('operation_report','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-yellow btn-block" href="<?php echo base_url('hospital_activities/operation/index') ?>"><?php echo display('operation_report') ?></a></li>
                                             <?php } ?>

                                             <?php
                                              if($this->permission->method('investigation_report','read')->access() || $this->permission->method('investigation_report','update')->access() || $this->permission->method('investigation_report','delete')->access()){
                                              ?>
                                            <li><a class="btn bg-primary btn-block" href="<?php echo base_url('hospital_activities/investigation/index') ?>"><?php echo display('investigation_report') ?></a></li>
                                             <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-success">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#account" aria-expanded="false" aria-controls="account"><?php echo display('account_manager') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="account" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul class="quick-menu">
                                            <?php
                                            if($this->permission->method('account_list','read')->access()){
                                            ?>
                                            <li><a class="btn bg-primary btn-block" href="<?php echo base_url("accounts/accounts/show_tree") ?>"><?php echo display('chart_of_account') ?></a></li>
                                            <?php } ?>

                                            <?php
                                            if($this->permission->method('general_ledger','create')->access()){
                                            ?>
                                             <li><a class="btn bg-olive btn-block" href="<?php echo base_url("accounts/accounts/general_ledger") ?>"><?php echo display('general_ledger') ?></a></li>
                                            <?php } ?>

                                             <?php
                                            if($this->permission->method('account_list','read')->access()){
                                            ?>
                                            <li><a class="btn bg-blue btn-block" href="<?php echo base_url("accounts/accounts/trial_balance") ?>"><?php echo display('trial_balance') ?></a></li>
                                            <?php } ?>

                                            <?php
                                            if($this->permission->method('profit_loss','read')->access()){
                                            ?>
                                            <li><a class="btn bg-green btn-block" href="<?php echo base_url("accounts/accounts/profit_loss_report") ?>"><?php echo display('profit_loss') ?></a></li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-warning">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#insurance" aria-expanded="false" aria-controls="insurance"><?php echo display('insurance') ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="insurance" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <ul class="quick-menu">
                                            <?php
                                            if($this->permission->method('add_insurance','create')->access()){
                                            ?>
                                            <li><a class="btn bg-green btn-block" href="<?php echo base_url("insurance/insurance/form") ?>"><?php echo display('add_insurance') ?></a></li>
                                            <?php } ?>


                                            <?php
                                            if($this->permission->method('insurance_list','read')->access() || $this->permission->method('insurance_list','update')->access() || $this->permission->method('insurance_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-blue btn-block" href="<?php echo base_url("insurance/insurance") ?>"><?php echo display('insurance_list') ?></a></li>
                                            <?php } ?>



                                            <?php
                                            if($this->permission->method('add_limit_approval','create')->access()){
                                            ?>
                                            <li><a class="btn bg-olive btn-block" href="<?php echo base_url("insurance/limit_approval/form") ?>"><?php echo display('add_limit_approval') ?></a></li>
                                            <?php } ?>



                                            <?php
                                            if($this->permission->method('limit_approval_list','read')->access() || $this->permission->method('limit_approval_list','update')->access() || $this->permission->method('limit_approval_list','delete')->access()){
                                            ?>
                                            <li><a class="btn bg-yellow btn-block" href="<?php echo base_url("insurance/limit_approval") ?>"><?php echo display('limit_approval_list') ?></a></li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
    <?php } ?>
    <!-- /.row -->

<?php
if($this->permission->method('graph','read')->access()){
?>
<script type="text/javascript">
$(window).on('load', function(){
    //line chart
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php echo $allmonth;?>],
            datasets: [
                {
                    label: "<?= display('patient');?>",
                    borderColor: "#3498DB",
                    borderWidth: "1",
                    //backgroundColor: "rgba(0,0,0,.07)",
                    pointHighlightStroke: "rgba(52,152,219)",
                    data: [<?php echo $allPatient;?>]
                },
                {
                    label: "<?= display('appointment');?>",
                    borderColor: "#37a000",
                    borderWidth: "1",
                    //backgroundColor: "#73BC4D",
                    pointHighlightStroke: "rgba(55,160,0)",
                    data: [<?php echo $allAppoint;?>]
                },
                {
                    label: "<?= display('prescription');?>",
                    borderColor: "#FFB61E",
                    borderWidth: "1",
                    //backgroundColor: "#1ABC9C",
                    pointHighlightStroke: "rgba(130, 224, 170,1)",
                    data: [<?php echo $allPrescrip;?>]
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }

        }
    });

});

</script>
 <?php } ?>
