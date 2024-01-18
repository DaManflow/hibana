<?php
require_once "Controller.php";
class Controller_list_themes extends Controller{
    public function action_list_themes() {
        $this->render("button_themes");
    }
    public function action_themes_valides(){
        $m = Model::getModel();
        $data = [
            "themesValides"=>$m->seeThemesValides(),
        ];
        $this->render("themes_valides", $data);
    }
    public function action_themes_non_valides(){
        $m = Model::getModel();
        $data = [
            "themesNonValides"=>$m->seeThemesNonValides(),
        ];
        $this->render("themes_non_valides", $data);
    }
    public function action_default(){
        $this->action_list_themes();
    }
}