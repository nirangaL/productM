<?php

$serverName = "192.168.1.252";
$connectionInfo = array( "Database"=>"Accellar", "UID"=>"ProdM", "PWD"=>"Pro@#!1212" );
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ){
     die( print_r( sqlsrv_errors(), true));
}else{
  echo "connection success";
}

//Select Query
$tsql= "SELECT @@Version as SQL_VERSION";
//Executes the query
$getResults= sqlsrv_query($conn, $tsql);
//Error handling

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
?>
 <h1> Results : </h1>
<?php
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    echo ($row['SQL_VERSION']);
    echo ("<br/>");
}

sqlsrv_free_stmt($getResults);

$sql = "SELECT * FROM dbo.ProductM_sizecolourDeatils";
// $params = array(1, "some data");
$result = sqlsrv_query($conn,$sql);

if($result!= FALSE) {
  $pMConn = getProductMDbConn();

  // $turnCateTbl = "TRUNCATE TABLE `intranet_db`.`temp_accller_view`";
  // if (mysqli_query($pMConn, $turnCateTbl)) {
  //     echo "successfully truncate the table temp_accller_view "."<br>";
  // } else {
  //     echo "Error: ". "<br>" . mysqli_error($pMConn);
  // }



  while($row1 = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){

// print_r($row1);

    $id = $row1["UniqueID"];
    $buyer = $row1["Buyer"];
    $season = $row1["Season"];
    $style = $row1["Style"];
    $sc = $row1["SC"];
    $po = $row1["Delivery"];
    $color = $row1["Colour"];
    $delvDate = $row1["DeliveryDate"]->format('Y-m-d');
    $delvType = $row1["DeliveryType"];
    $orderQty = $row1["OrderQty"];
    $csrNo = $row1["CostsheetRefNo"];
    $size = $row1["Sizes"];
    $qty = $row1["Qty"];
    $merchant = $row1["Merchant"];

    if($qty != '0' && $qty != ''){
      $query ="INSERT IGNORE INTO intranet_db.temp_accller_view(
            `id`,
            `buyer`,
            `season`,
            `style`,
            `sc`,
            `po`,
            `color`,
            `delvDate`,
            `delvType`,
            `orderQty`,
            `csrNo`,
            `size`,
            `qty`,
            `merchant`
            )VALUES(
                '$id',
                '$buyer',
                '$season',
                '$style',
                '$sc',
                '$po',
                '$color',
                '$delvDate',
                '$delvType',
                '$orderQty',
                '$csrNo',
                '$size',
                '$qty',
                '$merchant')";

                if (mysqli_query($pMConn, $query)) {
                    echo "successfully saved!"."<br>";
                } else {
                    echo "Error: ". "<br>" . mysqli_error($pMConn);
                }
    }

  }

}else{
   die( print_r( sqlsrv_errors(), true));
}

function getProductMDbConn(){
  $servernameP = "192.168.1.211";
  $usernameP = "root";
  $passwordP = "20@Oa#15";
  $dbP = 'intranet_db';

  // Create connection
  $pmCon = mysqli_connect($servernameP, $usernameP, $passwordP, $dbP);
  // Check connection
  if (!$pmCon) {
      die("Connection failed: " . mysqli_connect_error());
  }

return $pmCon;

}

?>
