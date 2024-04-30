<?php
if($this->permission->method('employee_list','read')->access() || $this->permission->method('employee_list','update')->access() || $this->permission->method('employee_list','delete')->access()){
?>
<style media="screen">
 dt {
   font-size: 18px;
   width: 250px !important;
   margin-right: 15px
 }

 dd {
   font-size: 18px;
 }
</style>
<div class="row">
   <div class="col-sm-12" id="PrintMe">
       <div class="panel panel-default thumbnail">

           <div class="panel-heading no-print">
               <div class="btn-group">
                   <button type="button" onclick="printContent('PrintMe')" class="btn btn-danger" ><i class="fa fa-print"></i></button>
               </div>
           </div>

           <div class="panel-body">
               <div class="row">
                   <div class="col-sm-12" align="center">
                       <h1>Patient Information</h1>
                   <br>
                   <?php if(empty($profile)){?>

                    <?php } ?>
                   </div>

                   <div class="col-sm-3" align="center">
                       <img hidden alt="Picture" src="<?php echo (!empty($profile->picture) ? base_url($profile->picture) : base_url("assets/images/no-img.png")) ?>" class="img-thumbnail img-responsive">
                       <h3><?php echo (!empty($profile->fname)?$profile->fname:null) ?> <?php echo (!empty($profile->lname)?$profile->lname:null) ?></h3>

                   </div>

                   <div class="col-sm-9">
                       <dl style="width: 500px" class="dl-horizontal">
                           <dt>Creation Date</dt><dd><?php echo $profile->create_date ?></dd>
                           <dt>Start of Care</dt><dd><?php echo $profile->start_of_care?></dd>
                           <dt>Name</dt><dd><?php echo $profile->firstname." ".$profile->lastname; ?></dd>
                           <dt>Branch</dt><dd><?php foreach ($branches as $branch) {
                             // code...
                             if ($branch->id == $profile->branch_id) {
                               // code...
                               echo $branch->name;
                             }
                           }  ?></dd>
                           <dt>Street Address</dt><dd><?php echo $profile->address ?></dd>
                           <dt>City</dt><dd><?php echo $profile->city ?></dd>
                           <dt>State</dt><dd><?php echo $profile->state ?></dd>
                           <dt>Mobile Number</dt><dd><?php echo $profile->phone ?></dd>
                           <dt>Alternate Phone Number</dt><dd><?php echo $profile->altphone ?></dd>
                           <dt>Next of Kin</dt><dd><?php echo $profile->next_of_kin ?></dd>
                           <dt>Next of Kin Phone Number</dt><dd><?php echo $profile->kin_phone ?></dd>
                           <dt>Category</dt><dd><?php echo $profile->category_id ?></dd>
                           <dt>Gender</dt><dd><?php echo $profile->sex; ?></dd>

                           <dt>Date of Birth</dt><dd><?php echo $profile->date_of_birth ?></dd>

                           <dt><?php echo display('status') ?></dt><dd><?php

                                if ($profile->status == 0) {
                                echo "Inactive";
                                }
                                if ($profile->status == 1) {
                                echo "Active";
                                }

                                if ($profile->status == 2) {
                                echo "DC";
                              }

                              if ($profile->status == 3) {
                              echo "Expired";
                              }

                           ?></dd>
                           <dt>Comments</dt><dd><?php echo $profile->comments ?></dd>
                       </dl>
                   </div>
               </div>
           </div>

           <div class="panel-footer">
               <div class="text-center">

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
