<!DOCTYPE html>
<html lang="en">
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
    <link href="<?php echo base_url()?>assets/global_assets/css/toastr/toastr.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/jquery-timepicker/jquery.timepicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/loader.css" rel="stylesheet" type="text/css">
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


    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/form_checkboxes_radios.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/datatables_basic.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/form_select2.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/notifications/bootbox.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/jquery-timepicker/jquery.timepicker.min.js"></script>
    <!-- /theme JS files -->

    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<!--    <script src="--><?php //echo base_url()?><!--assets/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>-->
<!--    <script src="--><?php //echo base_url()?><!--assets/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>-->
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/datatables_extension_buttons_html5.js"></script>


    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/daterangepicker.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/anytime.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/pickadate/picker.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/picker_date.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>

    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/demo_pages/form_input_groups.js"></script>


    <style>
        .error{
            color: red;
            font-weight: bold;
        }

        .table > thead{
            background-color: #263238;
            color: azure;
        }
        .content {
            padding: 0.25rem 0.25rem;!importent;
            -ms-flex-positive: 1;
            flex-grow: 1;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
          margin-bottom: -0.375rem;!importent;
        }

    </style>


</head>

<body>

<!-- Main navbar -->
<!--
<div class="navbar navbar-expand-md navbar-dark fixed-top">
    <div class="navbar-brand">
        <a href="index.html" class="d-inline-block">
            <img src="<?php// echo base_url()?>assets/global_assets/images/logo_light.png" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>
    </div>
</div> -->

<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">
