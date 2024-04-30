
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
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
        <?php
        if($this->permission->method('add_employee','create')->access()){
        ?>
            <div class="panel-heading no-print">

              <div class="row">
                  <div class="col-lg-2 col-sm-12">
                      <div class="btn-group">
                          <a class="btn btn-success"  href="<?php echo base_url("human_resources/employee/form_user") ?>" ?><i class="fa fa-plus"></i> Add User</a>
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-12"></div>

              </div>


            </div>
        <?php } ?>

            <div class="panel-body">
                <!-- Nav tabs -->
                <!-- <ul class="col-xs-12 nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab"> <i class="fa fa-list"></i> Users List</a>
                    </li>

                </ul> -->

                <!-- Tab panes -->
                <div class="col-xs-12 tab-content">
                    <br>
                    <!-- INFORMATION -->
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%" id="usersTable"  class="table table-striped table-bordered table-hover">
                                    <select class="status-select" id="statusSelect" name="">
                                      <option selected disabled value="filter">Filter By Status</option>
                                      <option value="All">All</option>
                                      <option value="Active">Active</option>
                                      <option value="Inactive">Inactive</option>
                                    </select>
                                    <thead>
                                        <tr>
                                            <th>ID No.</th>

                                            <th>Full Name</th>

                                            <th><?php echo display('email') ?></th>
                                            <th>Cell Phone</th>
                                            <th>User Role</th>

                                            <th><?php echo display('action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($employees)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($employees as $key => $employee) { ?>
                                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>

                                                    <td><?php echo $employee->firstname." ".$employee->lastname; ?></td>
                                                    <td><?php echo $employee->email; ?></td>
                                                    <td><?php
                                                    foreach($employeeLang as $r_data){
                                                      if($r_data->user_id == $employee->user_id){
                                                        echo $r_data->cellphone;
                                                      }
                                                    }
                                                    ?>
                                                  </td>
                                                    <td>  <?php foreach ($user_roles as $role) {
                                                      if ($employee->user_role == $role->id) {
                                                        echo $role->type;
                                                      }
                                                    } ?>  </td>

                                                    <td class="center">
                                                     <a href="<?php echo base_url("human_resources/employee/user/$employee->user_id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                     <a href="<?php echo base_url("human_resources/employee/form_user/$employee->user_id/2") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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

        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {

      // initialize table
      $('#usersTable').DataTable({

          responsive: true,
          // pageLength: 50,
          dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Al"]],
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
            var table = $('#usersTable');
            table.addClass('table-stripped');
            table.addClass('table-bordered');
            table.addClass('table-hover');
            if (event.target.value == "filter" || event.target.value == "All") {
              $.ajax({
                  url: "<?= base_url('human_resources/employee/all_users') ?>",
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
                                  "data": "email"
                              },
                              {
                                  "data": "cellphone"
                              },
                              {
                                  "data": "role"
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
                                      $controlls = '<a href="<?php echo base_url("human_resources/employee/user/$row->id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                                      $controlls += ' <a href="<?php echo base_url("human_resources/employee/form-user/$row->id/2") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
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
                  url: "<?= base_url('human_resources/employee/filter_users') ?>",
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
                          // "pageLength": 50,
                          dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Al"]],
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
                                  "data": "email"
                              },
                              {
                                  "data": "cellphone"
                              },
                              {
                                  "data": "role"
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
                                      $controlls = '<a href="<?php echo base_url("human_resources/employee/user/$row->id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>';
                                      $controlls += ' <a href="<?php echo base_url("human_resources/employee/form_user/$row->id/2") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>';
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
</div>
