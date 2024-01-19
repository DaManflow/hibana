<?php
require_once "Controller.php";
class Controller_advices extends Controller{
    public function action_advices(){

        $this->render("advices");

    }
    public function action_default(){
        $this->action_advices();
    }
}
?>