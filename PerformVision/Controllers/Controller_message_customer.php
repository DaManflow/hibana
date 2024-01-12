<?php
require_once "Controller.php";
class Controller_message_customer extends Controller{
    public function action_discussion() {
        $this->render("discussion_customer");
    }
    public function action_default(){
        $this->action_discussion();
    }

    public function action_mes_messages() {
        $this->render("mes_messages");
    }

    public function action_envoyer_message_customer() {
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_formateur&action=home_formateur");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("form_send_message", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }
    }

    public function action_send_message() {

        $m = Model::getModel();

        $tab = data_message();

        if ($tab['message'] == 'false') {
            echo "Le msg est vide !";
            $this->render("form_send_message");
            
        }

        $rep = $m->add_discussion($tab);

        if (in_array("none",$rep)) {

             header("Location: ?controller=message_customer&action=mes_messages");
             exit;
             
         }
         else {

             if (in_array("error_db",$rep)) {
                 echo "La transaction à été annulée";
                 $this->render("form_register_former");
             }



        }
    }

}
?>