<?php
require_once "Controller.php";
class Controller_home_customer extends Controller{
    public function action_home_customer(){
        $m = Model::getModel();
        $data = [
            
        ];
        $this->render("home_customer", $data);

    }
    public function action_default(){
        $this->action_home_customer();
    }
}
?>