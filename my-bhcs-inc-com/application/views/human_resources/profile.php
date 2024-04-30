 <?php
if($this->permission->method('employee_list','read')->access() || $this->permission->method('employee_list','update')->access() || $this->permission->method('employee_list','delete')->access()){
?>
<style media="screen">
  dt {
    font-size: 18px;
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
                        <h1><?php echo display('employee_information') ?></h1>
                    <br>
                    <?php if(empty($profile)){?>

                     <?php } ?>
                    </div>

                    <div class="col-sm-4" align="center">
                        <img hidden alt="Picture" src="<?php echo (!empty($profile->picture) ? base_url($profile->picture) : base_url("assets/images/no-img.png")) ?>" class="img-thumbnail img-responsive">
                        <h3><?php echo (!empty($profile->fname)?$profile->fname:null) ?> <?php echo (!empty($profile->lname)?$profile->lname:null) ?></h3>

                    </div>

                    <div class="col-sm-8">
                        <dl class="dl-horizontal">
                            <dt>Creation Date</dt><dd><?php echo $profile->create_date ?></dd>
                            <dt>Hire Date</dt><dd><?php echo $profile->hire_date ?></dd>
                            <dt>Name</dt><dd><?php echo $profile->firstname." ".$profile->lastname; ?></dd>
                            <dt>Branch</dt><dd><?php echo $profile->branch ?></dd>
                            <dt>Street Address</dt><dd><?php echo $profile->address ?></dd>
                            <dt>City</dt><dd><?php echo $profile->city ?></dd>
                            <dt>State</dt><dd><?php echo $profile->state ?></dd>
                            <dt>Cell Phone</dt><dd><?php echo $profile->cellphone ?></dd>
                            <dt>Home Phone</dt><dd><?php echo $profile->homephone ?></dd>
                            <dt>Emergency Contact</dt><dd><?php echo $profile->emContact ?></dd>
                            <dt>Emergency Contact Number</dt><dd><?php echo $profile->emPhone ?></dd>
                            <dt>Discipline</dt><dd><?php echo $profile->discipline ?></dd>
                            <dt>Gender</dt><dd><?php echo $profile->sex; ?></dd>

                            <dt>Date of Birth</dt><dd><?php echo $profile->date_of_birth ?></dd>

                            <dt><?php echo display('status') ?></dt><dd><?php if(!empty($profile->status)){ echo (($profile->status==1)?display('active'):display('inactive')); }?></dd>
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
