<?php
require_once "Controller.php";
class Controller_choice extends Controller{
    public function action_register_choice(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
<<<<<<< HEAD
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
=======
            header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        }
        
        $this->render("register_choice");

    }
    public function action_default(){
        $this->action_register_choice();
    }
}
?>