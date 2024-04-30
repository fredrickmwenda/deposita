<div class="row">
    <div class="col-sm-12">
        <div  class="panel panel-default thumbnail">
            <?php
            if($this->permission->method('main_department','read')->access()  || $this->permission->method('main_department','update')->access() || $this->permission->method('main_department','delete')->access()){
            ?>

            <?php } ?>
            <?php
            if($this->permission->method('add_main_department','create')->access()){
            ?>
            <div class="panel-body panel-form">
                <div class="row">
                    <div class="col-md-9 col-sm-12">

                        <?php echo form_open_multipart('#','class="form-inner"') ?>

                        <?php echo form_hidden('id',$department->id) ?>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label">Episode From Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input disabled name="date_of_birth" type="date" id="certFrom" date-date="" data-date-format="MM-DD-YYYY" value="<?php echo $episode->episodeFrom ?>" class="dropdown-month-years form-control" type="text" placeholder="" id="date_of_birth"   autocomplete="off">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label">Episode To Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                  <input disabled id="certTo" type="date" id="certFrom" date-date="" data-date-format="MM-DD-YYYY" value="<?php echo $episode->episodeTo ?>" name="date_of_birth" class="dropdown-month-years form-control" type="text" placeholder="12/5/1290" id="date_of_birth"   autocomplete="off">
                            </div>

                        </div>

                          <?php foreach ($episodeServices as $key => $episodeService): ?>
                            <!-- SERVICE 1 -->
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php if ($key != 0) {
                                echo "";
                                }else{
                                  echo "Patient Services";
                                } ?></label>
                                <div class="col-xs-4">
                                    <select disabled id="serviceSelect" class="form-control" class="service" name="serviceId">

                                      <?php foreach ($services as $service): ?>
                                        <option <?php if ($service->id == $episodeService->serviceId) {
                                          echo "selected";
                                        } ?> value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-xs-5">
                                  <input type="hidden" name="patientId" value="<?php echo $patient->id ?>">
                                    <input name="" disabled value="<?php echo $episodeService->firstname." ".$episodeService->lastname ?>" id="providerSearch" class="form-control" type="text" placeholder="Type to Search Provider" value="">
                                    <input id="providerIdInput" class="form-control" type="hidden" placeholder="Type to Search Provider" name="providerId1" value="">
                                </div>
                            </div>
                          <?php endforeach; ?>

                        <div class="form-group row">
                            <label for="" class="col-xs-3 col-form-label"></label>
                            <div class="col-xs-3" id="">

                            </div>
                            <div class="col-xs-5" id="result">

                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="ui buttons">

                                    <a href="<?php echo base_url('episode/edit/'.$episode->id) ?>"  class="ui positive button">Edit</a>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close() ?>

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

    //Format input fields
$("input").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
}).trigger("change")


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
    </script>

</div>
