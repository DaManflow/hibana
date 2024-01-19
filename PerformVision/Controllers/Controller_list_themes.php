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
            "themesNonValides"=>$m->seeThemesNonValides(),
        ];

        if (empty($data['themesValides'])) {
            $data = [
                        'title' => 'Message Page',
                        'message' => "Il n'y pas de thèmes validé !"
                    ];
                    $this->render("message", $data);
                }


        $this->render("themes_valides", $data);
    }
    public function action_themes_non_valides(){
        $m = Model::getModel();
        $data = [
            "themesNonValides"=>$m->seeThemesNonValides(),
            "themesNonValides"=>$m->seeThemesNonValides(),
        ];

        if (empty($data['themesNonValides'])) {
                $data = [
                            'title' => 'Message Page',
                            'message' => "Il n'y pas de thèmes non-validé !"
                        ];
                        $this->render("message", $data);
                    }

        $this->render("themes_non_valides", $data);
        }
        


        
    
    public function action_valider_theme(){
        $m = Model::getModel();
        $m->UpdateTheme();
        
        $this->render("button_themes");
    }   
    public function action_supprimer_theme(){
        $m = Model::getModel();
        $m->DeleteTheme();
        
        $this->render("button_themes");
        
    }      
    public function action_default(){
        $this->action_list_themes();
    }
}