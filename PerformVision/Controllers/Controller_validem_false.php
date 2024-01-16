<?php
require_once "Controller.php";
class Controller_validem_false extends Controller{
    public function action_validem_false(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        $m = Model::getModel();

        $m->validemFalse($_GET['id']);


        $data =[
            'discussion_list' => $m->discussionList(),
        ];


        
        $this->render("discussion_list_moderator",$data);

    }
    public function action_default(){
        $this->action_validem_false();
    }
}
?>