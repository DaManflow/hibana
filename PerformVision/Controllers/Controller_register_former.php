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
            var_dump($tab);

            
            


                if ($tab['name'] == 'false') {
                    echo "Le nom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                    $this->render("form_register_former");
                    
                }
                        
                elseif ($tab['surname'] == 'false') {
                    echo "Le prénom n'est pas valide. Assurez-vous d'entrer uniquement des caractères alphabétiques.";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['email'] == 'false') {
                    echo "Adresse email non conforme !!";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['password'] == 'false') {
                    echo "Mot de passe non conforme !!";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['linkedin'] == 'false') {
                    echo "Linkedin non conforme !!";
                    $this->render("form_register_former");
                    
                }
    
                elseif ($tab['cv'] == 'false') {
                    echo "CV non conforme !!";
                    $this->render("form_register_former");
                    
                }
            
            
            if ($m->createFormer($tab)) {
                
                header("Location: ?controller=home_former&action=home_former");
                exit;
                
            }
            else {
                echo "Identifiant déjà pris !";
                $this->render("form_register_former");
            }
            
        }

        

    }

    
    
}
?>