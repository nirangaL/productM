<?php
/**
 * Created by PhpStorm.
 * User: nirangal
 * Date: 01/21/2019
 * Time: 10:12 AM
 */
 // 
 // error_reporting(-1);
 // ini_set('display_errors', 1);
class MY_Controller extends CI_Controller{

    public $myConUserName;
    public $myConName;
    public $myConLocation;
    public $MyConUserGroup;

    function __construct(){
        parent::__construct();

        $this->load->helper('cookie');

        if(isset($_SESSION['session_user_data'])){
            $this->myConUserName  = $_SESSION['session_user_data']['userName'];
            $this->myConName  = $_SESSION['session_user_data']['name'];
            $this->myConlocation  = $_SESSION['session_user_data']['location'];
            $this->MyConUserGroup  = $_SESSION['session_user_data']['userGroup'];
        }
        $this->gamaSysDb = $this->load->database('gamasys',TRUE);
        $this->saveStyleDataFrmGamaSysDb();
    }

    public function checkSession(){
        $this->load->library('session');
        if (!$this->session->userdata('session_user_data')) {
            if ($_SERVER['REQUEST_METHOD'] == "GET" OR empty($_SERVER['REQUEST_METHOD'])) {
                $_SESSION['new'] = current_url();
            }
            redirect(base_url('Welcome'));
        }
    }

    public function checkCookies(){

        $company = get_cookie('company');
        $location = get_cookie('location');
        $team = get_cookie('line');
        $lineSection = get_cookie('lineSection');

        if ($company == '' || $location == '' || $team == '' || $lineSection == '') {
            redirect(base_url("Profile_App_Con"), 'refresh');
        }
    }

    public function saveStyleDataFrmGamaSysDb(){

        /// get last insertRow's date ////////
        $lastTimeUpdateDate = $this->getLastUpdateDate();

        $result = $this->gamaSysDb->query("SELECT `styleNo`,scNumber,deliveryNo,garmentColour,`size`,orderQty,recorded_datetime,deliveryType,qty FROM `temp_exela_order_details` WHERE recorded_datetime > '$lastTimeUpdateDate' AND qty !='0' ORDER BY recorded_datetime DESC LIMIT 500")->result();

        foreach ($result as $row){

            $sql = "INSERT INTO style_Info (scNumber,styleNo,deliveryNo,deliveryType,garmentColour,orderQty,size,qty,cut_Plan_Date) VALUES ('$row->scNumber','$row->styleNo','$row->deliveryNo','$row->deliveryType','$row->garmentColour','$row->orderQty','$row->size','$row->qty','$row->recorded_datetime')";
            $this->db->query($sql);
        }
    }

    public function getLastUpdateDate(){
        $result =  $this->db->query("SELECT `cut_Plan_Date` FROM `style_Info` WHERE id = (SELECT MAX(id) FROM `style_Info`)")->result();

        if(!empty($result)){
            return $result[0]->cut_Plan_Date;
        }else{
            // return date('Y-m-d H:i:s',strtotime("-1 days"));
            $format = 'Y-m-d H:i:s';
            $date = DateTime::createFromFormat($format, '2000-01-01 00:00:00');
            return $date->format('Y-m-d H:i:s');
        }
    }

}
