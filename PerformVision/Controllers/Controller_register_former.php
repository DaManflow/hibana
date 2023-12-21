<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_register_former extends Controller{

    public function action_form_register_former() {
 
        $this->render("form_register_former");

    }

    public function action_default(){
        $this->action_form_register_former();
    }

    public function action_register_former(){
        if (isset($_POST['submit'])) {
            $m = Model::getModel();
            $tab = check_data_former();

            if (! $tab) {
                $data = [
                    'title' => 'Message Page',
                    'message' => 'Un champ a mal été rempli !'
                ];
                $this->render("message", $data);
            }
            
            if ($m->createFormer($tab)) {
                
                
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