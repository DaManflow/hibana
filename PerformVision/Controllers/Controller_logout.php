<?php
require_once "Controller.php";
class Controller_logout extends Controller{
    public function action_logout(){

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }


        $_SESSION = array();
        session_destroy();
        header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        exit;

    }
    public function action_default(){
        $this->action_logout();
    }
}
?>