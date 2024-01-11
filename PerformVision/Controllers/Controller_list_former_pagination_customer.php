<?php
require_once "Controller.php";
class Controller_list_former_pagination_customer extends Controller{
    public function action_former_pagination_message_customer() {
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
                    $this->render("list_former_customer", $data);
                }
            }
            else {
                $_GET['start'] = 1;
                header("Location: ?controller=list_former_pagination_customer&action=former_pagination_message_customer&start=" . $_GET['start']);
            }

        }
        else {
            $_GET['start'] = 1;
            header("Location: ?controller=list_former_pagination_customer&action=former_pagination_message_customer&start=" . $_GET['start']);
        }
    }
    public function action_default(){
        $this->action_former_pagination_message_customer();
    }
}
?>