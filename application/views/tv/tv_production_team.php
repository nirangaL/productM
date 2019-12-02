<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Team TV</title>

        <!-- Global stylesheets -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
        <!-- /global stylesheets -->

        <!--        Custom style sheet-->
        <link href="<?php echo base_url() ?>assets/css/productm/tv_production_style.css" rel="stylesheet" type="text/css">

        <!-- font  -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <!-- Core JS files -->
        <script src="<?php echo base_url() ?>assets/global_assets/js/main/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
        <!-- /core JS files -->

        <!-- Theme JS files -->
        <script src="<?php echo base_url() ?>assets/js/app.js"></script>

        <!-- /theme JS files -->


    </head>

    <body>
        <div id="totalTeam">
            <div class="row">
                <div class="table-responsive">
                    <table class="tbheader table table-striped table-dark bg-slate-600">
                        <thead>
                            <tr>
                                <th scope="col">Style</th>
                                <th scope="col">Delv/PO</th>
                                <th scope="col">Run.Days</th>
                                <th scope="col">Plan.QTY/H</th>
                                <th scope="col">Out.QTY/H</th>
                                <th id="th-short-exceed" scope="col">Short QTY/H</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tblBody">
                            <tr>
                                <td id="tb-style">-</td>
                                <td id="tb-delv">-</td>
                                <td id="tb-run-days">-</td>
                                <td id="tb-plan-qty-hr">-</td>
                                <td id="tb-out-qty-hr">-</td>
                                <td id="tb-short-exceed-qty">-</td>
                                <td id="status">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card tile">
                        <h1>Plan QTY</h1>
                        <span id="tile-plan-qty" class="value f-green">-</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card tile">
                        <h1>Out QTY</h1>
                        <span id="tile-out-qty" class="value f-green">-</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card tile">
                        <h1>Hour</h1>
                        <span id="tile-hour" class="value f-green">-</span>
                        <!-- <span id="tile-time-count" class="value f-white timecount">-</span> -->
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card tile">
                        <h1>Time Count Down</h1>
                        <span id="tile-time-count" class="value f-white timecount">-</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card tile">
                        <h1>Last Hour Qty</h1>
                        <span id="tile-last-hour-qty" class="value f-yellow ">-</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="clip">
                        <div class="card tile card__face front">
                            <h1>Target Efficiency</h1>
                            <span id="tile-target-effi" class="value f-yellow">-</span>
                        </div>
                        <div class="card tile card__face back">
                            <h1>Rework QTY</h1>
                            <span id="tile-rework-qty" class="value f-red">-</span>   
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="clip">
                        <div class="card tile card__face front">
                            <h1>Actual Efficiency</h1>
                            <span id="tile-actual-effi" class="value f-yellow">-</span>
                        </div>
                        <div class="card tile card__face back">
                            <h1>Remake QTY</h1>
                            <span id="tile-remake-qty" class="value f-red">-</span>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-3 ">
                    <div class="card tile">
                        <h1>QR Level</h1>
                        <span id="tile-qr-level" class="value f-green">-</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tile">
                        <h1>Incentive</h1>
                        <span id="tile-incentive" class="value f-blue">-</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<input type="hidden" id="getTeamDataUrl" value="<?php echo base_url("tv/Tv_Production_Con/getTeamData") ?>">

<!-- This hidden input for time count down -->
<input type="hidden" id="countDownHour">
<input type="hidden" id="timeForTimeCountDown">
<input type="hidden" id="startHour">
<!-- / End hidden input for time count down -->

<script src="<?php echo base_url() ?>/assets/js/productm/tv_production_team.js"></script>