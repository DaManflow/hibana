<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_register_customer extends Controller{

    public function action_form_register_customer() {
 
        $this->render("form_register_customer");
    }

    public function action_default(){
        $this->action_form_register_customer();
    }

    public function action_register_customer(){
        if (isset($_POST['submit'])) {
            $m = Model::getModel();
            $tab = check_data_customer();

            if (count($tab)<3) {
                $data = [
                    'title' => 'Message d\'erreur',
                    'message' => strval($tab[1])
                ];
                $this->render("message", $data);
            }
            
            if ($m->createCustomer($tab)) {
                
            }
            else {
                $data = [
                    'title' => 'Erreur',
                    'message' => 'Identifiant déjà pris !'
                ];
                $this->render("message", $data);
            }
            
        }

        

    }
    
}
?>