<?php
require_once "Controller.php";
class Controller_home extends Controller{
    public function action_home(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
<<<<<<< HEAD
            header("Location: ?controller=home_former&action=home_former");
        }
        
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
=======
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }
        
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        }


        $this->render("home");

    }
    public function action_default(){
        $this->action_home();
    }
}
?>