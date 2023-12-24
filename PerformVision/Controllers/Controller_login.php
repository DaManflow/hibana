<?php
require_once "Controller.php";
class Controller_login extends Controller{
    public function action_login(){
        $this->render("form_login");

    }

    public function action_default(){
        $this->action_login();
    }

    public function action_connectUser() {

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

            if ($m->VerifConnectUser($tab)) {

                if ($_SESSION['role'] == "client") {
                    header("Location: ?controller=home_customer&action=home_customer");
                    exit;
                }

                if ($_SESSION['role'] == "formateur") {
                    header("Location: ?controller=home_former&action=home_former");
                    exit;
                }

            }
            else {
                echo "Mail ou mot de passe incorrect !";
                $this->render("form_login");
            }

        }

    }
}
?>