<?php
require_once "Controller.php";
class Controller_profil_former extends Controller{
    public function action_profil_former(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: /SAES301/hibana/PerformVision/?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /SAES301/hibana/PerformVision/?controller=home&action=home");
        }



        $this->render("profil_former");

    }
    public function action_default(){
        $this->action_profil_former();
    }
}
?>