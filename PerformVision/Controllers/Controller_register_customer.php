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

            if ($tab['name'] == 'false') {
                echo "Le nom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                $this->render("form_register_customer");
                
            }
                    
            elseif ($tab['surname'] == 'false') {
                echo "Le prénom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                $this->render("form_register_customer");
                
            }

            elseif ($tab['email'] == 'false') {
                echo "Adresse email non conforme !!";
                $this->render("form_register_customer");
                
            }

            elseif ($tab['password'] == 'false') {
                echo "Mot de passe non conforme !!";
                $this->render("form_register_customer");
                
            }

            
            if ($m->createCustomer($tab)) {

                header("Location: ?controller=home_customer&action=home_customer");
                exit;
            }
            else {
                echo "Identifiant déjà pris !";
                $this->render("form_register_customer");
            }
            
        }

        

    }
    
}
?>