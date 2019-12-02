<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Add Department</span>
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
                    <a href="<?php echo base_url('Master_Department_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Department</a>
                    <a href="#" class="breadcrumb-item">Department Add</a>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->

    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Department </h5>

            </div>

            <div class="card-body">
                <form action="<?php echo base_url('Master_Department_Con/addDeparment'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-12">

                          <div class="form-group">
                              <label>Location: </label>
                              <div class="col-md-4">
                                  <select id="location" name="location" class="form-control select-search col-md-4" data-placeholder="Selecet Location"
                                           data-fouc required>
                                      <?php foreach ($locations as $row) {
                                          ?>
                                          <option value="<?php echo $row->location_id; ?>" <?php echo set_select('country', $row->location_id);?>> <?php echo $row->location; ?> </option>
                                          <?php
                                      } ?>
                                  </select>
                                  <span class="error" id="error"><?php echo form_error('country'); ?></span>
                              </div>
                          </div>

                            <div class="form-group">
                                <label>Department Name: <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="name" id="name" value="" class="form-control" placeholder="Departmemt Name" required>
                                      <span class="error" id="error"><?php echo form_error('name'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-right">
                                <button type="submit" value="save" name="update" class="btn bg-primary-800 pull-right btn-flat"><i class="icon-pencil5"></i> Save</button>
                                <button type="reset"  name="update" class="btn bg-warning-800 pull-right btn-flat"><i class="icon-pencil5"></i> Clear</button>
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
        // function getPhoneCode() {
        //
        //     var country = $('#country').val();
        //
        //     if(country != ''){
        //         $.ajax({
        //             url: '<?php echo base_url("Location_Master_Con/getPhoneCode")?>',
        //             type:'POST',
        //             data:({
        //                 'countryId':country,
        //             }),
        //             success:function (data) {
        //                 if(data!=''){
        //                     $('#phoneCode').text(data);
        //                 }
        //             }
        //         });
        //     }else{
        //         $('#phoneCode').text('');
        //     }
        //
        //
        // }

    </script>
