<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_create_theme extends Controller{

    public function action_create_theme() {
        if (isset($_POST['submit'])) {
            $m = Model::getModel();
            $tab=checkTheme() ; 
            $m->createTheme($tab) ; 
            $data = [
                "themes"=>$m->seeThemes(),
                "categories"=>$m->seeCategories(),
            ];

    }
    $this->render('proposer_theme',$data) ; 
}
    public function action_default(){
        $this->action_create_theme();
    }
    
}