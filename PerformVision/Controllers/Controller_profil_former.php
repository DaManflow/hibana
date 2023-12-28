<?php
require_once "Controller.php";
class Controller_profil_former extends Controller{
    public function action_profil_former(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
<<<<<<< HEAD
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
=======
            header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        }



        $this->render("profil_former");

    }
    public function action_default(){
        $this->action_profil_former();
    }
}
?>