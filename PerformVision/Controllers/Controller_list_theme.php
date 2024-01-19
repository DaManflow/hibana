<?php
require_once "Controller.php";
class Controller_list_theme extends Controller{
    public function action_list_theme(){


            
    
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
                header("Location: ?controller=home_former&action=home_former");
            }

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
                header("Location: ?controller=home_admin&action=home_admin");
            }
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
                header("Location: ?controller=home_moderator&action=home_moderator");
            }
        

        $m = Model::getModel();

        

        $data = [
            'list_themes' => $m->seeThemes(),
        ];

        
        $this->render("list_themes",$data);

    }

    public function action_list_theme_customer(){


            
    
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
            header("Location: ?controller=home_admin&action=home_admin");
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
            header("Location: ?controller=home_moderator&action=home_moderator");
        }
        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }
    

    $m = Model::getModel();

    

    $data = [
        'list_themes' => $m->seeThemes(),
    ];

    
    $this->render("list_themes_customer",$data);

}



    public function action_default(){
        $this->action_list_theme();
    }
}
?>