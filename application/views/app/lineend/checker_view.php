<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Checker App</title>

  <!-- Global stylesheets -->
  <link href="<?php echo base_url() ?>assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url()?>assets/global_assets/select2-4.0.11/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>assets/css/productm/line_end_app.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url()?>assets/css/loader.css" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->
  <link href="<?php echo base_url()?>assets/global_assets/notiflix-1.9.1/minified/notiflix-1.9.1.min.css" rel="stylesheet" type="text/css">


  <script src="<?php echo base_url() ?>assets/global_assets/js/main/jquery.min.js"></script>
  <script src="<?php echo base_url()?>assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
  <!-- Core JS files -->
  <script src="<?php echo base_url() ?>assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/select2-4.0.11/dist/js/select2.full.min.js"></script>

    <script src="<?php echo base_url() ?>assets/global_assets/notiflix-1.9.1/minified/notiflix-1.9.1.min.js"></script>

    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/productm/line_end_app.js"></script>
  <!-- <script src="<?php echo base_url()?>assets/js/app.js"></script> -->
  <!-- /core JS files -->
</head>
<body class="sidebar-xs navbar-top">

  <!-- Main navbar -->
  <div class="navbar navbar-expand-md fixed-top navbar-dark">
    <form class="form-inline">
      <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#style-config-modal" style="top:-5px">CONFIG THE STYLE</button>
    </form>

    <div class="d-md-none">
    
			<span class="item-title">TEAM : </span><span id="item-team" class="item-name"><?php echo $team[0]->line;?></span>
		
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
        <i class="icon-paragraph-justify3"></i>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
      <ul class="navbar-nav">
        <li class="nav-item">
          <div class="navbar-text ml-md-3 mr-md-auto item-des">
				        <span class="item-title">STYLE : </span><span id="item-style" class="item-name"></span>
			    </div>
        </li>
        <li class="nav-item">
          <div class="navbar-text ml-md-3 mr-md-auto item-des">
				        <span class="item-title">DELV : </span><span id="item-delivery" class="item-name"></span>
			    </div>
        </li>

        <li class="nav-item">
          <div class="navbar-text ml-md-3 mr-md-auto item-des">
				        <span class="item-title">COLOR : </span><span id="item-color" class="item-name"></span>
			    </div>
        </li>
        <li class="nav-item">
          <div class="navbar-text ml-md-3 mr-md-auto item-des">
				        <span class="item-title">TEAM : </span><span id="item-team" class="item-name"><?php echo $team[0]->line;?></span>
			    </div>
        </li>
      </ul>
    </div>
  </div>
  <!-- /main navbar -->
  <!-- Size Panal -->
  <!-- <div class="row"> -->
    <div class="size-panal">
      <h1>Config the style first</h1>
    </div>
  <!-- </div> -->
  <!--/ Size Panal -->

<!-- pass, reject buttons -->

  <div class="row ">

    <div class="col-sm-6 ">
      <button id="btn-pass" class="btn-box bg-success" data-btn="pass" onclick="btnPress(this)">
      <h2 class="btn-title">PASS</h2>
      <div class="btn-center">
        <span class="count">0</span>
        </br>
        <i class="icon-thumbs-up2"></i>
      </div>
      </button>
    </div>

    <div class="col-sm-6">
      <button id="btn-defect" class="btn-box bg-danger" data-toggle="modal" data-target="#defect-reasons-model" onclick="getFrequentDefectReason()">
        <h2 class="btn-title">DEFECT</h2>
        <div class="btn-center">
          <span class="count">0</span>
          </br>
            <i class="icon-thumbs-down2"></i>
        </div>
      </button>
    </div>
  </div>

  <div class="row">

    <div class="col-sm-6 ">
      <button id="btn-remake" class="btn-box bg-info" data-btn="remake" onclick="btnPress(this)">
        <h2 class="btn-title">REMAKE</h2>
        <div class="btn-center">
          <span class="count">0</span>
          </br>
          <i class="icon-checkmark-circle2"></i>
        </div>
      </button>
    </div>

    <div class="col-sm-6">
      <div id="log" class="savelogDisplay">
        
      </div>
    </div>

    <!-- <div class="col-sm-3">
      <div class="btn-box">
      </div>
    </div> -->

  </div>

<!--/ pass, reject buttons -->


  <!-- /style-config-modal -->
  <div id="style-config-modal" class="modal fade" data-backdrop="false"  tabindex="-1" aria-hidden="true">
    <!-- modal-dialog-centered to center the modal -->
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header bg-dark text-center">
          <h6 class="modal-title model-head">CONFIG THE STYLE</h6>
        </div>

        <div class="modal-body text-center">
          <div class="form-horizontal">
								<div class="modal-body"  style="overflow:hidden;">
                  <!-- <?php print_r($style);?> -->
                  <!-- <form id="config-style"> -->
									<div class="form-group row">
										<label class="col-form-label col-sm-2 label">Style : </label>
										<div class="col-sm-10">
                      <select id="style" onchange="getDelv()" data-placeholder="Select a Style..." class="form-control form-control-lg select" data-container-css-class="select-lg" style="width:100%" data-fouc>
                        <option></option>
                        <?php foreach ($style as $row) {
                          ?>
                          <option value="<?php echo $row->style?>"> <?php echo  $row->style.' - '.$row->scNumber ?></option>

                          <?php
                        }?>
  									</select>
                    <span id="style-error" class="style-config-error"></span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-form-label col-sm-2 label">Delivery : </label>
										<div class="col-sm-10">
                      <select id="delivery" onchange="getColor()" data-placeholder="Select a Delivery" class="form-control form-control-lg select"  style="width:100%;height:50%;"  data-container-css-class="select-lg" disabled>
                        <option></option>
									    </select>
                      <span id="delivery-error" class="style-config-error"></span>
										</div>
									</div>
                  <div class="form-group row">
										<label class="col-form-label col-sm-2 label">Color : </label>
										<div class="col-sm-10">
                      <select id="color" data-placeholder="Select a Color" class="form-control select-nonsearch" onchange="getSize()"  style="width:100%" data-container-css-class="select-lg" disabled>
										  <option></option>
									    </select>
                      <span id="color-error" class="style-config-error"></span>
										</div>
                  </div>
                  <!-- </form> -->
              </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-lg btn-default" onclick="clearSelect()" data-dismiss="modal">Clear & Close</button>
          <button type="submit" class="btn btn-lg bg-dark" onclick="configStyle()">Configed</button>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- /style-config-modal -->

  <!-- /style-config-modal -->
  <div id="defect-reasons-model" class="modal fade" data-backdrop="false"  tabindex="-1" aria-hidden="true">
    <!-- modal-dialog-centered to center the modal -->
    <div class="modal-dialog modal-full">
      <div class="modal-content">
        <div class="modal-header bg-danger text-center">
          <h6 class="modal-title model-head">DEFECT REASON</h6>
        </div>
        <div class="modal-body modal-cus">
          <div class="frequentReasons">
            <span class="title">frequent reasons</span>
            <hr>
            <div id="frequentReason" class="row">
             
            </div>
          </div>
          <div class="frequentReasons" style="margin-top:2%">
            <span class="title">All Reasons</span>
            <hr>
            <div class="row">
              <?php 
                foreach($defectReason as $reason){
                  echo "<div class='col-sm-6'>";
                  echo "<div class='defect-reason' data-defectid = ".$reason->id." onclick='selectDefectReason(this)'>";
                  echo "<span>".$reason->rejectReason."</span>";
                  echo "</div>";
                  echo "</div>";
                }   
              ?>
            </div>
          </div>
          </div>
        <div class="modal-footer" style="margin-top:2%;">
          <button type="button" class="btn btn-lg btn-default" onclick="" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-lg bg-dark" onclick="btnPress(this)" data-btn="defect">Ok</button>
        </div>
  </div>
</div>
  <!-- /style-config-modal -->


</body>
</html>
<input type="hidden" id="scNumber" value="">
<input type="hidden" id="selectSize" value="">
<input type="hidden" id="selectDefectReason" value="">
<input type="hidden" id="getDelvLink" value="<?php echo base_url('app/lineend/Checker_Con/getDelivery');?>">
<input type="hidden" id="getColorLink" value="<?php echo base_url('app/lineend/Checker_Con/getColor');?>">
<input type="hidden" id="getCountFromLogUrl" value="<?php echo base_url('app/lineend/Checker_Con/getCountFormLog');?>">
<input type="hidden" id="getSizeLink" value="<?php echo base_url('app/lineend/Checker_Con/getSize');?>">
<input type="hidden" id="getFrequentDefectReasonUrl" value="<?php echo base_url('app/lineend/Checker_Con/getFrequentDefectReason');?>">
<input type="hidden" id="saveBtnPressUrl" value="<?php echo base_url('app/lineend/Checker_Con/insertData');?>">
