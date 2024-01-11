<?php
require_once "Controller.php";
class Controller_message extends Controller{
    public function action_message(){


        $this->render("MesMessages");

    }
    public function action_default(){
        $this->action_message();
    }
}
?>