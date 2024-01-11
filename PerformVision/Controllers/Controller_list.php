<?php
require_once "Controller.php";
class Controller_list extends Controller{

    public function action_last(){
        
       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listCategories"=>$m->getCategories(),
            "formateurs"=>$m->getFormateurs(),
        ];
        $this->render("last", $data);
        
    }
    public function action_default(){
        $this->action_last();
    }
    public function action_list_categorieMere(){

        $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listCategories"=>$m->getCategories(),
            "formateurs"=>$m->getFormateurs(),
        ];
        $this->render("last", $data);
        
    }

}
?>