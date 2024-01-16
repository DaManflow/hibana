<?php
require_once "Controller.php";
class Controller_home extends Controller{
    public function action_home(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
        
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
            header("Location: ?controller=home_admin&action=home_admin");
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
            header("Location: ?controller=home_moderator&action=home_moderator");
        }


        $this->render("home");

    }
    public function action_default(){
        $this->action_home();
    }
}
?>