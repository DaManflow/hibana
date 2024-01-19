<?php
require_once "Controller.php";
class Controller_discussion_list extends Controller{

    // Renvoi vers la page de discussion en fonction du role
    public function action_discussion_list(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        $m = Model::getModel();

        $data =[
            'discussion_list' => $m->discussionList(),
        ];

        if (empty($data['discussion_list'])) {
            $data = [
                'title' => 'Message Page',
                'message' => "Il n'y a pas encore de discussion à modérer !"
            ];
            $this->render("message", $data);
        }




        
        $this->render("discussion_list_moderator",$data);

    }
    public function action_default(){
        $this->action_discussion_list();
    }

    




}
?>
