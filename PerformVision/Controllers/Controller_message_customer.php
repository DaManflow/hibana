<?php
require_once "Controller.php";
class Controller_message_customer extends Controller{
    public function action_discussion() {

       

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }


        $this->render("discussion_customer");
    }
    public function action_default(){
        $this->action_discussion();
    }

    public function action_mes_discussions() {


        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }

        $m = Model::getModel();
        $data = [
            'list_discussions_formers' => $m->list_discussions_customers(),
            

        ];
        if (empty($data['list_discussions_formers'])) {

                $data = [
                    'title' => "Mes Dicussions",
                    'message' => "Vous n'avez pas encore de discussions !"
                    
        
                ];
                $this->render("empty_discussion_customer",$data);
        }

        else {
            $this->render("mes_discussions",$data);
        }
            
            
            
            
        }




        
    

    public function action_envoyer_message_customer() {

    
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }
    
        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("form_send_message_customer", $data);
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

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }
        
        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }


        if (isset($_POST['submit'])) {


        $m = Model::getModel();

        $tab = data_message_customer();

        if ($tab['message'] == 'false') {
            echo "Le msg est vide !";
            $this->render("form_send_message_customer");
            
        }

        $rep = $m->add_discussion_message_customer($tab);

        if (in_array("none",$rep)) {

             header("Location: ?controller=message_customer&action=dicussion");
             exit;
             
         }
         else {

             if (in_array("error_db",$rep)) {
                 echo "La transaction à été annulée";
                 $this->render("form_send_message_customer");
             }



        }

        }
        else {
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
                header("Location: ?controller=home_customer&action=home_customer");
            }

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
                header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
            }
        
            if (!isset($_SESSION['idutilisateur'])) {
                header("Location: /hibana-main/PerformVision/?controller=home&action=home");
            }

        }






    }


    public function action_list_messages_customer() {

        

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=home&action=home");
        }





        $m = Model::getModel();
        $data = [
            'messages' => $m->list_messages_customers($_GET['id']),
        ];




        if (empty($data['messages'])) {

            $data = [
                'title' => "Liste messages",
                'message' => "La modération n'a pas encore validé vos messages !",
            ];

            $this->render("message", $data);

        }
            
        else {
            $this->render("mes_messages_customer", $data);
        }    

        




    }

}
?>