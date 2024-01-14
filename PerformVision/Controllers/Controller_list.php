<?php
require_once "Controller.php";
class Controller_list extends Controller{

    public function action_last(){

        // $_POST['categorie'] = valeur du type
        // $_POST['locker'] = type du select
        // $_POST['filtrecategorie'] = valeur du filtre d'avant

        // On instancie le filtre quand on démarre la page
        if(!(isset($_POST['filtrecategorie']))){
            $filtrecat = [];
        }else{
            $filtrecat = unserialize($_POST['filtrecategorie']);
        }

        if(!(isset($_POST['filtresouscategorie']))){
            $filtresouscat = [];
        }else{
            $filtresouscat = unserialize($_POST['filtresouscategorie']);
        }

        if(!(isset($_POST['filtretheme']))){
            $filtretheme = [];
        }else{
            $filtretheme = unserialize($_POST['filtretheme']);
        }


        $filtre = ["categorie"=>$filtrecat, "souscategorie"=>$filtresouscat, "theme"=>$filtretheme];

        // Pour supprimer un élément dans le filtre

        if(isset($POST['deletelocker'])){
            $tabvaleur = explode("", $_POST['deletelocker']);   // Valeur de type string, ex="programation_categorie", transformé en tableau
            $type = $tabvaleur[1];  // Retourne le type choisi
            $valeur = $tabvaleur[0];    // Retourne la valeur dans le tableau du type (Ex : Programmation dans categorie )
            $tabtypefiltre = $filtre[$type];    // Retourne le tableau d'un des 3 types dans le filtre
            $idvalasupr = array_search($valeur, $tabtypefiltre);    // Retourne l'id de la valeur dans le tableau du type
            $filtre[] = $tabtypefiltre[$type][$idvalasupr];  // Débogage
            unset($tabtypefiltre[$type][$idvalasupr]);     // supprime la valeur dans le bon type
            /*
            $tabtypefiltre = $filtre[$valeur[1]]; // Retourne le tableau d'un type
            $idvalasupr = array_search($valeur[0], $tabtypefiltre); // Retourne l'id de la valeur à enlever dans le tableau de son type
            unset($tabtypefiltre[$idvalasupr]); // Supprime l'id*/
        }

        // Pour ajouter un élément dans le filtre
        if(isset($_POST['addlocker']) and !in_array($_POST[$_POST['addlocker']], $filtre[$_POST['addlocker']])){
            $filtre[$_POST['addlocker']][] = $_POST[$_POST['addlocker']];
        }


        if(!array_search(0, $filtre['categorie']) and count($filtre['categorie']) <= 1){
            $valPourRequetecat = 0;
        }else{
            $valPourRequetecat = $filtre['categorie'];
        }


       $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listSousCategories"=>$m->getSousCategories($valPourRequetecat), // Une optimisation au niveau des requêtes peut-être envisagé dans listSousCategories pour prendre toutes les catégories mères même si il n'apparait pas dans le filtre
            "listCategories"=>$m->getCategoriesMeres(),
            "formateurs"=>$m->getFormateurs(),
            "filtre"=>$filtre
        ];
        $this->render("last", $data);
        
    }
    public function action_default(){
        $this->action_last();
    }
    public function action_list_categorieMere(){

        $m = Model::getModel();
        $data = [
            "themes"=>$m->getThemes(),
            "listCategories"=>$m->getCategories(),
            "formateurs"=>$m->getFormateurs(),
        ];
        $this->render("last", $data);
        
    }

}
?>