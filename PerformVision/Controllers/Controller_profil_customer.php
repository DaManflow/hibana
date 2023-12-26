<?php
require_once "Controller.php";
class Controller_profil_customer extends Controller{
    public function action_profil_customer(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /SAES301/hibana/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /SAES301/hibana/PerformVision/?controller=home&action=home");
        }



        $this->render("profil_customer");

    }
    public function action_default(){
        $this->action_profil_customer();
    }
}
?>