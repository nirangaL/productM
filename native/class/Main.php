<?php

class Main {

    public $sesLocation = '2';

    function __construct() {
        if(isset($_SESSION['session_user_data'])){
            $this->sesLocation  = $_SESSION['session_user_data']['location'];
        
        }else{

            header("Location: http://192.168.1.211");
        }


    }

}