<?php
require_once "Controller.php";
class Controller_discussion_list extends Controller{
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




        
        $this->render("discussion_list_moderator",$data);

    }
    public function action_default(){
        $this->action_discussion_list();
    }

    




}
?>