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

}
