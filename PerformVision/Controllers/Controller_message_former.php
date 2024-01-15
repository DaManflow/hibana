<?php
require_once "Controller.php";
class Controller_message_former extends Controller{
    public function action_mes_discussions() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }



        $m = Model::getModel();
        $data = [
            'list_discussions_customers' => $m->list_discussions_formers(),
            

        ];

        if (empty($data['list_discussions_customers'])) {

            $data = [
                'title' => "Mes Dicussions",
                'message' => "Vous n'avez pas encore de discussions !"
                
    
            ];
            $this->render("message",$data);
            
           
            
        }
        else {
            $this->render("mes_discussions",$data);
        }
    }
    
    public function action_default(){
        $this->action_mes_discussions();
    }

    public function action_send_message() {


        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }

        if (isset($_POST['submit'])) {

        $m = Model::getModel();

        $tab = data_message_former();

        if ($tab['message'] == 'false') {
            echo "Le msg est vide !";
            $this->render("form_send_message_former");
            
        }

        $rep = $m->add_discussion_message_former($tab);

        if (in_array("none",$rep)) {

             header("Location: ?controller=message_former&action=mes_discussions");
             exit;
             
         }
         else {

             if (in_array("error_db",$rep)) {
                 echo "La transaction à été annulée";
                 $this->render("form_send_message_former");
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
    
    public function action_list_messages_former() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }



        $m = Model::getModel();
        $data = [
            'messages' => $m->list_messages_formers($_GET['id']),
        ];
        if (empty($data['messages'])) {
            

                $data = [
                    'title' => "Liste messages",
                    'message' => "La modération n'a pas encore validé vos messages !",
                ];
    
                $this->render("message", $data);
    
            }
        else {
            $this->render("mes_messages_former", $data);
        }
            

        




    }
}

?>