<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_test extends Controller{

    public function action_test() {
        $m = Model::getModel();
        $m->test();

        $this->render("test");

    }

    public function action_default(){
        $this->action_test();
    }


    public function action_affichage() {
        
    }

    
            
        

        

    

    
    
}
?>