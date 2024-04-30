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

                        <?php echo form_open_multipart('/episode/create','class="form-inner"') ?>

                        <?php echo form_hidden('id',$department->id) ?>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label">Episode From Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                <input name="episodeFrom" type="text" id="certFrom" value="<?php echo date('m-d-Y', strtotime($episode->episodeFrom)) ?>" class="dropdown-month-years form-control" placeholder="" id="date_of_birth"   autocomplete="off">
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="date_of_birth" class="col-xs-3 col-form-label">Episode To Date<i class="text-danger">*</i></label>
                            <div class="col-xs-9">
                                  <input disabled id="certTo" type="text" value="<?php echo date('m-d-Y', strtotime($episode->episodeTo)) ?>" name="episodeTo" class="dropdown-month-years form-control" placeholder="12/5/1290" id="date_of_birth"   autocomplete="off">
                            </div>
                            <input type="hidden"  id="certTo2" name="episodeToTwo" type="text" placeholder="To Date" autocomplete="off">

                              <input type="hidden" name="episodeId" value="<?php echo $episode->id ?>">
                                <input type="hidden" name="patientId" value="<?php echo $episode->patientId ?>">
                        </div>

                          <?php foreach ($episodeServices as $key => $episodeService): ?>
                            <!-- SERVICE 1 -->
                            <?php $newKey = $key + 1;
                            $stringKey = strval($newKey);
                            ?>
                            <div class="form-group row">
                                <label for="name" class="col-xs-3 col-form-label"><?php if ($key != 0) {
                                echo "";
                                }else{
                                  echo "Patient Services";
                                } ?></label>
                                <div class="col-xs-3">
                                    <select id="serviceSelect"  class="form-control" class="service" name="<?php echo "serviceId".$stringKey?>">

                                      <?php foreach ($services as $service): ?>
                                        <option <?php if ($service->id == $episodeService->serviceId) {
                                          echo "selected";
                                        } ?> value="<?php echo $service->id ?>"><?php echo $service->name ?></option>
                                      <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-xs-6">
                                  <input type="hidden" name="<?php echo 'serviceProviderId'.$stringKey?>" value="<?php echo $episodeService->id ?>">
                                  <select id="serviceSelect"  class="form-control" class="service" name="<?php echo "providerId".$stringKey?>">

                                    <?php foreach ($employees as $employee): ?>
                                      <option <?php if ($employee->user_id == $episodeService->providerId) {
                                        echo "selected";
                                      } ?> value="<?php echo $employee->user_id ?>"><?php echo $employee->firstname." ".$employee->lastname ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                  </div>
                            </div>
                          <?php endforeach; ?>

                          <!-- Extra form groupd for adding services -->
                          <?php if (count($episodeServices) == 1): ?>
                              <!-- Display services 2 and 3 -->
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
                          <?php endif; ?>
                          <?php if (count($episodeServices) == 2): ?>
                              <!-- Display service 3 only -->

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
                          <?php endif; ?>




                          <div class="form-group row">

                          </div>
                        <div class="form-group row">
                            <label for="" class="col-xs-2 col-form-label" style="margin-left: 1.25%;"></label>
                            <div class="col-xs-3" id="">
                              <div class="col-sm-offset-3 col-sm-6">
                                  <div class="ui buttons">

                                      <button type="submit" class="ui positive button">Update</button>
                                  </div>
                              </div>
                            </div>
                            <div class="col-xs-5" style="margin-left: 10.5%" id="result">

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
            dateFormat: "mm-dd-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+0"
         });
    });


    var certFrom = document.getElementById('certFrom');
    var certTo = document.getElementById('certTo');

    certFrom.onchange = function () {
  var pValue = certFrom.value;
  console.log('from date');
    console.log(pValue);
  // var dateArray = pValue.split('-');
  // var pickedValue = dateArray[1].toString()+ '-'+ dateArray[0].toString() +"-"+dateArray[2].toString();
    // console.log(pickedValue);
  var result = new Date(pValue);
    console.log(result);
  result.setDate(result.getDate() + 59);
  console.log(result);
  var dd = String(result.getDate()).padStart(2, '0');
var mm = String(result.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = result.getFullYear();

var date = mm + '-' + dd + '-' + yyyy;
certTo.value = date;
var date2 = dd + '-' + mm + '-' + yyyy;

$('#certTo2').val(date2);
  console.log(certFrom.value);
  console.log(certTo.value);
  console.log(certTo2.value);

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

    $('#providerSearch1').keyup(function(){
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
      var providerSearch = document.getElementById('providerSearch1');
      var providerIdInput1 = document.getElementById('providerIdInput1');
      var selectedListItemContent = selectedListItem.innerHTML;
      providerSearch.value = selectedListItemContent;
      providerIdInput1.value = id;

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
    </script>

</div>
