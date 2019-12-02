<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MTV</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()?>assets/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url()?>assets/global_assets/js/main/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/global_assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <!-- /theme JS files -->
<style>
    th, td{
        text-align: center;
    }
    /*#tblBody tr{*/
        /*line-height: 50px;*/
    /*}*/
    #tblBody tr>td{
        font-size: 18px;
        font-weight: bold;
    }
</style>

</head>

<body style="background-color: black;">

<div class="card">
    <div class="row">
        <div class="table-responsive">
        <table class="table table-striped table-dark bg-slate-600">
            <thead>
            <tr style="background-color: #e74c3c;font-size: 20px; color: white;">
                <th scope="col">Team</th>
                <th scope="col">Style</th>
                <th scope="col">Delv/PO</th>
                <th scope="col">Run.Days</th>
                <th scope="col">Pln.Qty</th>
                <th scope="col">Out.Qty</th>
                <th scope="col">Pln.Eff.%</th>
                <th scope="col">Effi.%</th>
                <th scope="col">QR.Lvl.%</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody id="tblBody">

            </tbody>
        </table>
    </div>
    </div>
</div>
</body>
</html>

<script>

    $(document).ready(function () {
        getTvData();
    });

    window.setInterval(function () {
        getTvData();
    }, 10000);

    function getTvData() {
        $.ajax({
            url:'<?php echo base_url('tv/Tv_Manager_Con/getTvData')?>',
            type:'POST',
            data:({}),
            success:function (data) {
                var json_value = JSON.parse(data);
                var teamsSize = json_value['tvData'].length;
                var maxRows = 15;
                $('#tblBody').empty();

                for(var i=0;i<teamsSize;i++){
                    var team = json_value['team'][i];
                    var style = '-';
                    var delv = '-';
                    var runDay = '-';
                    var pQty = '-';
                    var aQty = '-';
                    var pEffi = '-';
                    var effi = '-';
                    var qrL = '-';
                    var status = '-';
                    var neededQtyAtTime = '-';

                    if(json_value['tvData'][i] != null){

                        // alert(json_value['tvData'][i]['gridData']['lineName']);
                         team = json_value['tvData'][i]['gridData']['lineName'];
                         style = json_value['tvData'][i]['gridData']['style'];
                         delv = json_value['tvData'][i]['gridData']['delivery'];
                         runDay = json_value['tvData'][i]['gridData']['styleRunDatys'];
                         pQty = json_value['tvData'][i]['gridData']['dayPlanQty'];
                         aQty = json_value['tvData'][i]['gridData']['lineOutQty'];
                         pEffi = json_value['tvData'][i]['gridData']['ForEff'];
                         effi = json_value['tvData'][i]['gridData']['actEff'];
                         qrL = json_value['tvData'][i]['gridData']['actualQrLevel'];
                         status = json_value['tvData'][i]['gridData']['status'];
                        neededQtyAtTime = json_value['tvData'][i]['gridData']['neededQtyAtTime'];

                    }


                    var html = "<tr>";
                    html += "<td>" + team + "</td>";
                    html += "<td>" + style + "</td>";
                    html += "<td>" + delv + "</td>";
                    html += "<td>" + runDay + "</td>";
                    html += "<td>" + pQty + "</td>";

                    if(neededQtyAtTime != '-'){
                        html += "<td>" + aQty + " / "+ neededQtyAtTime +"</td>";
                    }else{
                        html += "<td>" + '-' +"</td>";
                    }
                    html += "<td>" + pEffi + "</td>";
                    html += "<td>" + effi + "</td>";
                    html += "<td>" + qrL + "</td>";

                    if ( status == 'up') {
                        html += "<td>" + "<i class='icon-arrow-up16' style='color:#1de9b6;font-size: 30px;'></i>" + "</td>";

                    } else if (status == 'down') {
                        html += "<td>" + "<i class='icon-arrow-down16' style='color:#ff5252;font-size: 30px;'></i>" + "</td>";
                    } else {
                        html += "<td>" + '-' + "</td>";
                    }
                    html += "</tr>";
                    $('#tblBody').append(html);
                }

                for(var i=teamsSize;i<=maxRows;i++){
                    var html = "<tr>";
                        html += "<td>" + '&nbsp;' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                        html += "<td>" + '' + "</td>";
                    html += "</tr>";

                    $('#tblBody').append(html);
                }
            }
        });
    }

</script>