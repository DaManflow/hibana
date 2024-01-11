<?php
require_once "Controller.php";
class Controller_register_redirection extends Controller{
    public function action_register_redirection(){

        $this->render("form_register_former_2");

    }
    public function action_default(){
        $this->action_register_redirection();
    }
}
?>