<?php
require_once "Controller.php";
class Controller_choice extends Controller{
    public function action_register_choice(){
        $this->render("register_choice");

    }
    public function action_default(){
        $this->action_register_choice();
    }
}
?>