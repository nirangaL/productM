<!DOCTYPE html>
<html>
    <head>
        <title>OA Dowanloads</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            .wrapper{
                display: flex;
                flex-wrap: wrap;
              
            }

            .icon{
                cursor: pointer;
                width:250px;
                height: 250px;
                max-width: 250px;
                max-height: 250px;
                
                margin: 20px;
                border:1px solid gray;
                /* background: royalblue; */
            }
            .icon img{
                background-repeat: no-repeat;
                width:250px;
                height: 250px;  
                object-fit: contain; 
            }
            .name{
                text-align: center;
                font-family: Arial, Helvetica, sans-serif;
                color: #34495e;
                font-weight: bold;
                font-size: 18px;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="icon"> 
                <a href="<?php echo base_url('downloads/OA Line In App.apk');?>" download>
                    <img src="<?php echo base_url('assets/images/icons/basket_icon.png')?>" alt="OA QC App">
                </a>
                <div class="name">OA Line In App v2</div> 
            </div>

            <div class="icon"> 
            <a href="<?php echo base_url('downloads/OA QC APP.apk');?>" download>
                    <img src="<?php echo base_url('assets/images/icons/oa_qc_app.png')?>" alt="OA QC App">
                </a>
                <div class="name">OA QC App v2</div> 
            </div>
        </div>
       
    </body>
</html>
