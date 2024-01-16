<?php
require_once "Controller.php";
class Controller_former_list_admin extends Controller{
    
    public function action_former_pagination_admin() {

        $m = Model::getModel();

        if (isset($_GET['start'])) {
            if (preg_match("/^[1-9]\d*$/", $_GET['start'])) {
                $page = $_GET['start'];
                $itemsPerPage = 25;
                $offset = ($page - 1) * $itemsPerPage;
    
                // Récupération des prix nobels pour la page actuelle
                $printab = $m->getFormersUniqueWithLimit($offset, $itemsPerPage);
                $pages = $m->getNbFormer()/25;
                if (is_float($pages)) {
                    $pages = ceil($pages);
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
                    $this->render("former_pagination", $data);
                }
            }
            else {
                $_GET['start'] = 1;
                header("Location: ?controller=former_list_admin&action=former_pagination_admin&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=former_list_admin&action=former_pagination_admin&start=" . $_GET['start']);
        }


    }




    public function action_default(){
        $this->action_former_pagination_admin();
    }

    public function action_former_information_no_login() {
    
                
        header("Location: ?controller=login&action=login");
        exit;
            
        
            
    }

    


    

    public function action_former_information_customer() {

        if (isset($_SESSION['role']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("former_information_customer", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }

    public function action_former_information_former() {

        if (isset($_SESSION['idutilisateur']) && $_SESSION['role'] == "client") {
            header("Location: /hibana-main/PerformVision/?controller=home_customer&action=home_customer");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("former_information_former", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }


    public function action_former_information_admin() {

        if (isset($_SESSION['role']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("former_information_admin", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }

    public function action_former_information_moderator() {

        if (isset($_SESSION['role']) && $_SESSION['role'] == "formateur") {
            header("Location: /hibana-main/PerformVision/?controller=home_former&action=home_former");
        }

        if (!isset($_SESSION['idutilisateur'])) {
            header("Location: /hibana-main/PerformVision/?controller=former_list&action=former_information_no_login");
        }

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("former_information_moderator", $data);
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