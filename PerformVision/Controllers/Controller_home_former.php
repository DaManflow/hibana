<?php
require_once "Controller.php";
class Controller_home_former extends Controller{
    public function action_home_former(){
        $m = Model::getModel();
        $data = [
            
        ];
        $this->render("home_former", $data);

    }
    public function action_default(){
        $this->action_home_former();
    }
}
?>