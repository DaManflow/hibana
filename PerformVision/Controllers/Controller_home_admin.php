<?php
require_once "Controller.php";
class Controller_home_admin extends Controller{
    public function action_home_admin(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_client&action=home_client");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }


        $this->render("home_admin");

    }
    public function action_default(){
        $this->action_home_admin();
    }
}
?>