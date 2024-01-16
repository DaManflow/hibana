<?php
require_once "Controller.php";
class Controller_proposer_theme extends Controller{
    public function action_proposer_theme() {
        $m = Model::getModel();
        $data = [
            "themes"=>$m->seeThemes(),
            "categories"=>$m->seeCategories(),
        ];
            $this->render("proposer_theme", $data);
        }
        public function action_default(){
            $this->action_proposer_theme();
        }
    }

?>