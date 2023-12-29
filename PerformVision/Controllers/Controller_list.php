<?php
require_once "Controller.php";
class Controller_list extends Controller{

    public function action_last(){
        
       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(null),
            "listCategories"=>$m->getCategories()
        ];
        $this->render("last", $data);
        
    }
    public function action_default(){
        $this->action_last();
    }

    public function action_test(){
        $this->render("TEST_LAST", ["e"=>"1-1", "Mais"=>"2+2"]);
    }
}
?>