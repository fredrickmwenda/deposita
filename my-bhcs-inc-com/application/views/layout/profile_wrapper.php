<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//get site_align setting
$settings = $this->db->select("site_align")
    ->get('setting')
    ->row();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?= display('dashboard') ?> - <?php echo (!empty($title)?$title:null) ?></title>

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?= base_url($this->session->userdata('favicon')) ?>">

        <!-- jquery ui css -->
        <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        <!-- Font Awesome 4.7.0 -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- semantic css -->
        <link href="<?php echo base_url(); ?>assets/css/semantic.min.css" rel="stylesheet" type="text/css"/>
        <!-- sliderAccess css -->
        <link href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css"/>
        <!-- slider  -->
        <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- DataTables CSS -->
        <link href="<?= base_url('assets/datatables/css/dataTables.min.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- pe-icon-7-stroke -->
        <link href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- themify icon css -->
        <link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Pace css -->
        <link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- jstree view -->
        <link rel="stylesheet" href="<?php echo base_url()?>assets/vakata-jstree/dist/themes/default/style.min.css" />
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>
        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js') ?>" type="text/javascript"></script>
    </head>
    <body class="hold-transition sidebar-mini fixed">
        <div class="se-pre-con"></div>

        <!-- Site wrapper -->
        <div style="" class="wrapper">
            <header class="main-header">
              <?php $logo = $this->session->userdata('logo'); ?>

              <a href="<?php echo base_url('dashboard/home') ?>" class="logo"> <!-- Logo -->
                  <span class="logo-mini">
                      <img class="img-fluid"> src="<?php echo (!empty($logo)?base_url($logo):base_url("assets/images/logo.png")) ?>" alt="">
                  </span>
                  <span class="logo-lg">
                      <img class="img-fluid" src="<?php echo (!empty($logo)?base_url($logo):base_url("assets/images/logo.png")) ?>" alt="">
                  </span>
              </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- settings -->
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                                <ul class="dropdown-menu">
                                    <?php
                                     if($this->permission->method('profile','read')->access() || $this->permission->method('profile','update')->access()){
                                    ?>
                                    <li><a href="<?php echo base_url('dashboard/profile'); ?>"><i class="pe-7s-users"></i> <?php echo display('profile') ?></a></li>
                                    <?php
                                     }
                                    ?>

                                    <?php
                                     if($this->permission->method('edit_profile','update')->access()){
                                    ?>
                                    <li><a href="<?php echo base_url('dashboard/form'); ?>"><i class="pe-7s-users"></i> <?php echo display('edit_profile') ?></a></li>
                                    <?php } ?>
                                    <?php
                                     if($this->permission->method('edit_profile','update')->access()){
                                    ?>
                                    <li><a href="<?php echo base_url('setting/'); ?>"><i class="pe-7s-settings"></i>App Settings</a></li>
                                    <?php } ?>

                                    <li><a href="<?php echo base_url('logout') ?>"><i class="pe-7s-key"></i> <?php echo display('logout') ?></a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel text-center">
                        <?php $picture = $this->session->userdata('picture'); ?>
                        <div class="image">
                            <img src="<?php echo (!empty($picture)?base_url($picture):base_url("assets_web/img/placeholder/avatarr.png")) ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p><?php echo $this->session->userdata('fullname') ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i>
                            <?php
                               echo $this->session->userdata('rolename');
                            ?>
                        </a>
                        </div>
                    </div>

                    <!-- sidebar menu -->
    <ul class="sidebar-menu">

    <li class="<?php echo (($this->uri->segment(1) == 'dashboard') ? "active" : null) ?>">
        <a href="<?php echo base_url('dashboard/home') ?>"><i class="fa fa ti-home"></i> <?php echo display('dashboard') ?></a>
    </li>

    <?php
    if($this->permission->module('add_employee')->access() || $this->permission->module('accountant_list')->access() || $this->permission->module('laboratorist_list')->access() || $this->permission->module('nurse_list')->access() || $this->permission->module('pharmacist_list')->access() || $this->permission->module('receptionist_list')->access() || $this->permission->module('representative_list')->access() || $this->permission->module('case_manager_list')->access()){
    ?>

    <li class="treeview  <?php echo ((($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "form") || ($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "")) ? "active" : null) ?>">
        <a href="#">
            <i class="fa fa-users"></i> <span>Employees</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <?php
            if($this->permission->method('add_employee','create')->access()){
            ?>
            <li class="<?php echo (($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "form")? "active" : null) ?>"><a href="<?php echo base_url("human_resources/employee/form") ?>"><?php echo display('add_employee') ?></a></li>
            <?php } ?>

            <?php
            if($this->permission->method('employee_list','read')->access() || $this->permission->method('employee_list','update')->access() || $this->permission->method('employee_list','delete')->access()){
            ?>
            <li class="<?php echo (($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "")? "active" : null) ?>"><a href="<?php echo base_url("human_resources/employee") ?>"><?php echo display('employee_list') ?></a></li>
            <?php } ?>

        </ul>
    </li>
    <?php } ?>

    <!-- patient info -->
   <?php
   if($this->permission->module('add_patient')->access() || $this->permission->module('patient_list')->access() || $this->permission->module('add_document')->access() || $this->permission->module('document_list')->access() || $this->permission->module('psms_gateway')->access() || $this->permission->module('pnew_message')->access() || $this->permission->module('pinbox')->access() || $this->permission->module('psent')->access()){
   ?>
   <li class="treeview <?php echo (($this->uri->segment(1) == "patient" || $this->uri->segment(1) == "patients") ? "active" : null) ?>">
   <a href="#">
       <i class="fa fa-wheelchair"></i> <span>Patients</span>
       <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
   </a>
   <ul class="treeview-menu">

       <?php
       if($this->permission->method('add_patient','create')->access() ){
       ?>
       <li class="<?php echo (($this->uri->segment(1) == "patient" && $this->uri->segment(2) == "create")? "active" : null) ?>"><a href="<?php echo base_url("patient/create") ?>"><?php echo display('add_patient') ?></a></li>
      <?php } ?>


       <?php
       if($this->permission->method('patient_list','read')->access() || $this->permission->method('patient_list','update')->access() || $this->permission->method('patient_list','delete')->access()){
       ?>
       <li class="<?php echo (($this->uri->segment(1) == "patient" && $this->uri->segment(2) == "")? "active" : null) ?>"><a href="<?php echo base_url("patient") ?>"><?php echo display('patient_list') ?></a></li>
       <?php } ?>



       </ul>
   </li>
   <?php } ?>

    <?php
    if($this->permission->module('add_user')->access()){
    ?>

    <li class="treeview  <?php echo ((($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "form_user") || ($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "users")) ? "active" : null) ?>">
        <a href="#">
            <i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <?php
            if($this->permission->method('add_employee','create')->access()){
            ?>
            <li class="<?php echo (($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "form_user")? "active" : null) ?>"><a href="<?php echo base_url("human_resources/employee/form_user") ?>">Add User</a></li>
            <?php } ?>

            <?php
            if($this->permission->method('employee_list','read')->access() || $this->permission->method('employee_list','update')->access() || $this->permission->method('employee_list','delete')->access()){
            ?>
            <li class="<?php echo (($this->uri->segment(2) == "employee" && $this->uri->segment(3) == "users")? "active" : null) ?>"><a href="<?php echo base_url("human_resources/employee/users") ?>">Users List</a></li>
            <?php } ?>

        </ul>
    </li>
    <?php } ?>

    <?php
    if($this->permission->module('add_role')->access()){
    ?>
    <li class="treeview <?php echo (($this->uri->segment(1) == "permission_assign") ? "active" : null) ?>">
        <a href="#">
            <i class="ti-lock"></i> <span><?php echo display('permission') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">


          <?php
          if(1>0){
          ?>
            <li  style="display: none"class="<?php echo (($this->uri->segment(1) == "permission_assign" && $this->uri->segment(2) == "edit")? "active" : null) ?>"><a href="<?php echo base_url('permission_assign/rolecreate') ?>">Add Role</a></li>
          <?php } ?>
            <?php
            if($this->permission->method('role_permission','create')->access()){
            ?>
              <li class="<?php echo (($this->uri->segment(1) == "permission_assign" && $this->uri->segment(2) == "rolelist")? "active" : null) ?>"><a href="<?php echo base_url('permission_assign/rolelist') ?>">Roles List</a></li>
            <?php } ?>

        </ul>
    </li>
    <?php } ?>


    <?php
       if(1<0){
       ?>
       <li class="treeview <?php echo (($this->uri->segment(1) == "department") || ($this->uri->segment(1) == "main_department") && ($this->uri->segment(2) == "") ? "active" : null) ?>">
           <a href="#">
               <i class="fa fa-sitemap"></i> <span>Branches</span>
               <span class="pull-right-container">
                   <i class="fa fa-angle-left pull-right"></i>
               </span>
           </a>
           <ul class="treeview-menu">

                <?php
               if($this->permission->method('add_main_department','create')->access()){
               ?>
               <li class="<?php echo (($this->uri->segment(1) == "main_department")? "active" : null) ?>"><a href="<?php echo base_url("main_department/") ?>">View | Add Branches</a></li>
               <?php } ?>

           </ul>
       </li>
        <?php } ?>

        <?php
           if(1<0){
           ?>
           <li class="treeview <?php echo (($this->uri->segment(1) == "skills") || ($this->uri->segment(1) == "skills") ? "active" : null) ?>">
               <a href="#">
                   <i class="fa fa-sitemap"></i> <span>Skills</span>
                   <span class="pull-right-container">
                       <i class="fa fa-angle-left pull-right"></i>
                   </span>
               </a>
               <ul class="treeview-menu">


                  <?php
                 if($this->permission->method('add_main_department','create')->access()){
                 ?>
                 <li class="<?php echo (($this->uri->segment(1) == "skills")? "active" : null) ?>"><a href="<?php echo base_url("skills/create") ?>">Add Skill</a></li>
                 <?php } ?>

                 <?php
                if($this->permission->method('add_main_department','create')->access()){
                ?>
                <li class="<?php echo (($this->uri->segment(1) == "skills")? "active" : null) ?>"><a href="<?php echo base_url("skills/") ?>">Skills List</a></li>
                <?php } ?>

               </ul>
           </li>
            <?php } ?>


            <?php
               if(1<0){
               ?>
               <li class="treeview <?php echo (($this->uri->segment(1) == "service") || ($this->uri->segment(1) == "main_department") ? "active" : null) ?>">
                   <a href="#">
                       <i class="fa fa-sitemap"></i> <span>Services</span>
                       <span class="pull-right-container">
                           <i class="fa fa-angle-left pull-right"></i>
                       </span>
                   </a>
                   <ul class="treeview-menu">

                        <?php
                       if($this->permission->method('add_main_department','create')->access()){
                       ?>
                       <li class="<?php echo (($this->uri->segment(1) == "services")? "active" : null) ?>"><a href="<?php echo base_url("service/create") ?>">Add Service</a></li>
                       <?php } ?>

                       <?php
                      if($this->permission->method('add_main_department','create')->access()){
                      ?>
                      <li class="<?php echo (($this->uri->segment(1) == "services")? "active" : null) ?>"><a href="<?php echo base_url("service/") ?>">Services List</a></li>
                      <?php } ?>


                   </ul>
               </li>
                <?php } ?>
                    <?php
                       if(1<0){
                       ?>
                       <li class="treeview <?php echo (($this->uri->segment(1) == "setting" || $this->uri->segment(1) == "language" || $this->uri->segment(1) == "autoupdate") ? "active" : null) ?>">
                           <a href="#">
                               <i class="fa fa ti-settings"></i> <span><?php echo display('setting') ?></span>
                               <span class="pull-right-container">
                                   <i class="fa fa-angle-left pull-right"></i>
                               </span>
                           </a>
                           <ul class="treeview-menu">
                               <?php
                               if($this->permission->method('app_setting','read')->access() || $this->permission->method('app_setting','update')->access()){
                               ?>
                               <li class="<?php echo (($this->uri->segment(2) == "setting")? "active" : null) ?>"><a href="<?php echo base_url("setting") ?>"> <?php echo display('app_setting') ?> </a></li>
                               <?php } ?>

                           </ul>
                       </li>
                       <?php } ?>

    </ul>
 </div> <!-- /.sidebar -->
</aside>

            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <div class="p-l-30 p-r-30">

                        <img  class="img-fluid" src="<?php echo (!empty($logo)?base_url($logo):base_url("assets/images/logo.png")) ?>" alt="">
                        <div class="header-title">
                          <strong style="margin-left: -5%" ><?php echo $this->session->userdata('title') ?></strong>

                        </div>
                        <a style=" font-size: 110%; float: right; margin-top:-50px; margin-right: 10px;" href="<?php echo base_url('human_resources/employee') ?>" class="btn btn-success" name="button">Back</a>
                    </div>

                </section>
                <!-- Main content -->
                <div class="content">
                    <!-- demo mode enable alert -->
                    <div id="demoModeEnable"></div>
                    <!-- alert message -->
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                    <?php } ?>

                    <?php if ($this->session->flashdata('exception') != null) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('exception'); ?>
                    </div>
                    <?php } ?>

                    <?php if (validation_errors()) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php } ?>


                    <!-- content -->
                    <?php echo (!empty($content)?$content:null) ?>

                </div> <!-- /.content -->
            </div> <!-- /.content-wrapper -->

            <footer class="main-footer">
              Copyright © <?php echo date('Y') ?> <?php echo $this->session->userdata('title')  ?>. All rights reserved.
            </footer>
        </div> <!-- ./wrapper -->

        <!-- jquery-ui js -->
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- pace js -->
        <script src="<?php echo base_url('assets/js/pace.min.js') ?>" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>

        <!-- bootstrap timepicker -->
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script>
        <!-- select2 js -->
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/js/sparkline.min.js') ?>" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="<?php echo base_url('assets/js/waypoints.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.counterup.min.js') ?>" type="text/javascript"></script>

        <!-- ChartJs JavaScript -->
        <script src="<?php echo base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>

        <!-- semantic js -->
        <!-- <script src="<?php echo base_url() ?>assets/js/semantic.min.js" type="text/javascript"></script> -->
        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url("assets/datatables/js/dataTables.min.js") ?>"></script>
        <!-- tinymce texteditor -->
        <script src="<?php echo base_url() ?>assets/tinymce/tinymce.min.js" type="text/javascript"></script>
        <!-- Table Head Fixer -->
        <script src="<?php echo base_url() ?>assets/js/tableHeadFixer.js" type="text/javascript"></script>

        <!-- Admin Script -->
        <script src="<?php echo base_url('assets/js/frame.js') ?>" type="text/javascript"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() ?>assets/js/custom.js" type="text/javascript"></script>
        <!-- jstree view -->
        <script src="<?php echo base_url() ?>assets/vakata-jstree/dist/jstree.min.js"></script>
    </body>
</html>
