<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Enter Checking Out Manually</span>
                </h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-link btn-float text-default"><i
                            class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i>
                        <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i>
                        <span>Schedule</span></a>
                </div>
            </div>

            <!--            --><?php //print_r($userGroups);?>

        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="<?php echo base_url('Master_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <!-- <a href="<?php echo base_url('master/Master_Team_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Team</a> -->
                    <a href="#" class="breadcrumb-item">Checking Out</a>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->

    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <legend class="font-size-lg font-weight-bold">Enter Checking Out</legend>
            </div>
            <div class="card-body">
                <form action="<?php echo base_url('master/Master_Team_Con/saveData'); ?>" method="post">
                    <div class="form-group row">
                              <label class="col-form-label col-sm-1">Location</label>
                              <div class="col-sm-3">
                                  <select id="location" name="location" class="form-control select-search" data-placeholder="Selecet Location"
                                           data-fouc required onchange="">
                                           <option></option>
                                      <?php foreach ($locations as $row) {
                                          ?>
                                          <option value="<?php echo $row->location_id; ?>" <?php echo set_select('country', $row->location_id);?>> <?php echo $row->location; ?> </option>
                                          <?php
                                      } ?>
                                  </select>
                                  <span class="error" id="error"><?php echo form_error('location'); ?></span>
                              </div>
                                <div class="col-sm-2"></div>
                          <label class="col-form-label col-sm-1">Department</label>
                          <div class="col-sm-3">
                              <select id="department" name="department" class="form-control select-search" data-placeholder="Selecet Location" onchange="validateTeam();"
                                       data-fouc required>
                              </select>
                              <span class="error" id="error"><?php echo form_error('department'); ?></span>
                          </div>
                          </div>
                            <div class="row form-group">
                              <label class="col-form-label col-sm-1">Team Name</label>
                              <div class="col-sm-2">
                                  <input id='team' name="team" class="form-control " type="text" onkeyup="validateTeam();" required>
                                  <span class="error" id="error"><?php echo form_error('team'); ?></span>
                                  <span class="error" id="errorTeam"></span>
                              </div>

                            </div>
                            <div class="row form-group">
                              <!-- <div class="col-sm-3"></div> -->
                                <label class="col-form-label col-md-1">Status:</label>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline form-check-right">
                                        <label class="form-check-label">
                                            Active
                                            <input type="radio" id="active" name="status" <?php set_checkbox('status', '1');?> class="form-check-input-styled"
                                                   value="1" data-fouc checked>
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline form-check-right">
                                        <label class="form-check-label">
                                            Inactive
                                            <input type="radio" id="inactive" name="status" <?php set_checkbox('status', '0');?> class="form-check-input-styled "
                                                   value="0" data-fouc >
                                        </label>
                                    </div>
                                </div>
                            </div>

                    <div class="row">
                        <div class="col-md-4 text-right">
                                <button id="save_btn" type="submit" value="save" name="save" class="btn bg-primary-800 pull-right btn-flat"><i class="icon-pencil5"></i> Save</button>
                                <button type="reset"  name="clear" class="btn bg-warning-800 pull-right btn-flat"><i class="icon-pencil5"></i> Clear</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div> <!--    close content-->

    <script>
        // //
        // $(document).ready(function () {
        //     getPhoneCode();
        // });
        //
       function fetchData(sendData,dataURL) {
            // Return the $.ajax promise
            return $.ajax({
                data: sendData,
                dataType: 'json',
                type:'POST'
                url: dataURL
            });
        }

        // var location = $('#location').val();

        var team =  fetchData({'location':location},'<?php echo base_url("manualwork/Checking_Out_Con/getTeams")?>');

        alert(team);

        // function getDepartment() {
        //
        //     var location = $('#location').val();
        //     var html = "<option></option>";
        //     if(location != ''){
        //         $.ajax({
        //             url: '<?php echo base_url("master/Master_Team_Con/getDepart")?>',
        //             type:'POST',
        //             data:({
        //                 'location':location,
        //             }),
        //             success:function (data) {
        //               var json_value = JSON.parse(data);
        //               // if(json_value<1){
        //                 for (var i = 0; i < json_value.length; i++) {
        //                       html += "<option value='" + json_value[i]['id'] + "'>" + json_value[i]['department'] + "</option>";
        //                 }
        //
        //               // }
        //               $('#department').empty().append(html);
        //             }
        //         });
        //     }else{
        //         // $('#phoneCode').text('');
        //     }
        // }
        //
        // function validateTeam() {
        //   $('#save_btn').removeAttr('disabled','disabled');
        //   $('#errorTeam').text('');
        //   var location = $("#location").val();
        //   var depart = $("#department").val();
        //   var team = $("#team").val();
        //   var team = $("#team").val();
        //
        //   if(location !="" && depart !="" && team !=""){
        //     $.ajax({
        //         url: '<?php echo base_url("master/Master_Team_Con/validateTeam")?>',
        //         type:'POST',
        //         data:({
        //             'location':location,
        //             'depart':depart,
        //             'team':team,
        //         }),
        //         success:function (data) {
        //         if(data=="duplicate"){
        //           $('#save_btn').attr('disabled','disabled');
        //           $('#errorTeam').text('This Name is already created,Use different Name');
        //         }else if(data=="valid"){
        //           $('#save_btn').removeAttr('disabled','disabled');
        //           $('#errorTeam').text('');
        //         }
        //
        //       }
        //     });
        //   }
        //
        // }

    </script>
