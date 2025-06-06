<?php
require_once "Controller.php";
class Controller_login_customer extends Controller{
    public function action_login_customer(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
            header("Location: ?controller=home_moderateur&action=home_moderateur");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
            header("Location: ?controller=home_admin&action=home_admin");
        }
        
        $this->render("form_login_customer");

    }

    public function action_default(){
        $this->action_login_customer();
    }

    public function action_connectUser() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
            header("Location: ?controller=home_admin&action=home_admin");
        }
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
            header("Location: ?controller=home_moderator&action=home_moderator");
        }

        if (isset($_POST['submit'])) {
            $m = Model::getModel();
            $tab = check_data_user();
            

            if ($tab['email'] == 'false') {
                echo "Adresse email non conforme !!";
                $this->render("form_login_customer");
                
            }

            elseif ($tab['password'] == 'false') {
                echo "Mot de passe non conforme !!";
                $this->render("form_login_customer");
                
            }

            $rep = $m->VerifConnectUser($tab);

            if (in_array("none",$rep)) {

                if ($_SESSION['role'] == "client") {
                    header("Location: ?controller=home_customer&action=home_customer");
                    exit;
                }

                if ($_SESSION['role'] == "formateur") {
                    header("Location: ?controller=home_former&action=home_former");
                    exit;
                }

                if ($_SESSION['role'] == "administrateur") {
                    header("Location: ?controller=home_admin&action=home_admin");
                    exit;
                }

                if ($_SESSION['role'] == "moderateur") {
                    header("Location: ?controller=home_moderator&action=home_moderator");
                    exit;
                }


                

            }
            else {

                if (in_array("error_db", $rep)) {
                    echo "La transaction à été annulée";
                    $this->render("form_login_customer");
                }

                if (in_array("mail_mdp_error", $rep)) {
                    echo "Mail ou mot de passe incorrect !";
                    $this->render("form_login_customer");
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

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "administrateur") {
                header("Location: ?controller=home_admin&action=home_admin");
            }
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "moderateur") {
                header("Location: ?controller=home_moderator&action=home_moderator");
            }

        }

    }
}
?>
