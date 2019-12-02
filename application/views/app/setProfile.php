<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OA APP </title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/css/toastr/toastr.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/css/toastr/toastr.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/jquery-timepicker/jquery.timepicker.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url()?>assets/global_assets/js/main/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->
    <!-- Theme JS files -->
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
    <!--    <script src="--><?php //echo base_url()?><!--assets/global_assets/js/plugins/forms/styling/switchery.min.js"></script>-->
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/styling/switch.min.js"></script>
    <!--    <script src="--><?php //echo base_url()?><!--assets/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>-->
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/form_select2.js"></script>

    <style>
        .error{
            color: red;
            font-weight: bold;
        }

        .table > thead{
            background-color: #263238;
            color: azure;
        }
    </style>

<body>


<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">
            <!-- Info blocks -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="card-title">ProductM Application</h2>
                    <form action="<?php echo base_url('Profile_App_Con/setCookies')?>" method="post">
                        <fieldset class="lg-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold">Device Allocation</legend>

                        <div class="form-group ">
                            <div class="row">
                                <label class="col-form-label col-sm-2 text-left">Company :</label>
                                    <div class="col-sm-10">
                                        <select id="company" name="company" data-placeholder="Select a Company..." class="form-control form-control-lg select" data-container-css-class="select-lg" data-fouc>
                                            <option></option>
                                            <?php
                                            foreach ($company as $row){
                                                ?>
                                                <option value="<?php echo $row->comp_id; ?>"> <?php echo $row->company; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <label class="col-form-label col-sm-2 text-left">Location : </label>
                                <div class="col-sm-10">
                                    <select id="location" name="location" data-placeholder="Select a State..." class="form-control form-control-lg select" data-container-css-class="select-lg" data-fouc>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <label class="col-form-label col-sm-2 text-left">Team : </label>
                                <div class="col-sm-10">
                                    <select id="team" name="team" data-placeholder="Select a State..." class="form-control form-control-lg select" data-container-css-class="select-lg" data-fouc>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <label class="col-form-label col-sm-2 text-left">Section : </label>
                                <div class="col-sm-10">
                                    <select id="section" name="section" data-placeholder="Select a Section..." class="form-control form-control-lg select" data-container-css-class="select-lg" data-fouc>
                                        <option value="" selected="selected"</option>
                                        <option value="Line Start" >Line Start</option>
                                        <option value="Line QC">Line QC</option>
                                        <option value="Line End">Line End</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                        <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-primary btn-block btn-lg">Submit  <i
                                            class="icon-circle-right2 ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <!-- /info blocks -->
        </div>
        <!-- /content area -->
        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2018 - <?php echo date('Y')?>. <a href="#">ProductM Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank"> OAIT</a>
					</span>

            </div>
        </div>
        <!-- /footer -->
    </div>
    <!-- /main content -->
</div>
<!-- /page content -->

</body>

<script>

    $('#company').change(function () {
        var comp_id = $('#company').val();
        var html = "<option value='' selected=\"selected\">&nbsp;</option>";
        if(comp_id != 0){
            $.ajax({
                url: '<?php echo base_url("Profile_App_Con/getLocations")?>',
                type: "POST",
                data: ({
                    comp_id:comp_id
                }),
                success: function(data){
                    var json_value = JSON.parse(data);
                    for(var i=0;i<json_value.length;i++){
                        html += "<option value='"+json_value[i]['location_id']+"'>"+json_value[i]['location']+"</option>";
                    }
                    $('#location').empty().append(html);
                }
            });
        }else{
            $('#location').empty().append(html);
        }

    });


    $('#location').change(function () {
        var comp_id = $('#company').val();
        var loca_id = $('#location').val();

        var html = "<option value='' selected=\"selected\">&nbsp;</option>";

        if(comp_id != 0 && loca_id != 0){
            $.ajax({
                url: '<?php echo base_url("Profile_App_Con/getTeams")?>',
                type: "POST",
                data: ({
                    comp_id:comp_id,
                    loca_id:loca_id
                }),
                success: function(data){
                    var json_value = JSON.parse(data);

                    for(var i=0;i<json_value.length;i++){
                        html += "<option value='"+json_value[i]['line_id']+"'>"+json_value[i]['line']+"</option>";
                    }
                    $('#team').empty().append(html);
                }
            });
        }

        $('#team').empty().append(html);

    });


</script>

</head>