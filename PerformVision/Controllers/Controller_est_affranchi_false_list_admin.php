<?php
require_once "Controller.php";
class Controller_est_affranchi_false_list_admin extends Controller{
    
    public function action_est_affranchi_false_pagination_admin() {

        $m = Model::getModel();

        if (isset($_GET['start'])) {
            if (preg_match("/^[1-9]\d*$/", $_GET['start'])) {
                $page = $_GET['start'];
                $itemsPerPage = 25;
                $offset = ($page - 1) * $itemsPerPage;
    
                // Récupération les utilisateurs non affranchi avec un limite pour la page actuelle
                $printab = $m->getEstAffranchiFalseWithLimit($offset, $itemsPerPage);
                $pages = $m->getNbEstAffranchiFalse()/25;
                if (is_float($pages)) {
                    $pages = ceil($pages);
                }
		if ($pages == 0) {
		$data = [
                        'title' => 'Message Page',
                        'message' => "Il n'y pas de membre non-affranchi !"
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
                    // Afficher la page correspondante des utilisateurs non affranchi
                    $data = [
                        'printab' => $printab,
                        'page' => $page,
                        'itemsPerPage' => $itemsPerPage,
                        'pages' => $pages,
                        
                    ];
                    $this->render("est_affranchi_false_pagination_admin", $data);
                }
            }
            else {
                $_GET['start'] = 1;
                header("Location: ?controller=est_affranchi_false_list_admin&action=est_affranchi_false_pagination_admin&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=est_affranchi_false_list_admin&action=est_affranchi_false_pagination_admin&start=" . $_GET['start']);
        }


    }

    public function action_default(){
        $this->action_est_affranchi_false_pagination_admin();
    }


}




?>
