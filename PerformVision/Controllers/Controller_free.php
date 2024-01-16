<?php
require_once "Controller.php";
class Controller_free extends Controller{
    public function action_free(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        $m = Model::getModel();

        $m->free($_GET['start']);



        
        $this->render("member_choice_moderator");

    }
    public function action_default(){
        $this->action_free();
    }
}
?>