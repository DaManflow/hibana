<?php
require_once "Controller.php";
class Controller_profil_former extends Controller{
    public function action_profil_former(){
        $this->render("profil_former");

    }
    public function action_default(){
        $this->action_profil_former();
    }
}
?>