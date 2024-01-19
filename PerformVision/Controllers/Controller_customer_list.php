<?php
require_once "Controller.php";
class Controller_customer_list extends Controller{
    
    public function action_customer_pagination() {

        $m = Model::getModel();

        if (isset($_GET['start'])) {
            if (preg_match("/^[1-9]\d*$/", $_GET['start'])) {
                $page = $_GET['start'];
                $itemsPerPage = 25;
                $offset = ($page - 1) * $itemsPerPage;
    
                // Récupération des prix nobels pour la page actuelle
                $printab = $m->getCustomersWithLimit($offset, $itemsPerPage);
                $pages = $m->getNbCustomers()/25;
                if (is_float($pages)) {
                    $pages = ceil($pages);
                }
                if ($pages == 0) {
                    $data = [
                                    'title' => 'Message Page',
                                    'message' => "Il n'y pas de clients !"
                                ];
                                $this->render("message", $data);
                            }
                if ($page > $pages) {
                    // Afficher un message d'erreur si la page demandée dépasse le nombre total de pages
                    $data = [
                        'title' => 'Message Page',
                        'message' => "La page n'existe pas"
                    ];
                    $this->render("message", $data);
                    
                } else {
                    // Afficher la page correspondante des prix nobels
                    $data = [
                        'printab' => $printab,
                        'page' => $page,
                        'itemsPerPage' => $itemsPerPage,
                        'pages' => $pages,
                        
                    ];
                    $this->render("customer_pagination", $data);
                }
            }
            else {
                $_GET['start'] = 1;
                header("Location: ?controller=customer_list&action=customer_pagination&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=customer_list&action=customer_pagination&start=" . $_GET['start']);
        }


    }




    public function action_default(){
        $this->action_customer_pagination();
    }

    public function action_former_information_no_login() {
    
                
        header("Location: ?controller=login&action=login");
        exit;
            
        
            
    }

    


    

    public function action_customer_information_admin() {

        if (isset($_SESSION['role']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getCustomerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("customer_information_admin", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }



    public function action_customer_information_moderator() {

        if (isset($_SESSION['role']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getCustomerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("customer_information_moderator", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }

    

    


    



    }




?>