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
            <div class="panel-heading no-print">
              <div class="row">
                  <div class="col-lg-2 col-sm-12">
                      <div class="btn-group row">
                          <a class="btn btn-success"  href="<?php echo base_url("human_resources/employee/form") ?>" ?><i class="fa fa-plus"></i> Add Employee</a>


                      </div>
                  </div>

                
                  <?php echo form_open('patient/search3',array('method'=>'get')) ?>

                  <?php echo form_close() ?>
              </div>
            </div>
        <?php } ?>

            <div class="panel-body">
                <!-- Nav tabs -->


                <!-- Tab panes -->
                <div class="col-xs-12 tab-content">
                    <br>
                    <!-- INFORMATION -->
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="employeesTable" width="100%" class="datatable table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID No.</th>
                                            <th>Full Name</th>
                                            <th>Mobile Number</th>
                                            <th>Street Address</th>
                                            <th>Gender</th>

                                            <th><?php echo display('action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($employees)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($employees as $employee) { ?>
                                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>

                                                    <td><?php echo $employee->firstname." ".$employee->lastname; ?></td>

                                                    <td><?php
                                                    foreach($employeeLang as $r_data){
                                                      if($r_data->user_id == $employee->user_id){
                                                        echo $r_data->cellphone;
                                                      }
                                                    }
                                                    ?>
                                                  </td>
                                                  <td><?php
                                                  foreach($employeeLang as $r_data){
                                                    if($r_data->user_id == $employee->user_id){
                                                      echo $r_data->address;
                                                    }
                                                  }
                                                  ?>
                                                </td>
                                                    <td><?php echo $employee->sex; ?></td>

                                                    <td class="center">

                                                     <a href="<?php echo base_url("human_resources/employee/profile/$employee->user_id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                     <a href="<?php echo base_url("human_resources/employee/form/$employee->user_id/1") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>

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

                    <div role="tabpanel" class="tab-pane" id="language">
                        <div class="row">
                            <div class="col-sm-12">
                               <table  width="100%" class="datatable table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('serial') ?></th>
                                            <th><?php echo display('user') ?></th>
                                            <th><?php echo display('language') ?></th>
                                            <th><?php echo display('first_name') ?></th>
                                            <th><?php echo display('last_name') ?></th>
                                            <th><?php echo display('designation') ?></th>
                                            <th><?php echo display('phone') ?></th>
                                            <th><?php echo display('specialist') ?></th>
                                            <th><?php echo display('address') ?></th>
                                            <th><?php echo display('action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($employeeLang)) { ?>
                                            <?php $sl = 1; ?>
                                            <?php foreach ($employeeLang as $employee) { ?>
                                                <tr class="<?php echo ($sl & 1)?"odd gradeX":"even gradeC" ?>">
                                                    <td><?php echo $sl; ?></td>
                                                    <td><?php echo $employee->fullname; ?></td>
                                                    <td><?php echo $employee->language; ?></td>
                                                    <td><?php echo $employee->firstname; ?></td>
                                                    <td><?php echo $employee->lastname; ?></td>
                                                    <td><?php echo $employee->designation; ?></td>
                                                    <td><?php echo $employee->phone; ?></td>
                                                    <td><?php echo $employee->specialist; ?></td>
                                                    <td><?php echo $employee->address; ?></td>

                                                    <td class="center">
                                                     <a href="<?php echo base_url("human_resources/employee/profile/$employee->user_id") ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                     <a href="<?php echo base_url("human_resources/employee/edit_lang/$employee->id") ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                                                     <a href="<?php echo base_url("human_resources/employee/delete_lang/$employee->id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>')"><i class="fa fa-trash"></i></a>
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
      //datatables
      $('#statusSelect').on("change", function() {
            event.preventDefault();

            var table = $('#employeesTable');

            $.ajax({
                url: "<?= base_url('human_resources/employee/filter_employees') ?>",
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
                                    $controlls = '<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit_news_modal" data-id="' + row.id + '" data-title="' + row.title + '" data-slug="' + row.slug + '" data-text="' + row.text + '">Edit</button>';
                                    $controlls += '<button class="btn btn-sm btn-danger ml-2" data-toggle="modal" data-target="#delete_news_modal" data-id="' + row.id + '" data-title="' + row.title + '" data-slug="' + row.slug + '" data-text="' + row.text + '">Delete</button>';
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

        });

});
    </script>
</div>
