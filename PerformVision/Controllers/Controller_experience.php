<?php
require_once "Controller.php";
class Controller_experience extends Controller {
    public function action_see_all(){
        $m = Model::getModel();
        $data = [
            "themes"=>$m->seeThemes(),
            "sousCategories"=>$m->seeSousCategories(),
            "categories"=>$m->seeCategories(),

        ];
        $this->render("form_register_former", $data);
    }
}
?>