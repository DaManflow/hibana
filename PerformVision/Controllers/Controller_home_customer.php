<?php
require_once "Controller.php";
class Controller_home_customer extends Controller{
    public function action_home_customer(){


        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
<<<<<<< HEAD
            header("Location: ?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
=======
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        }

        $this->render("home_customer");

    }
    public function action_default(){
        $this->action_home_customer();
    }
}
?>