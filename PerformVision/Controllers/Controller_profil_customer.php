<?php
require_once "Controller.php";
class Controller_profil_customer extends Controller{
    public function action_profil_customer(){
        $this->render("profil_customer");

    }
    public function action_default(){
        $this->action_profil_customer();
    }
}
?>