
<style media="screen">

.status-select {
  margin-bottom: 10px;
  margin-left: 39px;
  width: 133px !important;
}

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
    <!--  table area -->
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <?php
            if($this->permission->method('add_patient','create')->access() ){
            ?>
            <div class="panel-heading no-print">
                <div class="row">
                    <div class="col-lg-2 col-sm-12">
                        <div class="btn-group">
                            <a class="btn btn-success" href="<?php echo base_url("patient/create") ?>"> <i class="fa fa-plus"></i>  <?php echo display('add_patient') ?> </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12"></div>

                </div>
            </div>
            <?php } ?>


            <?php
                if($this->permission->method('patient_list','read')->access() || $this->permission->method('patient_list','update')->access() || $this->permission->method('patient_list','delete')->access()){
                ?>
            <div class="panel-body">
                <table id="patientsTable" width="100%" class="table table-striped table-bordered table-hover">
                  <select class="status-select" id="statusSelect" name="">
                    <option selected disabled value="filter">Filter By Status</option>
                    <option value="All">All</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="DC">DC</option>
                    <option value="Expired">Expired</option>
                  </select>
                    <thead>
                        <tr>

                            <th><?php echo display('id_no') ?></th>
                            <th>Full Name</th>
                            <th>Mobile Number</th>
                            <th>Street Address</th>
                            <th>Gender</th>

                             <?php
                             if($this->permission->method('patient_list','read')->access() || $this->permission->method('patient_list','update')->access() || $this->permission->method('patient_list','delete')->access()){
                              ?>

                            <th><?php echo display('action') ?></th>
                            <?php } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($patients)) { ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($patients as $patient) {
                                    @$admission = $this->db->where('patient_id', $patient->patient_id)->where('isComplete', 0)->get('bill_admission')->row()->admission_id;
                                    @$appointment = $this->db->where('patient_id', $patient->patient_id)->where('status', 1)->get('appointment')->row()->appointment_id;
                                    @$bed = $this->db->where('patient_id', $patient->patient_id)->where('status', 1)->get('bm_bed_assign')->row()->patient_id;
                                ?>
                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                <td><?php echo $sl; ?></td>

                                <td><?php echo $patient->firstname." ".$patient->lastname; ?></td>

                                <td><?php echo $patient->phone; ?></td>
                                <td><?php echo $patient->address; ?></td>
                                <td><?php echo $patient->sex; ?></td>

                                    <?php
                                    if($this->permission->method('patient_list','read')->access() || $this->permission->method('patient_list','update')->access() || $this->permission->method('patient_list','delete')->access()){
                                     ?>
                                <td class="center">
                                    <?php
                                    if($this->permission->method('patient_list','read')->access()){
                                    ?>
                                        <a href="<?php echo base_url("patient/profile/$patient->id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="<?= display('view')?>"></i></a>
                                    <?php } ?>

                                    <?php
                                    if($this->permission->method('patient_list','update')->access()){
                                    ?>
                                        <a href="<?php echo base_url("patient/read/$patient->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="<?= display('edit')?>"></i></a>
                                    <?php } ?>



                                    <?php
                                    if($this->permission->method('prescription','create')->access()){
                                        if(!empty(@$appointment)){
                                    ?>
                                        <a href="<?php echo base_url("prescription/prescription/create?aid=$appointment&pid=$patient->patient_id") ?>" class="btn btn-xs btn-success"><i class="ti-book" data-toggle="tooltip" data-placement="top" title="<?= display('add_prescription')?>"></i></a>
                                    <?php } } ?>

                                    <?php if($this->permission->method('bill_list','create')->access()){
                                        if(!empty(@$admission)){
                                    ?>

                                    <?php } } ?>

                                    <?php if($this->permission->method('bed_assign','create')->access()){
                                        if(!empty(@$bed)){
                                    ?>
                                        <a class="btn btn-xs btn-info text-white discharged" title="<?= display('discharged')?>" data-toggle="modal" data-target="#modal_form" onclick="discharged('<?= $patient->patient_id?>')"><i class="fa fa-eject"></i></a>
                                    <?php } } ?>


                                </td>
                                <?php } ?>

                                </tr>
                                <?php $sl++; ?>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
            <?php }else{
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
            } ?>
        </div>
    </div>
</div>

 <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title pull-left" id="exampleModalLabel"><?= display('discharged')?></h2>
              </div>
              <div class="modal-body form">
                 <?php echo form_open('bed_manager/bed_assign/discharged_pid','class="form-horizontal" id="form"') ?>

                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3"><?php echo display('patient_id') ?> <i class="text-danger">*</i></label>
                        <div class="col-md-9">
                          <input name="patient_id" placeholder="<?php echo display('patient_id') ?>" class="form-control" type="text" readonly>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3"><?= display('discharge_date')?> <i class="text-danger">*</i></label>
                        <div class="col-md-9">
                          <input name="discharge_date" placeholder="<?= display('discharge_date')?>" class="form-control cdatepicker" type="text">
                        </div>
                      </div>

                   </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
                <?php echo form_close() ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= display('close')?></button>
              </div>
            </div>
          </div>
        </div>
<script type="text/javascript">
     function discharged(id){
          $('#form')[0].reset();
          $('[name="patient_id"]').val(id);
    };

    $(document).ready(function() {
        //custom date picker
        $('.cdatepicker').datepicker({
            minDate:0,
            dateFormat: "dd-mm-yy"
        });
    });

    $(document).ready(function() {
      // initialize table
      $('#patientsTable').DataTable({

          responsive: true,
          pageLength: 50,
          dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
          "lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "Al"]],
          buttons: [
              {extend: 'copy', className: 'btn-sm'},
              {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
              {extend: 'excel', title: 'ExampleFile', className: 'btn-sm', title: 'exportTitle'},
              {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
              {extend: 'print', className: 'btn-sm'}
          ]
      });
      //datatables
      $('#statusSelect').on("change", function() {
            event.preventDefault();
            var table = $('#patientsTable');
            table.addClass('table-stripped');
            table.addClass('table-bordered');
            table.addClass('table-hover');
            if (event.target.value == "filter" || event.target.value == "All") {
              $.ajax({
                  url: "<?= base_url('patient/all') ?>",
                  dataType: 'JSON',
                  method: 'POST',
                  data: {
                      'status': $('#statusSelect').val()
                  },
                  success: function(data_return) {
                      console.log(data_return);

                      // destroy the DataTable
                      table.dataTable().fnDestroy();
                      // clear the table body
                      table.find('tbody').empty();
                      // reinitiate
                      table.DataTable({
                          // # data source as object (JSON object array)
                          // You must use the exactly format as shown on the link below
                          // https://datatables.net/manual/data/#Objects
                          data: data_return,
                          "pageLength": 50,
                          dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                          "lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "Al"]],
                          buttons: [
                              {extend: 'copy', className: 'btn-sm'},
                              {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
                              {extend: 'excel', title: 'ExampleFile', className: 'btn-sm', title: 'exportTitle'},
                              {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                              {extend: 'print', className: 'btn-sm'}
                          ],
                          columns: [{
                                  "data": "id"
                              },
                              {
                                  "data": "name"
                              },
                              {
                                  "data": "cellphone"
                              },
                              {
                                  "data": "address"
                              },
                              {
                                  "data": "sex"
                              },
                              {
                                  "data": null
                              },
                          ],


                          columnDefs: [{
                                  // # hide the first column
                                  // https://datatables.net/examples/advanced_init/column_render.html
                                  "targets": [0],
                                  // "visible": false
                              },
                              {
                                  // # disable search for column number 2
                                  // https://datatables.net/reference/option/columns.searchable
                                  "targets": [3],
                                  "searchable": false,
                                  // # disable orderable column
                                  // https://datatables.net/reference/option/columns.orderable
                                  "orderable": false
                              },
                              {
                                  // # action controller (edit,delete)
                                  "targets": [5],
                                  // # column rendering
                                  // https://datatables.net/reference/option/columns.render
                                  "render": function(data, type, row, meta) {
                                      $controlls = '<a href="<?php echo base_url("patient/profile/$row->id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                                      $controlls += ' <a href="<?php echo base_url("patient/read/$row->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
                                      return $controlls;
                                  },
                                  "width": 100
                              }
                          ],
                          // #set order descending and ascending
                          // https: //datatables.net/reference/option/order
                          "order": [
                              [0, 'asc'],

                          ]
                      });
                  }
              });
            }else {

              $.ajax({
                  url: "<?= base_url('patient/filter_patients') ?>",
                  dataType: 'JSON',
                  method: 'POST',
                  data: {
                      'status': $('#statusSelect').val()
                  },
                  success: function(data_return) {
                      console.log(data_return);

                      // destroy the DataTable
                      table.dataTable().fnDestroy();
                      // clear the table body
                      table.find('tbody').empty();
                      // reinitiate
                      table.DataTable({
                          // # data source as object (JSON object array)
                          // You must use the exactly format as shown on the link below
                          // https://datatables.net/manual/data/#Objects
                          data: data_return,
                          "pageLength": 50,
                          dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                          "lengthMenu": [[25, 50, 75, -1], [25, 50, 75, "Al"]],
                          buttons: [
                              {extend: 'copy', className: 'btn-sm'},
                              {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
                              {extend: 'excel', title: 'ExampleFile', className: 'btn-sm', title: 'exportTitle'},
                              {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                              {extend: 'print', className: 'btn-sm'}
                          ],
                          columns: [{
                                  "data": "id"
                              },
                              {
                                  "data": "name"
                              },
                              {
                                  "data": "cellphone"
                              },
                              {
                                  "data": "address"
                              },
                              {
                                  "data": "sex"
                              },
                              {
                                  "data": null
                              },
                          ],


                          columnDefs: [{
                                  // # hide the first column
                                  // https://datatables.net/examples/advanced_init/column_render.html
                                  "targets": [0],
                                  // "visible": false
                              },
                              {
                                  // # disable search for column number 2
                                  // https://datatables.net/reference/option/columns.searchable
                                  "targets": [3],
                                  "searchable": false,
                                  // # disable orderable column
                                  // https://datatables.net/reference/option/columns.orderable
                                  "orderable": false
                              },
                              {
                                  // # action controller (edit,delete)
                                  "targets": [5],
                                  // # column rendering
                                  // https://datatables.net/reference/option/columns.render
                                  "render": function(data, type, row, meta) {
                                      $controlls = '<a href="<?php echo base_url("human_resources/employee/profile/$row->id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                                      $controlls += ' <a href="<?php echo base_url("human_resources/employee/form/$row->id/1") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
                                      return $controlls;
                                  },
                                  "width": 100
                              }
                          ],
                          // #set order descending and ascending
                          // https: //datatables.net/reference/option/order
                          "order": [
                              [0, 'asc'],

                          ]
                      });
                  }
              });

            }


});

});
 </script>
