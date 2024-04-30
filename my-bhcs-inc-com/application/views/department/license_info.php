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
        <div  class="panel panel-default thumbnail">

             <?php
             if($this->permission->method('patient_list','read')->access()){
             ?>
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="col-xs-12 nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">License Information</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="col-xs-12 tab-content">
                    <br>
                    <!-- INFORMATION -->
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-sm-3" align="center">
                              
                            </div>

                            <div class="col-sm-9">
                                <dl class="dl-horizontal">
                                    <dt>License Id</dt><dd> <?php echo $profile->id ?></dd>
                                    <dt>License Type</dt><dd><?php echo $profile->licType ?></dd>
                                    <dt>From Date</dt><dd><?php echo $profile->licFrom ?></dd>
                                    <dt>Due Date</dt><dd><?php echo $profile->licDue ?></dd>

                                </dl>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="documents">
                        <div class="row">
                            <div class="col-sm-12">
                                <table width="100%" class="datatable table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('serial') ?></th>
                                            <th><?php echo display('doctor_name') ?></th>
                                            <th><?php echo display('description') ?></th>
                                            <th><?php echo display('date') ?></th>
                                            <th><?php echo display('upload_by') ?></th>
                                            <th class="no-print"><?php echo display('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($documents)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($documents as $document) { ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $document->doctor_name; ?></td>
                                                    <td><?php echo character_limiter(strip_tags($document->description),50); ?></td>
                                                    <td><?php echo date('d-m-Y',strtotime($document->date)); ?></td>
                                                    <td><?php echo $document->upload_by; ?></td>
                                                    <td class="center no-print" width="110">
                                                        <a target="_blank" href="<?php echo base_url($document->hidden_attach_file) ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                        <a href="<?php echo base_url("patient/document_form/$document->patient_id") ?>" class="btn btn-xs btn-warning" title="Add Document"><i class="fa fa-plus"></i></a>
                                                        <a download target="_blank" href="<?php echo base_url($document->hidden_attach_file) ?>" class="btn btn-xs btn-success"><i class="fa fa-download"></i></a>
                                                        <a href="<?php echo base_url("patient/document_delete/$document->id?file=$document->hidden_attach_file") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>') "><i class="fa fa-trash"></i></a>
                                                    </td>
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

            <div  class="panel-footer">
                <div style="display: none" class="text-center">
                    <strong><?php echo $this->session->userdata('title') ?></strong>
                    <p class="text-center"><?php echo $this->session->userdata('address') ?></p>
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
    </div>

</div>
