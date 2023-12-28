<?php
require_once "Controller.php";
class Controller_login extends Controller{
    public function action_login(){

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
<<<<<<< HEAD
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
=======
            header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        }
        
        $this->render("form_login");

    }

    public function action_default(){
        $this->action_login();
    }

    public function action_connectUser() {

<<<<<<< HEAD
        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: ?controller=home_customer&action=home_customer");
        }

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
            header("Location: ?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: ?controller=home&action=home");
        }


=======
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
        if (isset($_POST['submit'])) {
            $m = Model::getModel();
            $tab = check_data_user();
            

            if ($tab['email'] == 'false') {
                echo "Adresse email non conforme !!";
                $this->render("form_login");
                
            }

            elseif ($tab['password'] == 'false') {
                echo "Mot de passe non conforme !!";
                $this->render("form_login");
                
            }

            $rep = $m->VerifConnectUser($tab);

            if (in_array("none",$rep)) {

                if ($_SESSION['role'] == "client") {
<<<<<<< HEAD
                    header("Location: ?controller=home_customer&action=home_customer");
=======
                    header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
                    exit;
                }

                if ($_SESSION['role'] == "formateur") {
<<<<<<< HEAD
                    header("Location: ?controller=home_former&action=home_former");
=======
                    header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
>>>>>>> 1ba5e94d06d15513dd11e8524c6e4b6fe6e8c756
                    exit;
                }

                

            }
            else {

                if (in_array("error_db", $rep)) {
                    echo "La transaction à été annulée";
                    $this->render("form_login");
                }

                if (in_array("mail_mdp_error", $rep)) {
                    echo "Mail ou mot de passe incorrect !";
                    $this->render("form_login");
                }

                
            }

        }
        else {

            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
                header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
            }
    
            if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "formateur") {
                header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
            }
    
            if (!isset($_SESSION['idutilisateur'])) {
                header("Location: /hibana-main/PerformVision/?controller=home&action=home");
            }

        }

    }
}
?>