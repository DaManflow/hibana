<?php
require_once "Controller.php";
class Controller_validem_true extends Controller{
    public function action_validem_true(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        $m = Model::getModel();

        $m->validemTrue($_GET['id']);

        $data =[
            'discussion_list' => $m->discussionList(),
        ];


        
        $this->render("discussion_list_moderator",$data);

    }
    public function action_default(){
        $this->action_validem_true();
    }
}
?>