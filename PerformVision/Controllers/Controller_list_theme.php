<?php
require_once "Controller.php";
class Controller_list_theme extends Controller{
    public function action_list_theme(){

        

        $m = Model::getModel();

        

        $data = [
            'list_themes' => $m->seeThemes(),
        ];

        
        $this->render("list_themes",$data);

    }
    public function action_default(){
        $this->action_list_theme();
    }
}
?>