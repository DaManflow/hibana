<?php
require_once "Controller.php";
class Controller_logout extends Controller{
    public function action_logout(){

        $_SESSION = array();
        session_destroy();
        header("Location: ?controller=home&action=home");
        exit;

    }
    public function action_default(){
        $this->action_logout();
    }
}
?>