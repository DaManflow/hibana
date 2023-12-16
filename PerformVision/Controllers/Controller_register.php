<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_register extends Controller{

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

            if (! $tab) {
                $data = [
                    'title' => 'Message Page',
                    'message' => 'Un champ a mal été rempli !'
                ];
                $this->render("message", $data);
            }
            
            if ($m->createCustomer($tab)) {
                header("Location: ?");
                $this->render("home");
            }
            else {
                $data = [
                    'title' => 'Message Page',
                    'message' => 'Identifiant déjà pris !'
                ];
                $this->render("message", $data);
            }
            
        }

        

    }
    
}
?>