<?php
require_once "Controller.php";
require_once "./Utils/functions.php";
class Controller_register_former extends Controller{

    public function action_form_register_former() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
 
        $this->render("form_register_former");

    }

    public function action_default(){
        $this->action_form_register_former();
    }

    public function action_register_former(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }


        if (isset($_POST['submit'])) {


            $m = Model::getModel();
            $tab = check_data_former();
            

            
            


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

                elseif ($tab['phone'] == 'false') {
                    echo "Numéro de téléphone non conforme !";
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

                elseif ($tab['cv']['type'] == 'false') {
                    echo "Le CV doit être au format pdf !";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['cv'] == 'false') {
                    echo "CV non conforme !!";
                    $this->render("form_register_former");
                    
                }

                elseif ($tab['date_signature'] == 'false') {
                    echo "Veuillez signer !";
                    $this->render("form_register_former");
                    
                }
            

            $rep = $m->createFormer($tab);
            
            if (in_array("none",$rep)) {
                
                header("Location: ?controller=home_former&action=home_former");
                exit;
                
            }
            else {

                if (in_array("error_db",$rep)) {
                    echo "La transaction à été annulée";
                    $this->render("form_register_former");
                }
                if (in_array("id_already_take",$rep)) {
                    echo "Identifiant déjà pris !";
                    $this->render("form_register_former");
                }
            }
            
        }
        else {

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
                header("Location: ?controller=home_customer&action=home_customer");
            }
    
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
                header("Location: ?controller=home_former&action=home_former");
            }

            if (!isset($_SESSION['idutilisateur'])) {
                header("Location: ?controller=home&action=home");
            }

        }

        

    }

    
    
}
?>