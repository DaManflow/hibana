<?php
require_once "Controller.php";
class Controller_home extends Controller{
    public function action_home(){
        $m = Model::getModel();
        $m->createUser();

    }
    public function action_default(){
        $this->action_home();
    }
}
?>