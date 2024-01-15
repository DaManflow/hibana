<?php
require_once "Controller.php";
class Controller_home_moderator extends Controller{
    public function action_home_moderator(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_client&action=home_client");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }


        $this->render("home_moderator");

    }
    public function action_default(){
        $this->action_home_moderator();
    }
}
?>