<?php
require_once "Controller.php";
class Controller_admin_list extends Controller{
    
    public function action_admin_pagination() {

        $m = Model::getModel();

        if (isset($_GET['start'])) {
            if (preg_match("/^[1-9]\d*$/", $_GET['start'])) {
                $page = $_GET['start'];
                $itemsPerPage = 25;
                $offset = ($page - 1) * $itemsPerPage;
    
                // Récupération des admins pour la page actuelle
                $printab = $m->getAdminsWithLimit($offset, $itemsPerPage);
                $pages = $m->getNbAdmin()/25;
                if (is_float($pages)) {
                    $pages = ceil($pages);
                }
                if ($pages == 0) {
                    $data = [
                                    'title' => 'Message Page',
                                    'message' => "Il n'y pas d'administrateur !"
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
                    // Afficher la page correspondante des admins
                    $data = [
                        'printab' => $printab,
                        'page' => $page,
                        'itemsPerPage' => $itemsPerPage,
                        'pages' => $pages,
                        
                    ];
                    $this->render("admin_pagination", $data);
                }
            }
            else {
                $_GET['start'] = 1;
                header("Location: ?controller=admin_list&action=admin_pagination&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=admin_list&action=admin_pagination&start=" . $_GET['start']);
        }


    }




    public function action_default(){
        $this->action_admin_pagination();
    }

    public function action_former_information_no_login() {
    
                
        header("Location: ?controller=login&action=login");
        exit;
            
        
            
    }

    


    
    // Affiche la page pour les admins qui affiche les formateurs avec leurs informations
    public function action_admin_information() {

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
                
                
                $this->render("admin_information", $data);
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
