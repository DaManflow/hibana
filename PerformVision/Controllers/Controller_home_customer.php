<?php
require_once "Controller.php";
class Controller_home_customer extends Controller{
    public function action_home_customer(){


        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }

        $this->render("home_customer");

    }
    public function action_default(){
        $this->action_home_customer();
    }
}
?>