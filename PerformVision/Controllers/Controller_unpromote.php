<?php
require_once "Controller.php";
class Controller_unpromote extends Controller{
    public function action_unpromote(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        $m = Model::getModel();

        $m->unpromote($_GET['start']);



        
        $this->render("member_choice_admin");

    }
    public function action_default(){
        $this->action_unpromote();
    }
}
?>