<?php
require_once "Controller.php";
class Controller_choice extends Controller{
    public function action_register_choice(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
        
        $this->render("register_choice");

    }
    public function action_default(){
        $this->action_register_choice();
    }
}
?>