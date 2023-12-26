<?php
require_once "Controller.php";
class Controller_home extends Controller{
    public function action_home(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
        }
        
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: /SAES301/hibana/PerformVision/?controller=home_customer&action=home_customer");
        }


        $this->render("home");

    }
    public function action_default(){
        $this->action_home();
    }
}
?>