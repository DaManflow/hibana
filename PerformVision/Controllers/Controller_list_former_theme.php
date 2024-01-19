<?php
require_once "Controller.php";
class Controller_list_former_theme extends Controller{
    public function action_list_former_theme(){


            
    
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
            'former_list' => $m->ListFormerTheme($_GET['id']),
        ];

        if (empty($data['former_list'])) {
            $data = [
                'title' => 'Message Page',
                'message' => "Il n'y a pas de formateurs associés à ce thème !"
            ];
            $this->render("message", $data);
        }

        
        $this->render("list_former_theme",$data);

    }



    public function action_default(){
        $this->action_list_former_theme();
    }
}
?>