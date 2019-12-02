<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Location edit</span>
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
                    <a href="<?php echo base_url('Location_Master_Con')?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Locations</a>
                    <a href="#" class="breadcrumb-item">Location Update</a>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

        </div>
    </div>
    <!-- /page header -->

    <div class="content">

        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Update Location Data</h5>

            </div>

            <div class="card-body">
                <form action="<?php echo base_url('Location_Master_Con/updateLocation/'.$location[0]->location_id); ?>" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Location: <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="name" id="name" value="<?php echo $location[0]->location; ?>" class="form-control" placeholder="Example (Pvt) Ltd" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address : <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <textarea name="address" id="address" rows="4" cols="4" class="form-control" required><?php echo $location[0]->address; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>County: </label>
                                <div class="col-md-4">
                                <select id="country" name="country" class="form-control select-search col-md-4"
                                        onchange="getPhoneCode();" data-fouc required>
                                    <option value="">--- Select Country ----</option>
                                    <?php foreach ($country as $row) {
                                        ?>
                                        <option value="<?php echo $row->id; ?>" <?php echo set_select('country', $row->id); if($location[0]->country == $row->id ){echo 'selected';} ?>  > <?php echo $row->country; ?> </option>
                                        <?php
                                    } ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Phone : </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text" id="phoneCode"></span>
                                                    </span>
                                        <input id="phone" name="phone" type="number" value="<?php echo $location[0]->phone; ?>"  class="form-control" maxlength="10"  placeholder="0111234567" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label col-md-1">Status:</label>
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline form-check-right">
                                        <label class="form-check-label">
                                            Active
                                            <input type="radio" id="active" name="status" class="form-check-input-styled"
                                                   value="1" data-fouc <?php if($location[0]->active == '1'){echo 'checked';}?> >
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline form-check-right">
                                        <label class="form-check-label">
                                            Inactive
                                            <input type="radio" id="inactive" name="status" class="form-check-input-styled "
                                                   value="0" data-fouc <?php if($location[0]->active == '0'){echo 'checked';}?> >
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-right">
                            <button type="submit" value="update" name="update" class="btn bg-success-800 pull-right btn-flat"><i class="icon-pencil5"></i> Update Company</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>

    </div> <!--    close content-->

    <script>

        $(document).ready(function () {
            getPhoneCode();
        });

        function getPhoneCode() {

            var country = $('#country').val();

            if(country != ''){
                $.ajax({
                    url: '<?php echo base_url("Location_Master_Con/getPhoneCode")?>',
                    type:'POST',
                    data:({
                        'countryId':country,
                    }),
                    success:function (data) {
                        if(data!=''){
                            $('#phoneCode').text(data);
                        }
                    }
                });
            }else{
                $('#phoneCode').text('');
            }
        }

    </script>
