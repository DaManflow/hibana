<?php
require_once "Controller.php";
class Controller_former_list extends Controller{
    public function action_former_list(){
        $m = Model::getModel();
        $data = [
            'infos' => $m->getFormersWithLimit(),
        ];
        

        $this->render("former_list", $data);

    }
    public function action_default(){
        $this->action_former_list();
    }

    public function action_former_information() {
        

        if (isset($_GET['id']) && preg_match("/^[1-9][0-9]*$/", $_GET['id'])) {
            
                
            $m = Model::getModel();
            $data = [
                'infos' => $m->getFormerInformations($_GET['id']),
            ];
            if ($data['infos']) {
                
                
                $this->render("former_information", $data);
            }
            else {
                $this->action_error("L'identifiant n'existe pas !");
            }
            
    }
    else {
        $this->action_error("Aucun identifiant renseigné !");
    }

    }


    public function action_former_pagination() {

        $m = Model::getModel();

        if (isset($_GET['start'])) {
            if (preg_match("/^[1-9]\d*$/", $_GET['start'])) {
                $page = $_GET['start'];
                $itemsPerPage = 25;
                $offset = ($page - 1) * $itemsPerPage;
    
                // Récupération des prix nobels pour la page actuelle
                $printab = $m->getFormersWithLimit($offset, $itemsPerPage);
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
                header("Location: ?controller=former_list&action=former_pagination&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=former_list&action=former_pagination&start=" . $_GET['start']);
        }


    }

}
?>